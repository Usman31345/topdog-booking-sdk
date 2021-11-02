
   <?php 
        //Data, connection, auth
        // $dataFromTheForm = $_POST['fieldName']; // request data from the form
        $soapUrl = "http://testapi.topdog.uk.net:8090/blackboxMR/blackbox"; // asmx URL of WSDL
        $soapUser = "BTPWS";  //  username
        $soapPassword = "xx!239562"; // password

        // xml post structure

        $xml_post_string = '<?xml version="1.0" encoding="UTF-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
 <soap:Body>
 <HotelReservationRequest xmlns="http://topdog.uk.net/BlackBox">
 <SessionId>36ad7b8e29def2a47a27647468608457-07281202/DEMO</SessionId>
 <BookCode>6059d4ccd9995307f21629dc3470ecf3</BookCode>
 </HotelReservationRequest>
 </soap:Body>
</soap:Envelope>';   // data from the form, e.g. some ID number

           $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        "SOAPAction: http://topdog.uk.net/BlackBox/ReserveHotel", 
                        "Content-length: ".strlen($xml_post_string),
                    ); //SOAPAction: your op URL

            $url = $soapUrl;

            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // converting
            $response = curl_exec($ch); 

 print_r($response);die;
            // converting
            $response1 = str_replace("<soap:Body>","",$response);
            $response2 = str_replace("</soap:Body>","",$response1);
           

            // convertingc to XML
            $parser = simplexml_load_string($response2);
            // return $parser;
            // user $parser to get your data out of XML response and to display it.




    ?>

