<?php

namespace App\Controllers;

use \Core\View;

class Home extends \Core\Controller
{
    public function indexAction()
    {
//        echo "Hell from the index action in the Home controller";;
        View::render('Home/index.php', [
            'name' => 'Dave',
            'colours' => ['red', 'green', 'blue']
        ]);
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