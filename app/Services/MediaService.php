<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

class MediaService
{
    protected array $allowedMimes = [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/svg+xml',
        'application/pdf',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'text/plain',
    ];

    protected array $allowedExtensions = [
        'jpg', 'jpeg', 'png', 'webp', 'svg', 'pdf', 'docx', 'txt',
    ];

    public function upload(UploadedFile $file, ?string $altText = null, string $disk = 'public'): Media
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $mime = $file->getMimeType();

        if (! in_array($extension, $this->allowedExtensions, true) || ! in_array($mime, $this->allowedMimes, true)) {
            throw new InvalidArgumentException("File type '{$extension}' ({$mime}) is not allowed for upload.");
        }

        // SVG sanitization check: disallow scripts or event handlers inside SVG
        if ($extension === 'svg' || $mime === 'image/svg+xml') {
            $content = file_get_contents($file->getRealPath());
            if (preg_match('/<script|onload|onerror|onclick|javascript:/i', $content)) {
                throw new InvalidArgumentException('Uploaded SVG contains potentially unsafe script content and was rejected.');
            }
        }

        $filename = Str::uuid().'.'.$extension;
        $folder = 'media/'.date('Y/m');
        $path = $file->storeAs($folder, $filename, $disk);

        $width = null;
        $height = null;
        if (str_starts_with($mime, 'image/') && $extension !== 'svg') {
            $imageInfo = @getimagesize($file->getRealPath());
            if ($imageInfo) {
                $width = $imageInfo[0];
                $height = $imageInfo[1];
            }
        }

        return Media::create([
            'workspace_id' => WorkspaceResolver::currentId(),
            'disk' => $disk,
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $mime,
            'size' => $file->getSize(),
            'width' => $width,
            'height' => $height,
            'alt_text' => $altText ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'processing_status' => 'ready',
        ]);
    }

    public function delete(Media $media): bool
    {
        if ($media->isReferenced()) {
            throw new InvalidArgumentException('Cannot delete media item because it is currently referenced by portfolio content.');
        }

        if (Storage::disk($media->disk)->exists($media->path)) {
            Storage::disk($media->disk)->delete($media->path);
        }

        return $media->delete();
    }
}
