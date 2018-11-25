<?php
ini_set("log_errors", 1);
ini_set("error_log", "/tmp/php-error.log");
date_default_timezone_set('UTC');

include_once './objects/circle.php';
include_once '../../../utilities.php';

// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
  case 'GET':
    // ok case
    // get request params
    $req_data = $_GET;
    $radius = $req_data["radius"];
    if(empty($radius)){
        error_log( "[Circle area] radius input value is empty.");
        throw new Exception("Undefined radius value from input data.");
    }

    try{
        $res_data = doCalculate($radius);
        if(empty($res_data)){
            throw new Exception("Got undefined area value.");
        }

        error_log( "[Circle area] Response data: " . $res_data );
        // response back to the client
        http_response_code(200);
        // send JSON data back to client
        echo $res_data;
    }
    catch (Exception $e) {
        http_response_code(404);
        $error_message = $e->getMessage();
        error_log( "[Circle area] Error: " . $error_message );
        echo $error_message;
    }
    break;
  case 'PUT':
    returnNotOKResponse($method);
    break;
  case 'POST':
    returnNotOKResponse($method);
    break;
  case 'DELETE':
    returnNotOKResponse($method);
    break;
}

function doCalculate($radius){
    $circle = new Circle();
    // set circle property values
    $circle->radius = $radius;
    $area_value = $circle->calculateArea();

    $data_item=array(
        "radius" => $radius,
        "area_value" => $area_value,
    );

    return json_encode($data_item);
}

?>
