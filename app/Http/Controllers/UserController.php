<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $users = User::query()->orderBy('name')->get(['id', 'name', 'admin']);

        return Inertia::render('Users/Index', compact('users'));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): Response
    {
        $user = User::withCount('occurrences')->findOrFail($id);

        return Inertia::render('Users/Show', [
            'user' => $user,
            'occurrencesCount' => $user->occurrences_count,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $user = User::findOrFail($id);

        return Inertia::render('Users/Edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'register' => is_null($request->register) ? $user->register : $request->register,
            'admin' => is_null($request->admin) ? false : $request->admin,
        ]);

        return redirect()->route('show-user', $user->id)->with(
            'message',
            'Usuário alterado com sucesso'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect(route('index-user'))->with(
            'message',
            'Usuário excluído com sucesso'
        );
    }

    public function profile(): Response
    {
        $user = Auth::user()->loadCount('occurrences');

        return Inertia::render('Users/Show', [
            'user' => $user,
            'occurrencesCount' => $user->occurrences_count,
            'backRoute' => 'home',
        ]);
    }

    public function changePassword(): Response
    {
        return Inertia::render('Users/Password', ['user' => Auth::user()]);
    }

    public function changePasswordId(int $id): Response
    {
        return Inertia::render('Users/Password', ['user' => User::findOrFail($id)]);
    }

    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function storePassword(Request $request, $id): RedirectResponse
    {
        $this->validator($request->all())->validate();

        if (Auth::id() == $id) {
            User::findOrFail($id)->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect(route('profile'))->with(
                'message',
                'Senha alterada com sucesso'
            );
        }

        if (Auth::user()->admin) {
            $user = User::findOrFail($id);
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('show-user', $user->id)->with('message', 'Senha alterada com sucesso');
        }

        return redirect(route('home'));
    }
}
