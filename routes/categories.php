<?php
    $req_id = isset($_GET['id']) ? $_GET['id'] : null;
    $req_limit = isset($_GET['limit']) ? $_GET['limit'] : null;

    // get all categories
    $router->get('/categories/all', function() use($connection, $response) {
        $query = "SELECT * FROM categories";
        $categories = $connection->query($query);
        $categories = $categories->fetchAll(PDO::FETCH_ASSOC);
        if (empty($categories)) {
            $message = 'There are no notes at the moment';
            return $response->throwErr($message, RESOURCE_NOT_FOUND);
        }
        return $response->respond($categories);
	});

	// get single category
    $router->get('/category?id='.$req_id, function() use($connection, $response, $req_id) {
        $query = "SELECT * FROM categories WHERE id = '$req_id'";
        $category = $connection->query($query);
        $category = $category->fetchAll(PDO::FETCH_ASSOC);
        if (empty($category)) {
            $message = 'This category is currently unavailable';
            return $response->throwErr($message, RESOURCE_NOT_FOUND);
        }
        return $response->respond($category);
    });
