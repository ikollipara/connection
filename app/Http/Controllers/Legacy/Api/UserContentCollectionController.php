<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContentCollection;
use App\Models\User;
use App\ValueObjects\Editor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class UserContentCollectionController extends Controller
{
    public function index(Request $request, User $user): JsonResponse
    {

        /** @var \Closure(ContentCollection): array{id: mixed, title: mixed, hasEntry: mixed} */
        // @phpstan-ignore varTag.nativeType
        $transformer = function (ContentCollection $collection): array {
            return [
                'id' => $collection->id,
                'title' => $collection->title,
                /** @phpstan-ignore-next-line */
                'hasEntry' => $collection->has_entry,
            ];
        };

        return new JsonResponse(
            data: [
                'collections' => $user
                    ->collections()
                    ->withHasEntry($request->input('content_id'))
                    ->get()
                    ->map($transformer),
            ],
            status: Response::HTTP_OK,
        );
    }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request, User $user)
    // {
    //     $body = $request->input('body', '');
    //     $title = $request->input('title', '');

    //     try {
    //         $collection = $user->collections()->create([
    //             'title' => $title,
    //             'body' => Editor::fromJson($body),
    //         ]);

    //         info('Collection created', ['collection' => $collection, 'user' => $user]);

    //         return response(
    //             content: [
    //                 'formAction' => route('api.users.collections.update', [$user, $collection]),
    //                 'drawerAction' => route('users.collections.publish', [$user, $collection]),
    //                 'url' => route('users.collections.edit', [$user, $collection]),
    //                 'title' => $collection->title,
    //             ],
    //             status: Response::HTTP_CREATED,
    //         );
    //     } catch (\Throwable $th) {
    //         $message = $th->getMessage();
    //         logger()->error('Collection creation failed', ['user' => $user, 'error' => $message]);

    //         return response(
    //             content: [
    //                 'message' => $message,
    //             ],
    //             status: Response::HTTP_INTERNAL_SERVER_ERROR,
    //         );
    //     }
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, User $user, ContentCollection $collection)
    // {
    //     $body = $request->input('body', json_encode($collection->body));
    //     $title = $request->input('title', $collection->title);

    //     try {
    //         $collection->update([
    //             'title' => $title,
    //             'body' => Editor::fromJson($body),
    //         ]);

    //         info('Collection updated', ['collection' => $collection, 'user' => $user]);

    //         return response(
    //             content: [
    //                 'formAction' => route('api.users.collections.update', [$user, $collection]),
    //                 'drawerAction' => route('users.collections.publish', [$user, $collection]),
    //                 'url' => route('users.collections.edit', [$user, $collection]),
    //                 'title' => $collection->title,
    //             ],
    //             status: Response::HTTP_OK,
    //         );
    //     } catch (\Throwable $th) {
    //         $message = $th->getMessage();
    //         logger()->error('Collection update failed', ['user' => $user, 'error' => $message]);

    //         return response(
    //             content: [
    //                 'message' => $message,
    //             ],
    //             status: Response::HTTP_INTERNAL_SERVER_ERROR,
    //         );
    //     }
    // }
}
