<?php
$URL = urldecode($_GET['url']);
$FileName = urldecode($_GET['title']) . '.' . urldecode($_GET['type']);
if (! empty($URL) && substr($URL, 0, 8) === 'https://') {
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment;filename=\"$FileName\"");
    header("Content-Transfer-Encoding: binary");
    readfile($URL);
    echo "Download Successfully";
}
?>