<?php

namespace Core;

class View
{
    /**
     * @param $view
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = "../App/Views/$view"; // relative to Core dorectory

        if(is_readable($file) )
            require $file;
        else
            echo "$file not found";

    }
}