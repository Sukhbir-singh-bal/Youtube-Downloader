<?php 
include 'youtubefetch.php';
function generateVisitorKey($length = 54) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';
    $visitorKey = '';
    for ($i = 0; $i < $length; $i++) {
        $visitorKey .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $visitorKey;
}
function returnError($error){
    echo json_encode(["error"=>$error]);
}
function getMetaData($videoId, $key)
{
    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_URL => "https://www.youtube.com/youtubei/v1/player?key=$key",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "{\r\n  \"videoId\": \"$videoId\",\r\n  \"context\": {\r\n    \"client\": {\r\n      \"clientName\": \"TVHTML5_SIMPLY_EMBEDDED_PLAYER\",\r\n      \"clientVersion\": \"2.0\"\r\n    },\r\n    \"thirdParty\": {\r\n      \"embedUrl\": \"https://www.youtube.com\"\r\n    }\r\n  }\r\n}",
      CURLOPT_HTTPHEADER => [
        "Accept: */*",
        "Content-Type: application/json",
      ],
    ]);
    $curlResult = curl_exec($curl);
    if (curl_errno($curl)) {
        $error = curl_error($curl);
        returnError($error);
    }
    curl_close($curl);
    $result = json_decode($curlResult);
    if ($result === null) {
        returnError("Failed to retrieve data");
    } else {
        return $result;
    }
}

if(isset($_POST["Url"]) and !empty($_POST["Url"])){
    $url = $_POST["Url"];
    $regrex = "";
    if(str_contains($url,"https://www.youtube.com/watch?v=")){
        $regex = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';
    }elseif(str_contains($url,"https://www.youtube.com/shorts/")){
        $regex = '/(?:youtube\.com\/shorts\/|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
    }else{
        returnError("Please provide a valid URL");
    }
    if(preg_match($regex, $url, $match)){
        $youtubeVideoId = $match[1];
        $visitorKey = generateVisitorKey();
        $MetaData = getMetaData($youtubeVideoId,$visitorKey);
        $obj = new youtubefetch($MetaData);
        $result = "[".$obj->getBasicInfo().",".$obj->getVideos()."]";
        if($obj->hasErrors()){
            $error = $obj->getErrorMessage();
            returnError($error);
        }else{
            echo $result;
        }
    }else{
        returnError("The video ID is invalid");
    }
       
    }
    else{
    returnError("Request failed. Please try again");
}
