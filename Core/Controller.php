<?php
/**
 * Created by PhpStorm.
 * User: Haykokalipsis
 * Date: 12.11.2018
 * Time: 15:17
 */

namespace Core;


Abstract class Controller
{
    protected $route_params = [];

    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }
}