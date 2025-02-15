<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\ContentCollection;
use App\Models\User;
use App\ValueObjects\Editor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Js;

final class UserContentCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, User $user)
    {
        $status = Status::tryFrom($request->query('status', 'draft')) ?? Status::draft();
        $q = $request->query('q');

        $collections = $user->collections()->search($q)->status($status)->latest()->paginate(15)->withQueryString();

        return view('users.collections.index', [
            'collections' => $collections,
            'status' => $status,
            'user' => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $user)
    {
        return view('users.collections.create', ['user' => $user, 'collection' => new ContentCollection]);
    }

    public function store(Request $request, User $user)
    {

        $body = $request->input('body') ?? '{"blocks": []}';
        $title = $request->input('title') ?? '';

        $collection = $user->collections()->make([
            'title' => $title,
            'body' => Editor::fromJson($body),
        ]);
        $result = $collection->save();
        if (!$result) return session_back()->with('error', 'Collection creation failed');

        info('Collection created', ['collection' => $collection, 'user' => $user]);

        return redirect()->route('users.collections.edit', [$user, $collection])->with('success', 'Collection created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user, ContentCollection $collection)
    {
        return view('users.collections.edit', ['user' => $user, 'collection' => $collection->load('entries')]);
    }

    public function update(Request $request, User $user, ContentCollection $collection)
    {
        $body = $request->input('body') ?? Js::encode($collection->body);
        $title = $request->input('title') ?? $collection->title;

        $result = $collection->update([
            'title' => $title,
            'body' => Editor::fromJson($body),
        ]);

        if (!$result) return session_back()->with('error', 'Collection update failed');

        info('Collection updated', ['collection' => $collection, 'user' => $user]);

        return redirect()->route('users.collections.edit', [$user, $collection])->with('success', 'Collection updated successfully');
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('owner', only: ['index', 'create', 'store']),
            new Middleware('owner:collection', only: ['edit', 'update']),
        ];
    }
}
