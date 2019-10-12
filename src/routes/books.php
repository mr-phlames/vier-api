<?php
    $req_id = isset($_GET['id']) ? $_GET['id'] : null;
    $req_limit = isset($_GET['limit']) ? $_GET['limit'] : null;

    // get all notes
    $router->get('/notes/all', function() use($connection, $response) {
        $query = "SELECT * FROM books";
        $notes = $connection->query($query);
        $notes = $notes->fetchAll(PDO::FETCH_ASSOC);
        if (empty($notes)) {
            $message = 'There are no notes at the moment';
            return $response->throwErr($message, RESOURCE_NOT_FOUND);
        }
        return $response->respond($notes);
    });

    // get all notes witth limit
    $router->get('/notes/all?limit='.$req_limit, function() use($connection, $response, $req_limit) {
        $query = "SELECT * FROM books LIMIT $req_limit";
        $notes = $connection->query($query);
        $notes = $notes->fetchAll(PDO::FETCH_ASSOC);
        if (empty($notes)) {
            $message = 'There are no notes at the moment';
            return $response->throwErr($message, RESOURCE_NOT_FOUND);
        }
        return $response->respond($notes);
    });

    // get single note
    $router->get('/note?id='.$req_id, function() use($connection, $response, $req_id) {
        $query = "SELECT * FROM books WHERE id = '$req_id'";
        $note = $connection->query($query);
        $note = $note->fetchAll(PDO::FETCH_ASSOC);
        if (empty($note)) {
            $message = 'This note is currently unavailable';
            return $response->throwErr($message, RESOURCE_NOT_FOUND);
        }
        return $response->respond($note);
    });

    // get random note: note of the day or sort
    $router->get('/note/random', function() use($connection, $response) {
        $id = 2;/* random number */
        $query = "SELECT * FROM books WHERE id = '$id'";
        $note = $connection->query($query);
        $note = $note->fetchAll(PDO::FETCH_ASSOC);
        if (empty($note)) {
            $message = 'This note is currently unavailable';
            return $response->throwErr($message, RESOURCE_NOT_FOUND);
        }
        return $response->respond($note);
    });

    $router->get('/notes/add', function() use($response) {
        $message = "Invalid request type, use a POST request instead";
        return $response->throwErr($message, REQUEST_METHOD_NOT_VALID);
    });

    $router->post('/notes/add', function() use($connection, $request, $response, $validate) {
        $title = $request->getParam('title');
        $note = $request->getParam('note');
        $description = $request->getParam('description');
        $author = $request->getParam('author');

        if (empty($title) || empty($description) || empty($note) || empty($author) || $title == null || $author == null || $note == null || $description == null) {
            $validate->isEmptyOrNull($title, "Title is required");
            $validate->isEmptyOrNull($note, "Note is required");
            $validate->isEmptyOrNull($description, "Description is required");
            $validate->isEmptyOrNull($author, "Author is required");
        } else {
            $author = str_replace("'","‘", $author);
            $title = str_replace("'","‘", $title);
            $note = str_replace("'","‘", $note);
            $description = str_replace("'","‘", $description);
            
            $query = "INSERT INTO books(title, author, note, description) VALUES('$title', '$author', '$note', '$description')";
            $queryTwo = "SELECT * FROM authors WHERE name = '$author'";
            $queryThree = "INSERT INTO authors(name, email, rating) VALUES('$author', '', '0.0')";

            $connection->query($query);
            $fetchedAuthor = $connection->query($queryTwo);
            $fetchedAuthor = $fetchedAuthor->fetch(PDO::FETCH_ASSOC);
            if (empty($fetchedAuthor)) {
                $connection->query($queryThree);
            }
            $res = array("message" => "Your note has been added", "type" => "success", "clearForm" => true);
            return $response->respond($res);
        }
    });
