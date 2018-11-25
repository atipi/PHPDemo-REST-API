<?php
ini_set("log_errors", 1);
ini_set("error_log", "/tmp/php-error.log");

date_default_timezone_set('UTC');


include_once './objects/rectangle.php';
include_once '../../utilities.php';

// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
  case 'GET':
    returnNotOKResponse($method);
    break;
  case 'PUT':
    returnNotOKResponse($method);
    break;
  case 'POST':
    // ok case
    try{
        // get request parameters
        $json_obj = getReqData();

        $res_data = doCalculate($json_obj->height, $json_obj->width);
        if(empty($res_data)){
            throw new Exception("Got undefined area value.");
        }

        error_log( "[Rectangle area] Response data: " . $res_data );
        // response back to the client
        http_response_code(200);
       // send JSON data back to client
       echo $res_data;
    }
    catch (Exception $e) {
        http_response_code(404);
        $error_message = $e->getMessage();
        error_log( "[Rectangle area] Error: " . $error_message );
        echo $error_message;
    }
    break;
  case 'DELETE':
    returnNotOKResponse($method);
    break;
}

function getReqData(){
    $data = file_get_contents('php://input');
    error_log( "[Rectangle area] POST request body: " . $data );
    if(empty($data)){
        error_log( "[Rectangle area] POST request body data is empty" );
        throw new Exception("The body string is undefined.");
    }

    $json_obj = json_decode($data);
    if(!is_object($json_obj)){
        throw new Exception("Invalid input data. Expected JSON data format.");
    }
    if( !isset( $json_obj->height ) ){
        throw new Exception("Missing height key.");
    }
    if( !isset( $json_obj->width ) ){
        throw new Exception("Missing width key.");
    }

    validateIntValue($json_obj->height, "height");
    validateIntValue($json_obj->{"width"}, "width");

    return $json_obj;
}

function validateIntValue($data, $key_name){
    if(!is_numeric($data)){
        throw new Exception("Expected numeric value in " . $key_name . " key");
    }
    if($data < 0){
        throw new Exception("Expected value greater than zero in " . $key_name . " key");
    }
}

function doCalculate($height_value, $width_value){
    $rectangle = new Rectangle();
    $rectangle->height_value = $height_value;
    $rectangle->width_value = $width_value;
    $area_value = $rectangle->calculateArea();

    $data_item=array(
        "height" => $height_value,
        "width" => $width_value,
        "area_value" => $area_value,
    );

    return json_encode($data_item);
}


?>
