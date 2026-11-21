<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Media;
use App\Services\MediaService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function __construct(protected MediaService $mediaService)
    {
    }

    public function index(Request $request): View
    {
        $query = Media::query()->latest();

        if ($request->filled('type')) {
            if ($request->type === 'image') {
                $query->where('mime_type', 'like', 'image/%');
            } elseif ($request->type === 'document') {
                $query->where('mime_type', 'not like', 'image/%');
            }
        }

        if ($request->filled('search')) {
            $query->where('original_name', 'like', '%' . $request->search . '%')
                  ->orWhere('alt_text', 'like', '%' . $request->search . '%');
        }

        $mediaItems = $query->paginate(24)->withQueryString();

        return view('admin.media.index', compact('mediaItems'));
    }

    public function upload(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'max:20480'], // max 20MB
            'alt_text' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $media = $this->mediaService->upload($request->file('file'), $request->alt_text);

            ActivityLog::log('media.upload', [
                'name' => $media->original_name,
                'mime' => $media->mime_type,
            ], $media);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'media' => $media,
                    'url' => $media->url,
                ]);
            }

            return back()->with('success', "File '{$media->original_name}' uploaded successfully.");
        } catch (Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => $e->getMessage()], 422);
            }

            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Media $media): RedirectResponse
    {
        try {
            $name = $media->original_name;
            $this->mediaService->delete($media);

            ActivityLog::log('media.delete', ['name' => $name]);

            return back()->with('success', "Media '{$name}' deleted successfully.");
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
