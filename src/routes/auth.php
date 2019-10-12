<?php
    $req_id = isset($_GET['id']) ? $_GET['id'] : null;
    $req_limit = isset($_GET['limit']) ? $_GET['limit'] : null;

    $router->get('/auth/login', function() use($response) {
        $message = "Invalid request type, use a POST request instead";
        return $response->throwErr($message, REQUEST_METHOD_NOT_VALID);
    });

    $router->post('/auth/login', function() use($connection, $request, $response, $validate) {
        $username = $request->getParam('username');
        $password = $request->getParam('password');

        if (empty($username) || empty($password)  || $username == null || $password == null) {
            $validate->isEmptyOrNull($username, "Username is required");
            $validate->isEmptyOrNull($password, "Password is required");
        } else {
            $username = str_replace("'","‘", $username);
            $password = str_replace("'","‘", $password);
			
			$paylod = [
				'iat' => time(),
				'iss' => 'localhost',
				'exp' => time() + (15*60),
				'userId' => $user['id']
			];
	
			$token = $jwt->encode($paylod, SECRETE_KEY);
	
            $res = array("message" => "Your note has been added", "type" => "success", "clearForm" => true);
            return $response->respond($res);
        }
    });
