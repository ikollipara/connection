<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\Grade;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\ValueObjects\Editor;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Arr;
use Illuminate\View\View;

final class RegisteredUserController extends Controller
{
    public function create(Request $request): View
    {
        return view('auth.register.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'bio' => 'json',
            'grades' => 'array',
            'grades.*' => 'enum:'.Grade::class,
            'school' => 'required|string',
            'subject' => 'required|string',
            'years_of_experience' => 'required_without:is_preservice|integer|min:0',
            'is_preservice' => 'required_without:years_of_experience|sometimes|accepted',
            'consented.full_name' => 'nullable|string',
        ]);

        data_set($validated, 'bio', Editor::fromJson($validated['bio']));
        data_set($validated, 'consented', filled(data_get($validated, 'consented.full_name')));
        data_set($validated, 'is_preservice', isset($validated['is_preservice']));
        data_set($validated, 'gender', '');

        DB::transaction(function () use ($validated) {
            $user = User::create(Arr::only($validated, ['email', 'first_name', 'last_name', 'consented']));
            $user->profile()->create(Arr::except($validated, ['email', 'first_name', 'last_name', 'consented']));
        });

        return to_route('login')->with('success', 'Please login to continue.');
    }

    public static function middleware(): array
    {
        return [
            new Middleware('guest'),
        ];
    }
}
