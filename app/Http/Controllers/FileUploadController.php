<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

final class FileUploadController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'file' => 'file|required_without_all:image,url',
            'image' => 'image|required_without_all:file,url',
            'url' => 'url|required_without_all:image,file',
        ]);

        $path = match (true) {
            isset($validated['url']) => $this->saveUrl($validated['url']),
            isset($validated['file']) => $validated['file']->store('files', 'public'),
            isset($validated['image']) => $validated['image']->store('files', 'public'),
            default => throw new InvalidArgumentException('Missing url, file, or image'),
        };

        return response(
            content: [
                'success' => filled($path) ? 1 : 0,
                'file' => [
                    'url' => filled($path) ? Storage::url($path) : '',
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
        $response = Http::get($url);
        if ($response->failed()) {
            return $response->failed();
        }

        $ext = str($response->header('content-type'))
            ->split("/\//")
            ->last();
        $hashName = Str::random(40);
        $successful = Storage::disk('public')->put("files/{$hashName}.{$ext}", $response->body());

        return $successful ? "files/{$hashName}.{$ext}" : false;
    }
}
