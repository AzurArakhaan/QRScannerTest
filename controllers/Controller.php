<?php


abstract class Controller
{
    protected function render($viewName)
    {
        include(ROOT_PATH . '/views/' . $viewName);
    }
}