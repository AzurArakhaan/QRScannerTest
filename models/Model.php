<?php

abstract class Model
{
    protected function openMySQL()
    {
        return new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    }
}