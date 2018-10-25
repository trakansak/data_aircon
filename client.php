<?php
require_once __DIR__ . '/vendor/autoload.php';
// $client = new Zend\Soap\Client('http://127.0.0.1/select1_aircon/server.php?wsdl');
// $client = new Zend\Soap\Client('http://data-aircon.herokuapp.com/server.php?wsdl');
$client = new Zend\Soap\Client('http://127.0.0.1/select1_aircon/server2.php?wsdl');

    $result = $client->post_aircon([
        'data_packet' => 'bung,67431,pen,true'
    ]);

    // $result = $client->info_sendobject([
    //     'data_object' => 'bung,674/31,pen,true'
    // ]);

    // echo $result->info_send_objectResult;
    echo $result->post_airconResult;
    // echo $result;
?>