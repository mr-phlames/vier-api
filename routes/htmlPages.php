<?php
    $router->get('/docs', function() use($response) {
        header('Content-Type: text/html');
        return $response->renderMarkup('docs/index.php');
    });
