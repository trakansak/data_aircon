<?php
require_once __DIR__ . '/vendor/autoload.php';
class AirCon {
  /**
   * Post air-condition value.
   *
   * @param string $data_packet
   * @return string $callback
   */
  public function post_aircon($data_packet) {
    list($room, $temp, $humidity, $time) = explode(",", $data_packet);

    $servername = "";
    $username = "";
    $password = "";
    $database = "";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        return "Connection failed: " . $conn->connect_error;
    }
    echo "Connected successfully";
    $sql = "INSERT INTO aircon (room, temp, humidity) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param('sss', $room, $temp, $humidity);
      $stmt->execute();
      $stmt->close();
      return "New record created successfully";
    } else {
      return "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}
$serverUrl = "http://127.0.0.1/select1/aircon/server.php";
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
?>