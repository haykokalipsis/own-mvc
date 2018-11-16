<?php

namespace App\Controllers\Auth;

use App\Auth;
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
            Auth::login($user);
            $this->redirect(Auth::getReturnToPage() );
        } else {
            View::renderTemplate('Auth/login.twig', [
                'email' => $_POST['email']
            ]);
        }
    }

    public function logoutAction()
    {
        Auth::logout();
        $this->redirect('/');
    }

}