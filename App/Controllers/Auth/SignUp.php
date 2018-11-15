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
        $signed = $user->store();

        View::renderTemplate('Home/index.twig', [
            'signed' => $signed
        ]);
    } 
}