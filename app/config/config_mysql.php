<?php

return [
    // Set up details on how to connect to the database

    'dsn'     => "",
    'username'        => "",
    'password'        => '',
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    'table_prefix'    => "mvc_project_",


    // Display details on what happens
    'verbose' => false,

    // Throw a more verbose exception when failing to connect
    //'debug_connect' => 'true',
];
