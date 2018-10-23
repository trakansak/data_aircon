<?php
require_once __DIR__ . '/vendor/autoload.php';
$client = new Zend\Soap\Client('http://127.0.0.1/select1/aircon/server.php?wsdl');
try {
    $result = $client->post_aircon([
        'data_packet' => '81-506,30.1,68.4'
    ]);
    echo $result->post_airconResult;
} catch (SoapFault $e) {
    echo "Can't insert value.";
}
?>