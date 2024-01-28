<?php

namespace Almhdy\Simy\Core;

use Illuminate\Database\Capsule\Manager as Capsule;
use Exception;

class Database
{
    public function __construct()
    {
        $this->init();
    }

    private function init(): void
    {
        $databaseConfig = [
            'driver'    => $_ENV['DB_CONNECTION'],
            'host'      => $_ENV['DB_HOST'],
            'database'  => $_ENV['DB_DATABASE'],
            'username'  => $_ENV['DB_USERNAME'],
            'password'  => $_ENV['DB_PASSWORD'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ];

        // Setup the database connection
        $capsule = new Capsule;
        $capsule->addConnection($databaseConfig);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        // To ensure that Eloquent uses the same environment as your previous Medoo setup, you may wish to set the default timezone and enable query log (optional)
        // For example:
        // $capsule->getConnection()->enableQueryLog();
        // date_default_timezone_set('UTC');

        // You may also need to catch the connection exception
        // try {
        //     $capsule->getConnection()->getPdo();
        // } catch (Exception $e) {
        //     echo $e->getMessage();
        // }
    }
}