<?php
require_once('vendor/autoload.php');
if(isset($_REQUEST['body']) && !empty($_REQUEST['body'])){
    $clout = new Bitclout();
    $result = $clout->submitPost($_REQUEST['publicKey'], $_REQUEST['body']);
    $output['status'] = 100;
    $output = array('status' => 100, 'result' => $result);
}
else{
	$output = array('status' => 200);
}
echo json_encode($output);
?>