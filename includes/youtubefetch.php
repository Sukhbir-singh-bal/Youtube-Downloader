<?php
class youtubefetch
{
    public $metadata;
    private $errormessage;
    function __construct($metadata)
    {
        $this->metadata = $metadata;
    }
    public function getBasicInfo()
    {
        if (isset($this->metadata->videoDetails)) {
            $videoDetails = $this->metadata->videoDetails;
            $title = isset($videoDetails->title) ? $videoDetails->title : 'Undefined';
            $duration = gmdate("H:i:s", $videoDetails->lengthSeconds);
            $thumbnail = isset($videoDetails->thumbnail->thumbnails[2]->url) ? $videoDetails->thumbnail->thumbnails[2]->url : '';
            $result[] = [
                "title" => $title,
                "duration" => $duration,
                "thumbnail" => $thumbnail
            ];
            $result = json_encode($result);
            return $result;
        } else {
            $this->errormessage = "Failed to retrieve video information.";
        }
    }
    public function getVideos()
    {
        $requireQualities = ["1080p", "AUDIO_QUALITY_MEDIUM"];  // required adaptive qualities Note: Videos in adaptive formats don't have audio stream
        if (!empty($this->metadata->streamingData->formats) && $this->metadata->streamingData->formats <> "") {
            $result = [];
            foreach ($this->metadata->streamingData->formats as $data) {
                $format = explode(";", $data->mimeType);
                $quality = $data->qualityLabel;
                $url = "";
                if (property_exists($data, "url")) {
                    $url = $data->url;
                }
                if (property_exists($data, "signatureCipher")) {
                    $url = $this->decryptUrl($data->signatureCipher);
                }
                $result[] = [
                    "audio" => true,
                    "format" => $format[0],
                    "quality" => $quality,
                    "url" => $url
                ];
            }
            foreach ($this->metadata->streamingData->adaptiveFormats as $data) {
                $format = explode(";", $data->mimeType);
                $quality = str_contains($format[0], "audio") ? $data->audioQuality : $data->qualityLabel;
                $url = "";
                if (in_array($quality, $requireQualities)) {
                    if (property_exists($data, "url")) {
                        $url = $data->url;
                        $result[] = [
                            "cipher"=>false,
                            "audio" => str_contains($format[0], "audio") ? true : false,
                            "format" => $format[0],
                            "quality" => $quality,
                            "url" => $url
                        ];
                    }
                    if (property_exists($data, "signatureCipher")) {
                        $url = $data->signatureCipher;
                        preg_match('/s=([^&]+)/', $url, $ciphermatches);      // extract cipher from url
                        preg_match('/url=([^&]+)/', $url, $urlmatches); 
                        $signature =urldecode($ciphermatches[1]);      // extract url without cipher
                        $url =urldecode($urlmatches[1]);      // extract url without cipher
                        $result[] = [
                            "cipher"=>true,
                            "audio" => str_contains($format[0], "audio") ? true : false,
                            "format" => $format[0],
                            "quality" => $quality,
                            "signature"=> $signature ,
                            "url" => $url
                        ];
                    }
                    

                    //used to get only one video from adaptive formats for required formats
                    $key = array_search($quality, $requireQualities);
                    if ($key !== false) {
                        unset($requireQualities[$key]);
                    }
                }
            }
            return json_encode($result);
        } else {
            $this->errormessage = "Failed to retrieve URLs";
        }
    }
    public function decryptUrl($url)
    {
        preg_match('/s=([^&]+)/', $url, $ciphermatches);      // extract cipher from url
        preg_match('/url=([^&]+)/', $url, $urlmatches);       // extract url without cipher
        if (isset($ciphermatches[1]) and isset($urlmatches[1])) {
            $ciphher = urldecode($ciphermatches[1]);
            $decryptCode = $this->decryptalgo($ciphher);
            $url = urldecode($urlmatches[1]) . "&sig=" . $decryptCode;
        }
        return $url;
    }
    public function decryptalgo($a)
    {

        $a = str_split($a);
        array_splice($a, 0, 1);
        $a = array_reverse($a);
        $c = $a[0];
        $a[0] = $a[53 % count($a)];
        $a[53 % count($a)] = $c;
        array_splice($a, 0, 1);
        $c = $a[0];
        $a[0] = $a[31 % count($a)];
        $a[31 % count($a)] = $c;
        array_splice($a, 0, 3);
        $a = array_reverse($a);
        array_splice($a, 0, 2);
        return implode("", $a);
    }
    public function hasErrors()
    {
        return isset($this->errormessage);
    }
    public function getErrorMessage()
    {
        return $this->errormessage;
    }
}
