<?php

namespace App\Controllers;

abstract class Authenticated extends \Core\Controller
{
    public function before()
    {
        $this->requireLogin();
    }
}