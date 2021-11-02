
   <?php 
        //Data, connection, auth
        // $dataFromTheForm = $_POST['fieldName']; // request data from the form
        $soapUrl = "http://bwe.topdog.uk.net:8180/load-balancer/basket"; // asmx URL of WSDL
        $soapUser = "BTPWS";  //  username
        $soapPassword = "xx!239562"; // password

        // xml post structure

        $xml_post_string = '<?xml version="1.0" encoding="UTF-8"?>
<env:Envelope xmlns:enc="http://schemas.xmlsoap.org/soap/encoding/"
xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
 <env:Body>
 <AddPaymentRequest xmlns="http://topdog.uk.net/BlackBox/BasketOperations"
xsi:schemaLocation="http://topdog.uk.net/BlackBox">
 <SessionId>d78096d7de2e8d60dd9b98760d7964e4-09151335/BRD69</SessionId>
 <CardDetails>
 <CreditCard>
<CardType>VISA</CardType>
<CardNumber>4444333322221111</CardNumber>
<ExpireDate>0124</ExpireDate>
<NameOnCard>Test Test</NameOnCard>
<SecurityNumber>876</SecurityNumber>
</CreditCard>
 <CardHolder>
 <Title>Mr</Title>
 <FirstName>Test</FirstName>
 <Surname>Test</Surname>
 <AddressLine1>Test address</AddressLine1>
 <City>nottingham</City>
 <County>nottinghamshire</County>
 <PostCode>ng10 3pp</PostCode>
 <PhoneNumber>123456789</PhoneNumber>
 <MobileNumber>123456987</MobileNumber>
 <EmailAddress>test@test.com</EmailAddress>
 </CardHolder>
 </CardDetails>
 <Amount>705.6</Amount>
 <PaymentCharge>0</PaymentCharge>
 <PaymentType>CREDIT_CARD</PaymentType>
 <PaymentReference>PAYMENTREF MU</PaymentReference>
 <PaymentDate>2022-09-23</PaymentDate>
 <AuthorisationCode>auth code mu</AuthorisationCode>
 <Manual>
 <Value>true</Value>
 </Manual>
 <UseForAutoPayments>false</UseForAutoPayments>
 <Token>HJHJHJHJHJKK</Token>
 <CardProfileId>HJHJHJHJHJKK</CardProfileId>
 </AddPaymentRequest> 
 </env:Body>
</env:Envelope>';   // data from the form, e.g. some ID number

           $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        "SOAPAction: http://topdog.uk.net/BlackBox/BasketOperations/AddPayment", 
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

