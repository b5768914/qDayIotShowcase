<?php

$entity = $_GET['entity'];

$AZURE_ACC_NAME = getenv('stacName');
$AZURE_PRIMARY_KEY = getEnv('stacAccessKey');
$AZURE_TABLE = "deviceState";
$AZURE_TABLE2 = "sensorReadings";
$AZURE_TABLE3 = "deviceErrors";


if($entity=="stats"){
    $date = gmdate('D, d M Y H:i:s T',time());
    $StringToSign = 'GET' . "\n" . 
                ''. "\n" . //Content-MD5
                '' . "\n" . //Content-Type
                $date. "\n" .
               '/'.$AZURE_ACC_NAME.'/'.$AZURE_TABLE2.'(PartitionKey=\'QunisIotShowcaseDevice1\',RowKey=\'x_accel_std\')';
    //echo $StringToSign;
    $sig = base64_encode(
        hash_hmac('sha256', urldecode($StringToSign), base64_decode($AZURE_PRIMARY_KEY), true)
    );
    
    $endpoint = 'https://'.$AZURE_ACC_NAME.'.table.core.windows.net';
    $url = $endpoint.'/'.$AZURE_TABLE2.'(PartitionKey=\'QunisIotShowcaseDevice1\',RowKey=\'x_accel_std\')';
    
    $headers = [
        "x-ms-date:{$date}",
        'x-ms-version:2014-02-14',
        'Accept:application/json;odata=nometadata',
        "Authorization:SharedKey ".$AZURE_ACC_NAME.":{$sig}"
    ];
    //var_dump($headers);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response  = curl_exec($ch);
    echo($response);
    echo curl_error($ch);
    curl_close($ch);
}

if($entity=="errors"){
    $date = gmdate('D, d M Y H:i:s T',time());
    $StringToSign = 'GET' . "\n" . 
                ''. "\n" . //Content-MD5
                '' . "\n" . //Content-Type
                $date. "\n" .
               '/'.$AZURE_ACC_NAME.'/'.$AZURE_TABLE3.'(PartitionKey=\'QunisIotShowcaseDevice1\',RowKey=\'x_accel_std\')';
    //echo $StringToSign;
    $sig = base64_encode(
        hash_hmac('sha256', urldecode($StringToSign), base64_decode($AZURE_PRIMARY_KEY), true)
    );
    
    $endpoint = 'https://'.$AZURE_ACC_NAME.'.table.core.windows.net';
    $url = $endpoint.'/'.$AZURE_TABLE3.'(PartitionKey=\'QunisIotShowcaseDevice1\',RowKey=\'x_accel_std\')';
    
    $headers = [
        "x-ms-date:{$date}",
        'x-ms-version:2014-02-14',
        'Accept:application/json;odata=nometadata',
        "Authorization:SharedKey ".$AZURE_ACC_NAME.":{$sig}"
    ];
    //var_dump($headers);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response  = curl_exec($ch);
    echo($response);
    echo curl_error($ch);
    curl_close($ch);
}

if($entity=="status"){
    $date = gmdate('D, d M Y H:i:s T',time());
    $StringToSign = 'GET' . "\n" . 
                ''. "\n" . //Content-MD5
                '' . "\n" . //Content-Type
                $date. "\n" .
               '/'.$AZURE_ACC_NAME.'/'.$AZURE_TABLE.'(PartitionKey=\'QunisIotShowcaseDevice1\',RowKey=\'rotor\')';
    //echo $StringToSign;
    $sig = base64_encode(
        hash_hmac('sha256', urldecode($StringToSign), base64_decode($AZURE_PRIMARY_KEY), true)
    );
    
    $endpoint = 'https://'.$AZURE_ACC_NAME.'.table.core.windows.net';
    $url = $endpoint.'/'.$AZURE_TABLE.'(PartitionKey=\'QunisIotShowcaseDevice1\',RowKey=\'rotor\')';
    
    $headers = [
        "x-ms-date:{$date}",
        'x-ms-version:2014-02-14',
        'Accept:application/json;odata=nometadata',
        "Authorization:SharedKey ".$AZURE_ACC_NAME.":{$sig}"
    ];
    //var_dump($headers);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response  = curl_exec($ch);
    echo($response);
    echo curl_error($ch);
    curl_close($ch);
}


?>