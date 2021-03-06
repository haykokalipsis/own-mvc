<?php

namespace App\Controllers\Auth;

use App\Auth;
use App\Flash;
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

        $remember_me = isset($_POST['remember_me']);
        if($user) {
            Auth::login($user, $remember_me);
            Flash::addMessage('Login successful');
            $this->redirect(Auth::getReturnToPage() );
        } else {
            Flash::addMessage('Login unsuccessful, please check your credentials', Flash::WARNING);
            View::renderTemplate('Auth/login.twig', [
                'email' => $_POST['email'],
                'remember_me' => $remember_me
            ]);
        }
    }

    public function logoutAction()
    {
        Auth::logout();
        $this->redirect('/logout/show-logout-message');
    }

    public function showLogoutMessageAction()
    {
        Flash::addMessage('Logout successful');
        $this->redirect('/');
    }

}