<?php
/**
 * github web hook
 * @author Bruce Paverd
 */


// perform json_decode of receiving $_POST
if (get_magic_quotes_gpc()) {
    $payload = json_decode(stripslashes($_POST['payload']), TRUE);
}
else {
    $payload = json_decode($_POST['payload'], TRUE);
}

$filename = '/tmp/log.txt';

// overwrite file
if (!$handle = fopen($filename, 'a')) {
 exit;
}

// write to log file
//$data = print_r($payload, TRUE);

// write to our opened file.
//if (fwrite($handle, $data) === FALSE) {
    //exit;
//}  


$commits = $payload["commits"];

if(!empty($commits)) {

    foreach ($commits as $value) {

	$message = $value["message"];
	// fwrite($handle, $message);
	// fwrite($handle, "\n");
        
	// If this is a merge of a branch to prod
        if(substr($message, 0, 6) === 'Merge ' &&
	   substr($message, -7) === "to prod") {

	    $sbstr = strstr($message, "'");
	    $sbstr = substr($sbstr, 1);

	    $position_num = strpos($sbstr, "'");
	    $branch_name = substr($sbstr, 0, $position_num);

	    fwrite($handle, "Branch name: ");
            fwrite($handle, $branch_name);
	    fwrite($handle, "\n");

	    exec("/home/rcn2/www/gitposthook/gitcreatetag.sh $branch_name 2>&1", $result);
	    $data = print_r($result, TRUE);
	    fwrite($handle, $data);
	    fwrite($handle, "\n");

	}

    }

} else {

    fwrite($handle, "Nothing in commits array\n");

}

fclose($handle);

