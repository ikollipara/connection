<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class FileUploadController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'file' => 'file|required_without_all:image,url',
            'image' => 'image|required_without_all:file,url',
            'url' => 'url|required_without_all:image,file',
        ]);

        $path = false;
        if (isset($validated['url'])) $path = $this->saveUrl($validated['url']);
        if (isset($validated['file'])) $path = $validated['file']->store('files', 'public');
        if (isset($validated['image'])) $path = $validated['image']->store('files', 'public');


        return response(
            content: [
                'success' => $path ? 1 : 0,
                'file' => [
                    'url' => $path ? Storage::url($path) : '',
                ],
            ],
            status: Response::HTTP_OK,
        );
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'path' => 'required|string',
        ]);

        if (str($validated['path'])->startsWith('/storage/')) {
            $validated['path'] = str($validated['path'])->replace('/storage/', '');
        }

        Storage::disk('public')->delete($validated['path']);
    }

    protected function saveUrl(string $url)
    {
        $response = \Http::get($url);
        if ($response->failed()) return false;

        $ext = str($response->header('content-type'))
            ->split("/\//")
            ->last();
        $hashName = Str::random(40);
        $successful = Storage::disk('public')->put("files/{$hashName}.{$ext}", $response->body());

        return $successful ? "files/{$hashName}.{$ext}" : false;
    }
}
