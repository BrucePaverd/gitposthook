<?php
/**
 * github web hook
 * @author revvi
 */

// perform json_decode of receiving $_POST
if (get_magic_quotes_gpc()) {
    $payload = json_decode(stripslashes($_POST['payload']), TRUE);
}
else {
    $payload = json_decode($_POST['payload'], TRUE);
}

$filename = 'log.txt';

// write to log file
$data = print_r($payload, TRUE);

if (is_writable($filename)) {
    // overwrite file
    if (!$handle = fopen($filename, 'w')) {
         exit;
    }
    // write to our opened file.
    if (fwrite($handle, $data) === FALSE) {
        exit;
    }  
    fclose($handle);
}
