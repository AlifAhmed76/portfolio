<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\CodeFile;
use App\Models\CodeRevision;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Process\Process;

class CodeEditorService
{
    public const ALLOWED_EXTENSIONS = ['blade.php', 'php', 'css', 'js', 'json'];

    protected array $allowlistedDirs = [
        'resources/views/themes',
    ];

    public function __construct(
        protected CacheInvalidationService $cache
    ) {}

    /**
     * Resolve and strictly validate a relative file path against allowlist and traversal attempts.
     *
     * @param string $relativePath
     * @return string Normalized, canonical absolute path
     * @throws ValidationException
     */
    public function validateAndResolvePath(string $relativePath): string
    {
        // 1. Sanitize input string
        $path = str_replace('\\', '/', trim($relativePath));

        // 2. Traversal & dangerous character protection
        if (
            str_contains($path, '..') ||
            str_contains($path, chr(0)) ||
            str_starts_with($path, '/') ||
            preg_match('/^[a-zA-Z]:/', $path) || // Windows drive letters
            preg_match('/(^|\/)\./', $path) // Hidden files or directories (.env, .git)
        ) {
            throw ValidationException::withMessages([
                'path' => 'Security violation: illegal path traversal or unauthorized file pattern detected.',
            ]);
        }

        // 3. Denylist check
        $denylist = ['.env', 'config', 'routes', 'vendor', 'bootstrap', 'storage', 'database', 'app', 'artisan', 'tests'];
        foreach ($denylist as $blocked) {
            if (str_starts_with($path, $blocked . '/') || $path === $blocked) {
                throw ValidationException::withMessages([
                    'path' => "Security violation: access to protected directory '{$blocked}' is strictly forbidden.",
                ]);
            }
        }

        // 4. Allowlist directory check
        $matchedAllowlist = false;
        foreach ($this->allowlistedDirs as $allowedDir) {
            if (str_starts_with($path, $allowedDir . '/') || $path === $allowedDir) {
                $matchedAllowlist = true;
                break;
            }
        }

        if (! $matchedAllowlist) {
            throw ValidationException::withMessages([
                'path' => 'Security violation: path is outside allowlisted theme directories.',
            ]);
        }

        // 5. Allowed extension check
        $validExt = false;
        foreach (self::ALLOWED_EXTENSIONS as $ext) {
            if (str_ends_with(strtolower($path), '.' . $ext) || str_ends_with(strtolower($path), $ext)) {
                $validExt = true;
                break;
            }
        }

        if (! $validExt) {
            throw ValidationException::withMessages([
                'path' => 'Unsupported or prohibited file extension.',
            ]);
        }

        $fullPath = base_path($path);

        // 6. Realpath boundary check if file exists
        if (file_exists($fullPath)) {
            $realPath = realpath($fullPath);
            $realBasePath = realpath(base_path());

            if (! $realPath || ! str_starts_with(str_replace('\\', '/', $realPath), str_replace('\\', '/', $realBasePath))) {
                throw ValidationException::withMessages([
                    'path' => 'Security violation: resolved path escapes base project directory.',
                ]);
            }
        }

        return $fullPath;
    }

    /**
     * Get the file tree of all allowlisted editable files.
     */
    public function getTree(): array
    {
        $tree = [];

        foreach ($this->allowlistedDirs as $allowedDir) {
            $fullDir = base_path($allowedDir);
            if (! is_dir($fullDir)) {
                continue;
            }

            $files = File::allFiles($fullDir);
            foreach ($files as $file) {
                $relPath = str_replace('\\', '/', substr($file->getPathname(), strlen(base_path()) + 1));
                
                // Determine file type
                $extension = 'blade';
                if (str_ends_with($relPath, '.css')) $extension = 'css';
                elseif (str_ends_with($relPath, '.js')) $extension = 'js';
                elseif (str_ends_with($relPath, '.json')) $extension = 'json';

                $tree[] = [
                    'relative_path' => $relPath,
                    'name' => $file->getFilename(),
                    'size' => $file->getSize(),
                    'type' => $extension,
                    'modified_at' => date('Y-m-d H:i:s', $file->getMTime()),
                ];
            }
        }

        return $tree;
    }

    /**
     * Read the content of an allowlisted file.
     */
    public function readFile(string $relativePath): array
    {
        $fullPath = $this->validateAndResolvePath($relativePath);

        if (! file_exists($fullPath)) {
            throw ValidationException::withMessages([
                'path' => 'File not found.',
            ]);
        }

        $content = File::get($fullPath);
        $hash = hash('sha256', $content);

        return [
            'relative_path' => str_replace('\\', '/', $relativePath),
            'content' => $content,
            'hash' => $hash,
            'size' => strlen($content),
        ];
    }

    /**
     * Validate syntax of PHP/Blade or JSON code.
     *
     * @param string $relativePath
     * @param string $content
     * @throws ValidationException
     */
    public function validateSyntax(string $relativePath, string $content): void
    {
        if (str_ends_with($relativePath, '.json')) {
            try {
                json_decode($content, true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                throw ValidationException::withMessages([
                    'content' => 'Syntax error in JSON: ' . $e->getMessage(),
                ]);
            }
            return;
        }

        if (str_ends_with($relativePath, '.php')) {
            // Write to temporary scratch file for php -l check
            $scratchDir = storage_path('framework/cache');
            if (! is_dir($scratchDir)) {
                mkdir($scratchDir, 0755, true);
            }
            $tempFile = $scratchDir . '/syntax_check_' . uniqid() . '.php';
            file_put_contents($tempFile, $content);

            $phpBinary = PHP_BINARY ?: 'php';
            $process = new Process([$phpBinary, '-l', $tempFile]);
            $process->run();

            @unlink($tempFile);

            if (! $process->isSuccessful()) {
                $errorOutput = $process->getErrorOutput() ?: $process->getOutput();
                throw ValidationException::withMessages([
                    'content' => 'PHP syntax error detected: ' . trim($errorOutput),
                ]);
            }
        }
    }

    /**
     * Save an edited file with pre-save backup revision and SHA-256 tracking.
     */
    public function saveFile(string $relativePath, string $content, ?int $userId = null): array
    {
        $fullPath = $this->validateAndResolvePath($relativePath);
        $normalizedRelPath = str_replace('\\', '/', $relativePath);

        // Validate syntax before modifying any disk file
        $this->validateSyntax($normalizedRelPath, $content);

        return DB::transaction(function () use ($fullPath, $normalizedRelPath, $content, $userId) {
            $codeFile = CodeFile::firstOrCreate(
                ['relative_path' => $normalizedRelPath],
                [
                    'file_type' => $this->detectFileType($normalizedRelPath),
                    'current_hash' => file_exists($fullPath) ? hash('sha256', File::get($fullPath)) : '',
                    'last_modified_by' => $userId,
                ]
            );

            // 1. If file already exists, create snapshot revision of old content
            if (file_exists($fullPath)) {
                $existingContent = File::get($fullPath);
                $existingHash = hash('sha256', $existingContent);

                $maxRev = CodeRevision::where('code_file_id', $codeFile->id)->max('revision_number') ?? 0;
                CodeRevision::create([
                    'code_file_id' => $codeFile->id,
                    'revision_number' => $maxRev + 1,
                    'content' => $existingContent,
                    'hash' => $existingHash,
                    'created_by' => $userId,
                    'created_at' => now(),
                ]);
            }

            // 2. Write new content securely
            File::put($fullPath, $content, true);

            // 3. Update CodeFile record
            $newHash = hash('sha256', $content);
            $codeFile->update([
                'current_hash' => $newHash,
                'last_modified_by' => $userId,
            ]);

            ActivityLog::log('code_editor.saved', [
                'relative_path' => $normalizedRelPath,
                'hash' => $newHash,
            ]);

            $this->cache->flushFrontend();

            return [
                'relative_path' => $normalizedRelPath,
                'hash' => $newHash,
                'message' => 'File saved successfully.',
            ];
        });
    }

    /**
     * Restore a previous revision for a code file.
     */
    public function restoreRevision(CodeFile $codeFile, int $revisionNumber, ?int $userId = null): void
    {
        $revision = CodeRevision::where('code_file_id', $codeFile->id)
            ->where('revision_number', $revisionNumber)
            ->firstOrFail();

        $this->saveFile($codeFile->relative_path, $revision->content, $userId);

        ActivityLog::log('code_editor.restored', [
            'relative_path' => $codeFile->relative_path,
            'revision_number' => $revisionNumber,
        ]);
    }

    protected function detectFileType(string $path): string
    {
        if (str_ends_with($path, '.css')) return 'css';
        if (str_ends_with($path, '.js')) return 'js';
        if (str_ends_with($path, '.json')) return 'json';
        return 'blade';
    }
}
