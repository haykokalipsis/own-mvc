<?php

namespace App\Controllers;

class Home extends \Core\Controller
{
    public function indexAction()
    {
        echo "Hello from the index action in the Home controller";;
    }

    public function before()
    {
        echo '(Before)';
    }

    public function after()
    {
        echo '(After)';
    }
}