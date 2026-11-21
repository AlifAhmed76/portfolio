<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CodeFile;
use App\Services\CodeEditorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CodeEditorController extends Controller
{
    public function __construct(
        protected CodeEditorService $codeService
    ) {}

    public function index(Request $request): View
    {
        // Enforce owner role
        if ($request->user()?->role !== 'owner') {
            abort(403, 'Unauthorized access to Code Editor. Owner privilege required.');
        }

        $tree = $this->codeService->getTree();
        $initialFile = $tree[0]['relative_path'] ?? null;
        $initialData = $initialFile ? $this->codeService->readFile($initialFile) : null;

        return view('admin.code-editor.index', compact('tree', 'initialData'));
    }

    public function open(Request $request): JsonResponse
    {
        if ($request->user()?->role !== 'owner') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $path = (string) $request->input('path');

        try {
            $data = $this->codeService->readFile($path);
            $codeFile = CodeFile::where('relative_path', $data['relative_path'])->first();
            $revisions = $codeFile ? $codeFile->revisions()->with('creator:id,name')->take(15)->get() : [];

            return response()->json([
                'success' => true,
                'file' => $data,
                'revisions' => $revisions,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function save(Request $request): JsonResponse
    {
        if ($request->user()?->role !== 'owner') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'path' => 'required|string',
            'content' => 'present|string',
        ]);

        try {
            $result = $this->codeService->saveFile(
                $request->input('path'),
                $request->input('content'),
                $request->user()->id
            );

            return response()->json([
                'success' => true,
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function restore(Request $request): JsonResponse
    {
        if ($request->user()?->role !== 'owner') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'path' => 'required|string',
            'revision_number' => 'required|integer',
        ]);

        try {
            $codeFile = CodeFile::where('relative_path', $request->input('path'))->firstOrFail();
            $this->codeService->restoreRevision($codeFile, (int) $request->input('revision_number'), $request->user()->id);

            return response()->json([
                'success' => true,
                'message' => "Revision #{$request->input('revision_number')} restored successfully.",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
