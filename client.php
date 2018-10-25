<?php
require_once __DIR__ . '/vendor/autoload.php';
$client = new Zend\Soap\Client('http://127.0.0.1/select1_aircon/server.php?wsdl');
// $client = new Zend\Soap\Client('http://data-aircon.herokuapp.com/server.php?wsdl');

    // $result = $client->post_aircon([
    //     'data_packet' => '81-623,27,8:00 AM'
    // ]);

    $result = $client->showperson();
    echo $result->showpersonResult;
    // echo $result;
?>