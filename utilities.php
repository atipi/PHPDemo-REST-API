<?php
    // calculate post fix URL string according to API type
    function getPostfixRedirectURL($api_type){
        $post_fix = "";
        switch ($api_type) {
            case 'circle':
                $post_fix = "/api/area_calculating/" . $api_type ."/index.php?radius=";
                break;
            case 'square':
                $post_fix = "/api/area_calculating/" . $api_type ."/index.php?length=";
                break;
        }

        return($post_fix);
    }

    function returnNotOKResponse($req_method){
        error_log( "Request method: " . $req_method . " is upsupported " );
        http_response_code(404);

        echo json_encode(
            array("message" => "Operation unsupported.")
        );
    }
?>
