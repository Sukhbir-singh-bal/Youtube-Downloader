<?php
function getBasejsFile($playerID){
      $curl = curl_init();
      curl_setopt_array($curl, [
        CURLOPT_URL => "https://www.youtube.com/s/player/$playerID/player_ias.vflset/en_US/base.js",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
      ]);
      
      $response = curl_exec($curl);
      $err = curl_error($curl);
      
      curl_close($curl);
      
      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        return $response;
      }
}

function findFunctions($code) {
      
//used to find decrypt functions in youtubes's base.js file
      
  $functionRegex = '/(\w+)\s*=\s*function\s*\(([^)]*)\)({a=a.split\(""\))\s*([^}]*)\s*}/';
  preg_match($functionRegex, $code, $functionMatch);
  
  if ($functionMatch) {
      $matchstr = $functionMatch[0];
      $varRegex = '/(\(""\);)\s*([^.]*)/';
      preg_match($varRegex, $matchstr, $varMatch);
      
      if ($varMatch) {
          $parts = explode(";", $varMatch[0]);
          $secondfuncregex = "/var " . escapeSpecialCharacters($parts[1]) . "=\\{[\\s\\S]*?\\}\\}/";
          preg_match($secondfuncregex, $code, $secondvar);
          if ($secondvar) {
                
/* after successfully find both cipher functions write it to decrypt.js file 
   In PHP we can't directly execute javascript functions we use this file for decrypt the urls */
                
              $file = fopen("decrypt.js", "w") or die("Unable to open file!");
              $data = $secondvar[0]."\n\n".$functionMatch[0]."\n\n"."let decryptfunc = $functionMatch[1]";
              if ($file) {
                fwrite($file, $data);
                fclose($file);
              }
              header("Location: /",302);
          }
      }
  } else {
      echo "No matches found.\n";
  }
}
function escapeSpecialCharacters($string) {
  $specialChars = array('\\', '.', '+', '*', '?', '[', '^', ']', '$', '(', ')', '{', '}', '=', '!', '<', '>', '|', ':', '-');
  
  foreach ($specialChars as $char) {
      $string = str_replace($char, '\\' . $char, $string);
  }
  
  return $string;
}



//  initial request to find current player file.
$curl = curl_init();
curl_setopt_array($curl, [
  CURLOPT_URL => "https://www.youtube.com/iframe_api",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "Accept: */*",
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "Invalid Request for get Player ID";
} else {
    $pattern = '#(?:player)\\\/(.*?)(?=\\\/www-widgetapi)#';
    try {
      if (preg_match($pattern, $response, $matches)) {
          $result = $matches[1];
          $codeString = getBasejsFile($result);
          findFunctions($codeString);
      } else {
          echo "No match found.";
      }
    } catch (Exception $e) {
      echo "An error occurred while match Player ID : " . $e->getMessage();
    }
}

?>
