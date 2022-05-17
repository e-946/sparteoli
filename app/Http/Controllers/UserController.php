<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $users = User::query()->orderBy('name')->get();
        return response(view('user.index', compact('users')), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $user = User::find($id);
        return response(view('user.one', compact('user')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(int $id): Response
    {
        $user = User::find($id);
        return response(view('user.update', compact('user')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, int $id): Response
    {
        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'register' => is_null($request->register) ? $user->register : $request->register,
            'admin' => is_null($request->admin) ? false : $request->admin,
        ]);

        return response(redirect()->route('show-user', $user->id)->with(
            'message',
            "Usuário alterado com sucesso"
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        $user = User::find($id);
        $user->delete();

        return response(redirect(route('index-user'))->with(
            'message',
            "Usuário excluído com sucesso"
        ));
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
        try {
            $this->validator($request->all())->validate();
        } catch (ValidationException $e) {
        }

        if (Auth::id() == $id) {
            User::find($id)->update([
                'password' => Hash::make($request->password),
            ]);
            return response(redirect(route('profile'))->with(
                'message',
                "Senha alterada com sucesso"
            ));
        }

        if (isset(Auth::user()->admin)) {
            if (Auth::user()->admin) {
                $user = User::find($id);
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
                if ($request->url() === route('home')) {
                    return response(view('home')->with('message', "Senha alterada com sucesso"));
                }
                return response(redirect()->route('show-user', $user->id)->with('message', 'Senha alterada com sucesso'));
            }
        }

        return response(redirect(route('home')));
    }
}
