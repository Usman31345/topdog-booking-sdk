<?php
        //Data, connection, auth
        // $dataFromTheForm = $_POST['fieldName']; // request data from the form
        $soapUrl = "https://bwe.topdog.uk.net:8143/load-balancer/blackbox"; // asmx URL of WSDL
        $soapUser = "BTPWS";  //  username
        $soapPassword = "xx!239562"; // password
        $getSesssionId = $_REQUEST['_s'];
        // xml post structure
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:blac="http://topdog.uk.net/BlackBox">
   <soapenv:Header/>
   <soapenv:Body>
      <blac:HotelAvailabilityRequest>
         <blac:SessionId>'.$getSesssionId.'</blac:SessionId>
         <blac:StayDateRange>
            <blac:Start>2020-10-01T00:00:00.000Z</blac:Start>
            <blac:End>2020-10-08T00:00:00.000Z</blac:End>
         </blac:StayDateRange>
         <blac:RoomStayCandidate>
            <blac:GuestCounts>
               <blac:PerRoom>
                  <blac:PerRoomRecordNumber>1</blac:PerRoomRecordNumber>
                  <blac:Adults>
                     <blac:Person>
                        <blac:Age>
                           <blac:Value></blac:Value>
                        </blac:Age>
                     </blac:Person>
			                  <blac:Person>
                        <blac:Age>
                           <blac:Value></blac:Value>
                        </blac:Age>
                     </blac:Person>
                  </blac:Adults>
               </blac:PerRoom>
            </blac:GuestCounts>
         </blac:RoomStayCandidate>
         <blac:HotelSearchCriterion>
            <blac:OperatorHotelCodes>
               <blac:OperatorHotelCode>
                  <blac:OperatorCode>WORLD2MEET</blac:OperatorCode>
                  <blac:HotelCode>JP035279</blac:HotelCode>
               </blac:OperatorHotelCode>
            </blac:OperatorHotelCodes>
         </blac:HotelSearchCriterion>
         <blac:MarketCountryCode>GB</blac:MarketCountryCode>
      </blac:HotelAvailabilityRequest>
   </soapenv:Body>
</soapenv:Envelope>';






      /*  $xml_post_string = '<?xml version="1.0" encoding="UTF-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
 <soap:Body>
 <HotelAvailabilityRequest xmlns="http://topdog.uk.net/BlackBox">
 <SessionId>9f6fb3844c3b0073cf6c4ac8ac095e3c-08262038/DEMO</SessionId>
 <Operators>
 <OperatorCode>LCBXML</OperatorCode>
 <OperatorCode>YOUTRAVEL</OperatorCode>
 <OperatorCode>MH</OperatorCode>
 <OperatorCode>JUMBO</OperatorCode>
 <OperatorCode>BDS</OperatorCode>
 <OperatorCode>BWE</OperatorCode>
 </Operators>
 <StayDateRange>
 <Start>2009-02-21</Start>
 <End>2009-02-28</End>
 </StayDateRange>
 <RoomStayCandidate>
 <GuestCounts>
 <PerRoom>
 <PerRoomRecordNumber>1</PerRoomRecordNumber>
 <Adults>
 <Person>
 <Age>
 <Value>0</Value>
 </Age>
 </Person>
 <Person>
 <Age>
 <Value>0</Value>
 </Age>
 </Person>
 <Person>
 <Age>
 <Value>0</Value>
 </Age>
 </Person>
 </Adults>
 </PerRoom>
 <PerRoom>
 <PerRoomRecordNumber>2</PerRoomRecordNumber>
 <Adults>
 <Person/>
 <Person/>
 </Adults>
 </PerRoom>
 </GuestCounts>
 </RoomStayCandidate>
 <HotelSearchCriterion>
 <BoardTypeCode>AI</BoardTypeCode>
 <Locations>
 <Location>
 <AirportCode>LPA</AirportCode>
 </Location>
 </Locations>
 </HotelSearchCriterion>
 <MarketCountryCode>GB</MarketCountryCode>
 <Portion>
 <KeepRequesting>true</KeepRequesting>
 <StopCriteria>
 <StopCriterion>
 <CollectingStopCriterion>ValueIsSize</CollectingStopCriterion>
 <StopCriterionValue>
 <Value>200</Value>
 </StopCriterionValue>
 </StopCriterion>
 <StopCriterion>
 <CollectingStopCriterion>ValueIsTime</CollectingStopCriterion>
 <StopCriterionValue>
 <Value>35</Value>
 </StopCriterionValue>
 </StopCriterion>
 </StopCriteria>
 <CriteriaCombiningRule>Any</CriteriaCombiningRule>
 <MaxPortionSize>
 <Value>200</Value>
 </MaxPortionSize>
 </Portion>
 </HotelAvailabilityRequest>
 </soap:Body>
</soap:Envelope>';   // data from the form, e.g. some ID number */

           $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        "SOAPAction: http://topdog.uk.net/BlackBox/FindAvailableHotels",
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
echo $response; die;
            // converting
            $response1 = str_replace("<soap:Body>","",$response);
            $response2 = str_replace("</soap:Body>","",$response1);


            // convertingc to XML
            $parser = simplexml_load_string($response2);
            // return $parser;
            // user $parser to get your data out of XML response and to display it.
