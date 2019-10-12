<?php
    $req_id = isset($_GET['id']) ? $_GET['id'] : null;
    $req_limit = isset($_GET['limit']) ? $_GET['limit'] : null;

    // get all authors
    $router->get('/authors/all', function() use($connection, $response) {
        $query = "SELECT * FROM authors";
        $authors = $connection->query($query);
        $authors = $authors->fetchAll(PDO::FETCH_ASSOC);
        if (empty($authors)) {
            $message = 'There are no notes at the moment';
            return $response->throwErr($message, RESOURCE_NOT_FOUND);
		}
		// transform author array
		$authorsArray = array();
		foreach ($authors as $author) {
			$authorName = $author['name'];
			$query = "SELECT * FROM books WHERE author = '$authorName'";
			$books = $connection->query($query);
			$books = $books->fetchAll(PDO::FETCH_ASSOC);

			array_push($authorsArray, array(
				"id" => $author['id'],
				"name" => $author['name'],
				"email" => $author['email'],
				"rating" => $author['rating'],
				"books" => $books,
				"book_count" => count($books)
			));
		}
        return $response->respond($authorsArray);
	});

	// get single author
    $router->get('/author?id='.$req_id, function() use($connection, $response, $req_id) {
        $query = "SELECT * FROM authors WHERE id = '$req_id'";
        $author = $connection->query($query);
        $author = $author->fetch(PDO::FETCH_ASSOC);
        if (empty($author)) {
            $message = 'This author is currently unavailable';
            return $response->throwErr($message, RESOURCE_NOT_FOUND);
		}
		
		$authorArray = array();
		$authorName = $author['name'];
		$query = "SELECT * FROM books WHERE author = '$authorName'";
		$books = $connection->query($query);
		$books = $books->fetchAll(PDO::FETCH_ASSOC);

		array_push($authorArray, array(
			"id" => $author['id'],
			"name" => $author['name'],
			"email" => $author['email'],
			"rating" => $author['rating'],
			"books" => $books,
			"book_count" => count($books)
		));

        return $response->respond($authorArray);
    });
