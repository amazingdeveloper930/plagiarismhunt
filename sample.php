<?php
function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function callAPI( $url){
   $curl = curl_init();

   // curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'X-API-Key: 445cce26d74e6597be72172552359ccf',
      'Content-Type: application/json',
   ));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   return $result;
}



$ipaddress = getUserIpAddr();
$res = file_get_contents('https://www.iplocate.io/api/lookup/' + $ipaddress );
$res = json_decode($res);
var_dump($res);
echo "let";

$value = callAPI('https://www.iplocate.io/api/lookup/' + $ipaddress );
echo $value;

?>