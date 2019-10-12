# Vier API

The vier api is the backend for the Vier Notes weeb application. It is written in PHP with the [Leaf PHP Boilerplate](https://github.com/mr-phlames/leaf-php-boilerplate)

## Project Set up

```bash
$ git clone https://github.com/mr-phlames/vier-api.git
$ cd vier-api
$ php -S localhost:8000
```

This will start a server on Port 8000. Open up the code and start editing.

## Project Structure

.
+-- index.php
+-- .htaccess
+-- .docs
|   +-- index.php
+-- routes
|   +-- auth.php
|   +-- authors.php
|   +-- books.php
|   +-- categories.php
|   +-- htmlPages.php
|   +-- search.php
+-- src
|   +-- Leaf PHP code


## Routes

the `/routes` folder contains all the route files of the API. The "leaf router" is used as this projects routing system, and is very similar to most major php frameworks 

```php
<?php

$router->get('/home', function() use($response) {
	return $response->respond(/*data*/);
});
```

View the [Leaf starter documentation](https://github.com/mr-phlames/leaf-php-boilerplate) for more on routing.



## Database connection

In the _src/config/init.php_, a bunch of classes are initialised, amongst them is the Database class, to connect to your database, simply use fill out the details in the **_$database->connect()_** method

```php
<?php

$router = new Router(new HttpRequest);

$database = new Database();
// connect(host, user, password, database_name, connection_type); 
$connection = $database->connect('locahost', 'root', '', 'books', 'PDO');
```

