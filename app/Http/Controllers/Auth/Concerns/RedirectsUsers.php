<?php

namespace App\Http\Controllers\Auth\Concerns;

trait RedirectsUsers
{
    /**
     * The path to redirect users to after login.
     */
    protected string $redirectTo = '/home';

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return $this->redirectTo;
    }
}
