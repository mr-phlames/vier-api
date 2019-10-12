<?php
    $req_search = isset($_GET['q']) ? $_GET['q'] : null;
    $req_limit = isset($_GET['limit']) ? $_GET['limit'] : null;

    // search for books
    $router->get('/search/notes?q='.$req_search, function() use($connection, $response, $req_search) {
		$req_search = $req_search."%";
        $query = "SELECT * FROM books WHERE title LIKE '$req_search'";
        $notes = $connection->query($query);
        $notes = $notes->fetchAll(PDO::FETCH_ASSOC);
        if (empty($notes)) {
            return $response->throwErr('No Results Found', RESOURCE_NOT_FOUND);
        }
        return $response->respond($notes);
	});

    // search for book with limit
    $router->get('/search/notes?q='.$req_search.'&limit='.$req_limit, function() use($connection, $response, $req_search, $req_limit) {
		$req_search = $req_search."%";
        $query = "SELECT * FROM books WHERE title LIKE '$req_search' LIMIT $req_limit";
        $notes = $connection->query($query);
        $notes = $notes->fetchAll(PDO::FETCH_ASSOC);
        if (empty($notes)) {
            return $response->throwErr('No Results Found', RESOURCE_NOT_FOUND);
        }
        return $response->respond($notes);
	});

    // search for books by author`
    $router->get('/search/authors?q='.$req_search, function() use($connection, $response, $req_search) {
		$req_search = $req_search."%";
        $query = "SELECT * FROM books WHERE author LIKE '$req_search'";
        $authors = $connection->query($query);
        $authors = $authors->fetchAll(PDO::FETCH_ASSOC);
        if (empty($authors)) {
            return $response->throwErr('No Results Found', RESOURCE_NOT_FOUND);
        }
        return $response->respond($authors);
	});