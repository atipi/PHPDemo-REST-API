<?php
    ini_set("log_errors", 1);
    ini_set("error_log", "/tmp/php-error.log");
    date_default_timezone_set('UTC');

    include_once './utilities.php';

    // get the HTTP method, path and body of the request
    $method = $_SERVER['REQUEST_METHOD'];

    if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
        $uri = 'https://';
    } else {
        $uri = 'http://';
    }
    $uri .= $_SERVER['HTTP_HOST'];

    $params = $_GET['params'];
    error_log( "GET params data: " . $params );
    $str_items = explode('/', $params);
    $api_type = $str_items[0];
    error_log( "API type: " . $api_type );

    if($api_type === 'circle'){
        if($method !== 'GET'){
            returnNotOKResponse($method);
        } else {
            $post_fix_url = getPostfixRedirectURL($api_type);
            if($post_fix_url === ""){
                error_log( "Unable to get post fix URL." );
                throw new Exception("Something wrong with request path string.");
            }

            $page = $uri . $post_fix_url . $str_items[1];
            error_log( "Re-direct to: " . $page );
            header('Location: '. $page);
        }
    } elseif($api_type === 'square'){
        if($method !== 'GET'){
            returnNotOKResponse($method);
        } else {
            $post_fix_url = getPostfixRedirectURL($api_type);
            if($post_fix_url === ""){
                error_log( "Unable to get post fix URL." );
                throw new Exception("Something wrong with request path string.");
            }

            $page = $uri . $post_fix_url . $_GET['length'];
            error_log( "Re-direct to: " . $page );
            header('Location: '. $page);
        }
    } else {
        error_log( "Unsupported API type: " . $api_type );
        header('Location: '.$uri.'/dashboard/');
    }

    exit;
?>
Something is wrong with the XAMPP installation :-(
