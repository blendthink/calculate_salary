<?php

namespace Models;


use Dotenv\Dotenv;

class Setup
{
    public static function initialize()
    {
        $dotEnv = new Dotenv(__DIR__ . '/../');
        $dotEnv->load();
    }
}