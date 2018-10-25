<?php
require_once __DIR__ . '/vendor/autoload.php';
class AirCon
{
    /**
     * Post air-condition value.
     *
     * @param string $data_packet
     * @return string $callback
     * @return object
     */
    public function post_aircon($data_packet)
    {
        list($room, $temp, $time) = explode(",", $data_packet);
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
        $sql = "INSERT INTO aircon (room, temp, timedate) VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('sss', $room, $temp, $time);
            $stmt->execute();
            $stmt->close();
            return "New record created Successfully";
        } else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    public function query_aircon()
    {
        // list($room, $temp, $time) = explode(",", $data_packet);

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
        $sql = "SELECT * FROM aircon";
        $res = mysql_query($sql);

        $xml = new XMLWriter();
        $xml->openURI("php://output");

        $xml->startDocument();

        $xml->setIndent(true);

        $xml->startElement('countries');

        while ($row = mysql_fetch_assoc($res)) {

            $xml->startElement("country");

            $xml->writeAttribute('udid', $row['udid']);
            $xml->writeRaw($row['country']);

            $xml->endElement();
        }

        $xml->endElement();

        header('Content-type: text/xml');

        $xml->flush();

        if ($stmt = $conn->prepare($sql)) {
            // $stmt->bind_param('sss', $room, $temp, $time);
            $stmt->execute();
            $stmt->close();
            echo $xml;
            return "Query Successfully";
        }
    }

    public function showperson()
    {
        // $filename = "";
        $xml = simplexml_load_file("http://127.0.0.1/select1_aircon/showperson.xml");
        return $xml->asXML();
    }


    //service send_object

    public function info_sendobject($data_object)
    {
      list($user, $address, $object, $confirm) = explode(",", $data_object);
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
        $sql = "INSERT INTO info_send_object (user, addresss, objects, confirm) VALUES (?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('sss', $user, $address, $object, $confirm);
            $stmt->execute();
            $stmt->close();
            return "New record created Successfully";
        } else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
    }

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

$serverUrl = "http://127.0.0.1/select1_aircon/server.php";
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
