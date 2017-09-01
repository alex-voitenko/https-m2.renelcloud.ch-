<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$urlDataService = 'http://192.168.18.117:9763/services/renelco_bma_dev/getActivity';
$activity_id = 1;
$data = array("activity_id" => "2");                                                                    
$headers = array();
$headers[] = 'Cache-Control: no-cache';
$headers[] = 'Content-Type: text/xml';
$headers[] = 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0';

/*
//echo '1- ' . $urlDataService . '<br/>';


$ch = curl_init();  

//echo '2- ' . $urlDataService . '<br/>';

curl_setopt_array($ch, array(
    CURLOPT_HEADER => TRUE,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_URL => "http://5.144.37.152:547/services/renelco_bma_dev/getActivity",
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_TIMEOUT => 40,
    CURLOPT_POST => TRUE
));

//    CURLOPT_URL => "https://192.168.18.117:9763/services/renelco_bma_dev/getActivity",



//echo '3- ' . $urlDataService . '<br/>';
                       
$result = curl_exec($ch);                            

//echo '4- ' . $urlDataService . '<br/>';


if(curl_errno($ch)) {
    print curl_error($ch)."<br/>";
}
else {
    
    $collaborators = simplexml_load_string($result);
    echo 'COLLABORATORS: <br/>';
    echo $result;

    foreach($collaborators->Row as $row) {
        echo $row->ACTIVITY_ID;
        echo '<br/>';
        echo $row->NAME;
        echo '<br/>';
        echo $row->DESCRIPTION;
        echo '<br/>';
    }
//    print_r(json_decode(json_encode(simplexml_load_string($result)), true))."<br/>";

    
//    $jsonIterator = new RecursiveIteratorIterator(
//    new RecursiveArrayIterator(json_decode(json_encode(simplexml_load_string($result)), true)),
//    RecursiveIteratorIterator::SELF_FIRST);

//    print_r($json.'<br/><br/>');
    
    
    
//    foreach ($jsonIterator as $key => $val) {
//        if(is_array($val)) {
//           print_r($key.'<br/>');
//        } else {
//           echo $key.'<br/><br/>';
//        }
//    }
//    print_r(simplexml_load_string($result).'<br/>');
}    
//echo '<br/>5- The End <br/>';

curl_close($ch);
*/
/*
$url = 'http://192.168.18.17:9763/services/renelco_bma_dev/getActivities';
$result = file_get_contents($url);
$activities = simplexml_load_string($result);
foreach($activities->Row as $row) {
    echo $row->ACTIVITY_ID;
    echo '<br/>';
    echo $row->NAME;
    echo '<br/>';
    echo $row->DESCRIPTION;
    echo '<br/>';
    echo '<br/>';
}
    echo '<br/>';
    echo '<br/>';
    echo '<br/>';
    echo '<br/>';
*/
$url = 'http://192.168.18.117:9763/services/renelco_bma_dev/getDeviceCollaborators';
$result = file_get_contents($url);
$devices = simplexml_load_string($result);
foreach($devices->Row as $row) {
    echo $row->IMEI;
    echo '<br/>';
    echo $row->COLLABORATOR_ID;
    echo '<br/>';
    echo $row->NAME;
    echo '<br/>';
    echo $row->MODEL;
    echo '<br/>';
    echo $row->MANUFACTURER;
    echo '<br/>';
    echo $row->OS;
    echo '<br/>';
    echo $row->VERSION;
    echo '<br/>';
    echo $row->GENDER_ID;
    echo '<br/>';
    echo $row->MANAGER_ID;
    echo '<br/>';
    echo $row->ADDRESS_ID;
    echo '<br/>';
    echo $row->COLLABORATOR_TYPE_ID;
    echo '<br/>';
    echo $row->LASTNAME;
    echo '<br/>';
    echo $row->FIRSTNAME;
    echo '<br/>';
    echo $row->EMAIL;
    echo '<br/>';
    echo $row->MOBILENR;
    echo '<br/>';
    echo $row->COST;
    echo '<br/>';
    echo $row->PICTURE_URL;
    echo '<br/>';
    echo $row->APP_ADMIN;
    echo '<br/>';
    echo '<br/>';
}



/*
$data = array('activity_id' => '2');
// use key 'http' even if you send the request to https://...
$options = array(
  'http' => array(
    'header'  => "Content-Type: text/xml'\r\n",
    'method'  => 'GET',
    'content' => http_build_query($data),
  ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
var_dump($result);
*/
