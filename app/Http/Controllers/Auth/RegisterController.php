<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation.
    |
    */

    /**
     * Show the application registration form.
     */
    public function showRegistrationForm(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'register' => ['required', 'string', 'max:10', 'min:10', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'register' => $data['register'],
            'password' => Hash::make($data['password']),
            'admin' => isset($data['admin']) ? 1 : 0,
        ]);
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request): RedirectResponse
    {
        $this->validator($request->all())->validate();

        event(new Registered($this->create($request->all())));

        return redirect(route('index-user'))->with('message', 'Usuário criado com sucesso');
    }
}
