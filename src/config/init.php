<?php
    $router = new Router(new HttpRequest);

    $database = new Database();
    // connect(host, user, password, database_name, connection_type); 
    $connection = $database->connect('locahost', 'root', '', 'books', 'PDO');

    $response = new Response();

    $request = new Request();

    $validate = new Validation($response);

    $date = new CustomDate();

    $jwt = new JWT();
