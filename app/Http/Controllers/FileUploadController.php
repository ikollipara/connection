<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'file' => 'file|required_without_all:image,url',
            'image' => 'image|required_without_all:file,url',
            'url' => 'url|required_without_all:image,file',
        ]);

        $path = isset($validated['url'])
            ? $this->saveUrl($validated['url'])
            : $this->saveFile($request->file('file') ?? $request->file('image'));

        return response()->json([
            'success' => $path ? 1 : 0,
            'file' => [
                'url' => $path ? Storage::url($path) : '',
            ],
        ]);
    }

    public function destroy(Request $request): void
    {
        $validated = $request->validate([
            'path' => 'required|string',
        ]);

        if (str($validated['path'])->startsWith('/storage/')) {
            $validated['path'] = str($validated['path'])->replace('/storage/', '');
        }

        Storage::disk('public')->delete($validated['path']);
    }

    private function saveFile(UploadedFile $file)
    {
        return $file->store('files', 'public');
    }

    private function saveUrl(string $url)
    {
        $request = Http::get($url);
        if ($request->failed()) {
            return false;
        }

        $ext = str($request->header('content-type'))
            ->split("/\//")
            ->last();
        $hashName = Str::random(40);
        $successful = Storage::disk('public')->put("files/{$hashName}.{$ext}", $request->body());

        return $successful ? "files/{$hashName}.{$ext}" : false;
    }
}
