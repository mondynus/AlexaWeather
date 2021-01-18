<?php
$json = file_get_contents("https://api.weather.com/v2/pws/observations/current?stationId=IJASLO1&format=json&units=m&apiKey=*APIKEY*");


$data=json_decode($json);


$temp= $data->observations[0]->metric->temp;
$temp_evohome= $data_evohome->temp;
$wind= $data->observations[0]->metric->windSpeed;
$windgust= $data->observations[0]->metric->windGust;
$rain=$data->observations[0]->metric->precipTotal;

$date = new \DateTime('now');
$datestring=$date->format('Y-m-d\TH:i:s\.\0\Z');

        $body="{
    'input':{
      'text':'Vonku je ".$temp." stupňov, fúka vietor o sile ".$wind." kilometrov za hodinu a v nárazoch ".$windgust." kilometrov za hodinu, úhrn zrážok za dnešný deň ".$rain." milimetrov. '
    },
    'voice':{
      'languageCode':'sk-SK',
      'name':'sk-SK-Wavenet-A',
      'ssmlGender':'FEMALE'
    },
    'audioConfig':{
      'audioEncoding':'MP3'
    }
  }";

        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "https://texttospeech.googleapis.com/v1beta1/text:synthesize");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'X-Goog-Api-Key: *APIKEY*',
          'Content-Type: application/json; charset=utf-8'
        ));
        // $output contains the output string
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $body);
        $output = curl_exec($ch);
      //echo $output;
        $json=json_decode($output);
        // close curl resource to free up system resources
        curl_close($ch);     

        $filemp3=base64_decode($json->audioContent);
        header('Content-type: {$mime_type}');
        header("Content-Transfer-Encoding: binary"); 
        header("Content-Type: audio/mpeg, audio/x-mpeg, audio/x-mpeg-3, audio/mpeg3");  
        header('Content-Disposition: filename="audio.mp3"');
        header('X-Pad: avoid browser bug');
        header('Cache-Control: no-cache');
       
        echo $filemp3;

?>