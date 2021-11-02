
   <?php 
        //Data, connection, auth
        // $dataFromTheForm = $_POST['fieldName']; // request data from the form
        $soapUrl = "http://bwe.topdog.uk.net:8180/load-balancer/blackbox"; // asmx URL of WSDL
        $soapUser = "BTPWS";  //  username
        $soapPassword = "xx!239562"; // password

        // xml post structure

        $xml_post_string = '<?xml version="1.0" encoding="UTF-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
 <soap:Body>
 <FlightAvailabilityRequest xmlns="http://topdog.uk.net/BlackBox">
 <SessionId>ccebe35c9e6c8fb41e293bc55b7550e5-09171512/BRD16</SessionId>
 <Operators>
 <OperatorCode>HTLBEDS</OperatorCode>
 </Operators>
 <RequestType>ReturnAirAvailability</RequestType>
 <OriginLocation>
 <FlRqDepartureAirport><Code>SYD</Code>
 </FlRqDepartureAirport>
 <FlRqArrivalAirport>
 <Code>GVA</Code>
 </FlRqArrivalAirport>
 </OriginLocation>
 <FlDuration>
 <Days>
 <Value>146</Value>
 </Days>
 </FlDuration>
 <TravelDateInfo>
 <TravelDate></TravelDate>
 <DateVariance>
 <Value>0</Value>
 </DateVariance>
 </TravelDateInfo>
 <TravelPreferences>
 <Outbound>
 <AirlinePrefs>
 <AirlinePref>
 <AirlineCode>LH</AirlineCode>
 </AirlinePref>
 <AirlinePref>
 <AirlineCode>TG</AirlineCode>
 </AirlinePref>
 <AirlinePref>
 <AirlineCode>SQ</AirlineCode>
 </AirlinePref>
 <AirlinePref>
 <AirlineCode>QF</AirlineCode>
 </AirlinePref>
 <AirlinePref>
 <AirlineCode>LX</AirlineCode>
 </AirlinePref>
 <AirlinePref>
 <AirlineCode>CX</AirlineCode>
 </AirlinePref>
 </AirlinePrefs>
 <TimePrefs>
 <DepartureTime></DepartureTime>
 </TimePrefs>
 </Outbound>
 <Inbound>
 <AirlinePrefs>
 <AirlinePref><AirlineCode>LH</AirlineCode>
 </AirlinePref>
 <AirlinePref>
 <AirlineCode>TG</AirlineCode>
 </AirlinePref>
 <AirlinePref>
 <AirlineCode>SQ</AirlineCode>
 </AirlinePref>
 <AirlinePref>
 <AirlineCode>QF</AirlineCode>
 </AirlinePref>
 <AirlinePref>
 <AirlineCode>LX</AirlineCode>
 </AirlinePref>
 <AirlinePref>
 <AirlineCode>CX</AirlineCode>
 </AirlinePref>
 </AirlinePrefs>
 <TimePrefs>
 <DepartureTime>00:00:00</DepartureTime>
 </TimePrefs>
 </Inbound>
 <CabinPrefs>
 <CabinPref>
 <CabinType>Economy</CabinType>
 </CabinPref>
 </CabinPrefs>
 </TravelPreferences>
 <TravelerInformation>
 <PassengerTypeQuantity>
 <PersonAgeCode>A</PersonAgeCode>
 <Quantity>1</Quantity>
 </PassengerTypeQuantity>
 </TravelerInformation>
 <PriceRequestInformation>
 <SearchingFares>PublicAndPrivate</SearchingFares>
 <UseBargainFinder>false</UseBargainFinder>
 <Currency>AUD</Currency>
 </PriceRequestInformation>
 <AgencyReference/>
 <Portion>
 <KeepRequesting>true</KeepRequesting>
 <StopCriteria>
 <StopCriterion>
 <CollectingStopCriterion>ValueIsTime</CollectingStopCriterion>
 <StopCriterionValue><Value>0</Value>
 </StopCriterionValue>
 </StopCriterion>
 </StopCriteria>
 </Portion>
 </FlightAvailabilityRequest>
 </soap:Body>
</soap:Envelope>';   // data from the form, e.g. some ID number

           $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        "SOAPAction: http://topdog.uk.net/BlackBox/FindAvailableFlights", 
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

