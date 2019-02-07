<?php
function my_ajax_action_function(){

    $reponse = array();
    if(!empty($_POST['param'])){
         $response['response'] = "I've get the param a its value is ".$_POST['param'].' and the plugin url is '.plugins_url();
    } else {
         $response['response'] = "You didn't send the param";
    }

    header( "Content-Type: application/json" );
    echo json_encode($response);

    //Don't forget to always exit in the ajax function.
    exit();

}
?>