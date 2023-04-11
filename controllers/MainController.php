<?php
require_once 'Controller.php';

class MainController extends Controller
{
    public function index()
    {
        if (!empty($_SESSION['authenticated'])) {
            header('Location: /main');
        }

        $this->render('auth.html');
    }

    public function mainScreen()
    {
        if (empty($_SESSION['authenticated'])) {
            header('Location: /');
        }

        $this->render('main.php');
    }
}