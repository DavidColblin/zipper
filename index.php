 <?php
 
 unzip('Desktop.zip', 'unzipped Items');
 
 function unzip($itemPath , $destination)
 {
     $zip = new ZipArchive;
     if ($zip->open($itemPath) === TRUE) {
         $zip->extractTo($destination."/".$itemPath);
         $zip->close();
         echo 'Zip extracted to  "'. $destination."/".$itemPath . '" folder.';
     } else {
         echo 'Zip extraction failed.';
     }
 }
 
 function listItems($directory){
	
 }
?> 