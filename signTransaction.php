<?php
require_once('vendor/autoload.php');
if(isset($_REQUEST['TransactionHex']) && !empty($_REQUEST['TransactionHex'])){
    $clout = new Bitclout();
    $result = $clout->submitTransaction($_REQUEST['TransactionHex']);
    $output['status'] = 100;
    $output = array('status' => 100, 'result' => $result);
}
else{
	$output = array('status' => 200);
}
echo json_encode($output);
?>