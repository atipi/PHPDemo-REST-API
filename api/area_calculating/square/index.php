<?php
/**
 *
 * @author Porntip Chaibamrung <pchaibamrung@gmail.com>
 *
 */

ini_set("log_errors", 1);
ini_set("error_log", "/tmp/php-error.log");
date_default_timezone_set('UTC');

include_once './objects/square.php';
include_once '../../../utilities.php';

// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
  case 'GET':
    // ok case
    // get request params
    $req_data = $_GET;
    $length_value = $req_data["length"];
    if(empty($length_value)){
        error_log( "[Square area] length input value is empty.");
    }

    try{
        $res_data = doCalculate($length_value);
        if(empty($res_data)){
            throw new Exception("Got undefined area value.");
        }

        error_log( "[Square area] Response data: " . $res_data );
        // response back to the client
        http_response_code(200);
        // send JSON data back to client
        echo $res_data;
    }
    catch (Exception $e) {
        http_response_code(404);
        $error_message = $e->getMessage();
        error_log( "[Square area] Error: " . $error_message );
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

function doCalculate($length_value){
    $square = new Square();
    $square->length_value = $length_value;
    $area_value = $square->calculateArea();

    $data_item=array(
        "length" => $length_value,
        "area_value" => $area_value,
    );

    return json_encode($data_item);
}
?>
