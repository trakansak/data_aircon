<?php

require_once __DIR__ . '/vendor/autoload.php';

class serviceAirCond
{
    /**
    *   Insert Data for AirConditioner
    *  @param string  $room 
    *  @param string  $time
    *  @param string  $temp 
    *  
    */
    
    public function InsertDataAirCon($room,$time,$temp)
    {
        // header('Content-Type: text/xml');
        $data=simplexml_load_file("http://127.0.0.1/data_aircon/Aircon.xml");
        $aircon = $data->addChild("AirCond");
        $aircon->addChild("room",$room);
        $aircon->addChild("temp",$temp);
        $aircon->addChild("time",$time);


        $reader = new DOMDocument();
        $reader->preserveWhiteSpace = false;
        $reader->formatOutput = true;
        // $reader->header("Content-Type: text/xml");
        $reader->loadXML($data->asXML());
        $reader->save('Aircon.xml');
        return "Added AirConditioner";

    }

    /**
    *   Query/Info for AirConditioner
    *  @return string
    */

    public function QueryDataAirCon()
    {
        $file = simplexml_load_file('http://127.0.0.1/data_aircon/Aircon.xml');
        // print_r($file);
        return ($file->asXml());
    }

    /**
    *   Info for Personal
    *  @return string
    */

    public function showPersonal()
    {
        $file = simplexml_load_file('http://127.0.0.1/data_aircon/Personal.xml');
        return ($file->asXML());
    }

    /**
    * Insert for Product
    * @param string     $id_product
    * @param string     $owner_product
    * @param string     $address_product
    * @param string     $weight_product
    * 
    */

    public function addProduct($id_product,$owner_product,$address_product,$weight_product)
    {
        // header('Content-Type: text/xml');
        // $sure = "Not Delivered";
        $data=simplexml_load_file("http://127.0.0.1/data_aircon/Product.xml");
        $aircon = $data->addChild("Info");
        $aircon->addChild("id",$id_product);
        $aircon->addChild("owner",$owner_product);
        $aircon->addChild("address",$address_product);
        $aircon->addChild("weight",$weight_product);
        $aircon->addChild("confirm","Not Delivered");


        $reader = new DOMDocument();
        $reader->preserveWhiteSpace = false;
        $reader->formatOutput = true;
        // $reader->header("Content-Type: text/xml");
        $reader->loadXML($data->asXML());
        $reader->save('Product.xml');
        return "Added Product";
    }

    /**
    * Validated for Product
    * @param int    $id_product
    * 
    */

    public function confirmProduct($id_product)
    {
        $data=simplexml_load_file("http://127.0.0.1/data_aircon/Product.xml");
        foreach ($data->children() as $id_conf) {
            if($id_conf->id == $id_product) {
                $id_conf->confirm = "Delivered";
            }
        }
        $reader = new DOMDocument();
        $reader->preserveWhiteSpace = false;
        $reader->formatOutput = true;
        // $reader->header("Content-Type: text/xml");
        $reader->loadXML($data->asXML());
        $reader->save('Product.xml');
        return "Complete Sent Product";
    }

    /**
    *   Info for Product
    *  @return string
    */

    public function queryProduct()
    {
        $file=simplexml_load_file("http://127.0.0.1/data_aircon/Product.xml");
        return ($file->asXML());
    }

}


$serverUrl = "http://127.0.0.1/data_aircon/server.php";
// $serverUrl = "http://data-aircon.herokuapp.com/server.php";
$options = [
    'uri' => $serverUrl,
];
$server = new Zend\Soap\Server(null, $options);

if (isset($_GET['wsdl'])) {
    $soapAutoDiscover = new \Zend\Soap\AutoDiscover(
        new \Zend\Soap\Wsdl\ComplexTypeStrategy\ArrayOfTypeSequence());
    $soapAutoDiscover->setBindingStyle(array('style' => 'document'));
    $soapAutoDiscover->setOperationBodyStyle(array('use' => 'literal'));
    $soapAutoDiscover->setClass('serviceAirCond');
    $soapAutoDiscover->setUri($serverUrl);

    header("Content-Type: text/xml");
    echo $soapAutoDiscover->generate()->toXml();
} else {
    $soap = new \Zend\Soap\Server($serverUrl . '?wsdl');
    $soap->setObject(new \Zend\Soap\Server\DocumentLiteralWrapper(new serviceAirCond()));
    $soap->handle();
}

?>