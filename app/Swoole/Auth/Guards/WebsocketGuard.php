<?php

namespace App\Swoole\Auth\Guards;

use Illuminate\Auth\SessionGuard;

class WebsocketGuard extends SessionGuard
{
    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if ($this->loggedOut) {
            return;
        }

        $id = $this->session->get($this->getName());

        // First we will try to load the user using the identifier in the session if
        // one exists. Otherwise we will check for a "remember me" cookie in this
        // request, and if one exists, attempt to retrieve the user using that.
        $user = null;

        if (! is_null($id)) {
            if ($user = $this->provider->retrieveById($id)) {
                $this->fireAuthenticatedEvent($user);
            }
        }

        // If the user is null, but we decrypt a "recaller" cookie we can attempt to
        // pull the user data on that cookie which serves as a remember cookie on
        // the application. Once we have a user we can return it to the caller.
        $recaller = $this->recaller();

        if (is_null($user) && ! is_null($recaller)) {
            $user = $this->userFromRecaller($recaller);

            if ($user) {
                $this->updateSession($user->getAuthIdentifier());

                $this->fireLoginEvent($user, true);
            }
        }

        return $this->user = $user;
    }

    /**
     * Get a unique identifier for the auth session value.
     *
     * @return string
     */
    public function getName()
    {
        return 'login_'.$this->name.'_'.sha1(SessionGuard::class);
    }
}
