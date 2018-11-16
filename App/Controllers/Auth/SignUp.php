<?php
/**
 * Created by PhpStorm.
 * User: Haykokalipsis
 * Date: 13.11.2018
 * Time: 15:34
 */

namespace App\Controllers\Auth;

use App\Models\User;
use \Core\View;

class SignUp extends \Core\Controller
{
    public function createAction()
    {
        View::renderTemplate('Auth/sign-up.twig');
    }
    
    public function store()
    {
        $user = new User($_POST);
        if($user->store() ) {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/Auth/sign-up/success',true, 303);
			exit;
            // recommended redirect method
        } else {
            View::renderTemplate('Auth/sign-up.twig',[
                'user' => $user
            ]);
        }

    }

    public function successAction()
    {
        View::renderTemplate('Auth/success.twig');
    }

    public function validateEmailAction()
    {
        $is_valid = ! User::emailExists($_GET['email']);
        header('Content-Type: application/json');
        echo json_encode($is_valid);
    }
}