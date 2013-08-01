<form enctype="multipart/form-data" action="index.php" method="POST">
Upload a Zip Archive (*.zip): <input name="zip" id="up" type="file" /><input type="submit" value="Upload" />
</form>

<?php
/* UnZip on Server */


if(isset($_FILES['zip'])) // ie. "on postback"
{
	require_once('pclzip.lib.php'); // a noter ki ca zistoire la CARREMENT enn program zip en php o_O 

	$upload_dir = 'zip'; //your upload directory NOTE: CHMODD 777, php bizin kav ecrir ladan.
	$filename = $_FILES['zip']['name']; //the zipfilename



	//move file
	if(move_uploaded_file($_FILES['zip']['tmp_name'], $upload_dir.'/'.$filename))
	    echo "Uploaded ". $filename . " - ". $_FILES['zip']['size'] . " bytes<br />";
	else
		die("<font color='red'>Error : Unable to upload file</font><br />"); // quick dirty way, you might want to go with css

	
	
	$zip_dir = basename($filename, ".zip"); //get filename without extension fpr folder creation

	//create directory if doesn't exist, et chmod 777 :P

	$url=$upload_dir.'/'.$zip_dir;

	if(!file_exists($url) && !is_dir($url)) @mkdir($url, 0777) or die("<font color='red'>Error : Unable to create directory</font><br />");


	// magic begins here
	
	$archive = new PclZip($upload_dir.'/'.$filename); // create new object from file using library.

	if ($archive->extract(PCLZIP_OPT_PATH, $upload_dir.'/'.$zip_dir) == 0) // if fails
		die("<font color='red'>Error : Unable to unzip archive</font>");

	
	//show what was extracted
	$list = $archive->listContent();
	
	echo "<br /><b>Files in Archive</b><br />";
	
	for ($i=0; $i<sizeof($list); $i++) 
	{
		if(!$list[$i]['folder'])
			$bytes = " - ".$list[$i]['size']." bytes";
		else
			$bytes = "";

		echo "".$list[$i]['filename']."$bytes<br />";

	}
	unlink($upload_dir.'/'.$filename); //delete uploaded file
}
?>