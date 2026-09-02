<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $users = User::query()->orderBy('name')->get();

        return response(view('user.index', compact('users')), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): Response
    {
        $user = User::find($id);

        return response(view('user.one', compact('user')));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $user = User::find($id);

        return response(view('user.update', compact('user')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $user = User::find($id);
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
        $user = User::find($id);
        $user->delete();

        return redirect(route('index-user'))->with(
            'message',
            'Usuário excluído com sucesso'
        );
    }

    public function profile()
    {
        return response(view('user.one')->with('user', Auth::user()));
    }

    public function changePassword()
    {
        return response(view('user.password')->with('user', Auth::user()));
    }

    public function changePasswordId($id)
    {
        return response(view('user.password')->with('user', User::find($id)));
    }

    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function storePassword(Request $request, $id)
    {
        $this->validator($request->all())->validate();

        if (Auth::id() == $id) {
            User::find($id)->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect(route('profile'))->with(
                'message',
                'Senha alterada com sucesso'
            );
        }

        if (isset(Auth::user()->admin)) {
            if (Auth::user()->admin) {
                $user = User::find($id);
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
                if ($request->url() === route('home')) {
                    return response(view('home')->with('message', 'Senha alterada com sucesso'));
                }

                return redirect()->route('show-user', $user->id)->with('message', 'Senha alterada com sucesso');
            }
        }

        return redirect(route('home'));
    }
}
