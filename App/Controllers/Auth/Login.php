<?php

namespace App\Controllers\Auth;

use App\Models\User;
use \Core\View;

class Login extends \Core\Controller
{
    public function createAction()
    {
        View::renderTemplate('Auth/login.twig');
    }

    public function attempt()
    {
        $user = User::authenticate($_POST['email'], $_POST['password']);

        if($user) {
            session_regenerate_id(true);
            
            $_SESSION['user_id'] = $user->id;
            $this->redirect('/');
        } else {
            View::renderTemplate('Auth/login.twig', [
                'email' => $_POST['email']
            ]);
        }
    }

    public function logoutAction()
    {
        // Unset all of the session variables
        $_SESSION = [];

        // Delete the session cookie
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        // Finally destroy the session
        session_destroy();

        $this->redirect('/');
    }

}