<?php

namespace Core;

class View
{
    /**
     * @param $view
     */
//    public static function render($view, $args = [])
//    {
//        extract($args, EXTR_SKIP);
//
//        $file = "../App/Views/$view"; // relative to Core directory
//
//        if(is_readable($file) )
//            require $file;
//        else
//            //echo "$file not found";
//            throw new \Exception("$file not found");
//
//    }

    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem('../App/Views');
            $twig = new \Twig_Environment($loader);
        }

        try {
            echo $twig->render($template, $args);
        } catch (\Twig_Error_Loader $e) {
        } catch (\Twig_Error_Runtime $e) {
        } catch (\Twig_Error_Syntax $e) {
        }
    }
}