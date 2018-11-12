<?php

namespace App\Controllers;

use \Core\View;

class Home extends \Core\Controller
{
    public function indexAction()
    {
//        View::render('Home/index.php', [
//            'name' => 'Dave',
//            'colours' => ['red', 'green', 'blue']
//        ]);

        View::renderTemplate('Home/index.html', [
            'name'    => 'Dave',
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