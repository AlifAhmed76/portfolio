<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PortfolioBackup extends Command
{
    protected $signature = 'portfolio:backup';
    protected $description = 'Generate full database and media backup with SHA-256 checksums';

    public function handle(): int
    {
        $this->info('Starting portfolio backup routine...');

        $timestamp = date('Y_m_d_His');
        $backupDir = storage_path("app/backups/backup_{$timestamp}");

        if (! File::isDirectory($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        // 1. Export database records to structured JSON/SQL dump
        $this->line('Exporting database tables...');
        $tables = [
            'workspaces',
            'users',
            'profiles',
            'contact_details',
            'social_links',
            'site_settings',
            'activity_logs',
            'media',
            'media_attachments',
            'project_categories',
            'projects',
            'project_details',
            'project_links',
            'skill_categories',
            'skills',
            'project_skill',
            'experiences',
            'educations',
            'services',
            'homepage_sections',
            'themes',
            'workspace_themes',
            'theme_settings',
            'theme_revisions',
            'page_templates',
            'pages',
            'page_revisions',
            'code_files',
            'code_revisions',
            'post_categories',
            'post_tags',
            'posts',
            'post_post_tag',
            'contact_messages',
        ];

        $databaseDump = [];
        foreach ($tables as $table) {
            try {
                if (DB::getSchemaBuilder()->hasTable($table)) {
                    $databaseDump[$table] = DB::table($table)->get()->toArray();
                }
            } catch (\Exception $e) {
                // Table might not exist or error
            }
        }

        $dbDumpFile = "{$backupDir}/database_export.json";
        File::put($dbDumpFile, json_encode($databaseDump, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $dbHash = hash_file('sha256', $dbDumpFile);

        // 2. Backup media files
        $this->line('Archiving media assets...');
        $mediaSrc = storage_path('app/public');
        $mediaDest = "{$backupDir}/media";
        $mediaCount = 0;

        if (File::isDirectory($mediaSrc)) {
            File::copyDirectory($mediaSrc, $mediaDest);
            $mediaCount = count(File::allFiles($mediaDest));
        }

        // 3. Generate manifest with SHA-256 checksums
        $manifest = [
            'backup_timestamp' => $timestamp,
            'created_at' => date('c'),
            'database_export' => [
                'filename' => 'database_export.json',
                'tables_count' => count($databaseDump),
                'sha256' => $dbHash,
                'size_bytes' => filesize($dbDumpFile),
            ],
            'media' => [
                'files_count' => $mediaCount,
            ],
            'system_info' => [
                'php_version' => PHP_VERSION,
                'laravel_version' => app()->version(),
                'environment' => app()->environment(),
            ],
        ];

        $manifestFile = "{$backupDir}/manifest.json";
        File::put($manifestFile, json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $manifestHash = hash_file('sha256', $manifestFile);

        $this->info("Backup generated successfully at: {$backupDir}");
        $this->table(
            ['Artifact', 'Details', 'SHA-256 Checksum'],
            [
                ['Database Export', count($databaseDump) . ' tables (' . round(filesize($dbDumpFile) / 1024, 2) . ' KB)', substr($dbHash, 0, 24) . '...'],
                ['Media Assets', "{$mediaCount} files", '—'],
                ['Manifest', 'manifest.json', substr($manifestHash, 0, 24) . '...'],
            ]
        );

        return self::SUCCESS;
    }
}
