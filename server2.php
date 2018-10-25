<?php
require_once __DIR__ . '/vendor/autoload.php';
class AirCon
{
    /**
     * Post air-condition value.
     *
     * @param string $data_packet
     * @return string $callback
     * 
     */
    public function post_aircon($data_packet)
    {
        list($user, $addresss, $objects, $confirm) = explode(",", $data_packet);
        $servername = "ol5tz0yvwp930510.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
        $username = "uohjzu4b27mw2xm6";
        $password = "rtyq4e1iclt8vtfi";
        $database = "rjodltazhge2pg94";
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            return "Connection failed: " . $conn->connect_error;
        }
        echo "Connected successfully";
        $sql = "INSERT INTO objective(user, addresss, objects, confirm) VALUES (?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('sss', $user, $addresss, $objects, $confirm);
            $stmt->execute();
            $stmt->close();
            return "New record created Successfully";
        } else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // public function showperson()
    // {
    //     // $filename = "";
    //     $xml = simplexml_load_file("http://127.0.0.1/select1_aircon/showperson.xml");
    //     return $xml->asXML();
    // }

    //service send_object

    // public function confirm_object($objects)
    // {
    //   $servername = "ol5tz0yvwp930510.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
    //   $username = "uohjzu4b27mw2xm6";
    //   $password = "rtyq4e1iclt8vtfi";
    //   $database = "rjodltazhge2pg94";
    //   $conn = new mysqli($servername, $username, $password, $database);
    //   if ($conn->connect_error) {
    //       die("Connection failed: " . $conn->connect_error);
    //       return "Connection failed: " . $conn->connect_error;
    //   }
    //   echo "Connected successfully";
    //   $sql = "SELECT * FROM info_send_object Where Objects ="$object", confirm ='true'"
    //   $res = mysql_query($sql);
    //   if ($result->num_rows > 0) {
    //     if ($stmt = $conn->prepare($sql)) {
    //       $stmt->bind_param($object);
    //     return "Object send Complete"
    //   }
    //   else{
    //     return "Object send Not Complete"
    //   }
    // }
}

// $serverUrl = "http://127.0.0.1/select1_aircon/server.php";
$serverUrl = "http://127.0.0.1/select1_aircon/server2.php";
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
    $soapAutoDiscover->setClass('AirCon');
    $soapAutoDiscover->setUri($serverUrl);

    header("Content-Type: text/xml");
    echo $soapAutoDiscover->generate()->toXml();
} else {
    $soap = new \Zend\Soap\Server($serverUrl . '?wsdl');
    $soap->setObject(new \Zend\Soap\Server\DocumentLiteralWrapper(new AirCon()));
    $soap->handle();
}
