<?php
ob_start();
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Max-Age: 100000');
if (!isset($_SESSION)) {
	session_start();
}

uploadCleanImage();
function uploadCleanImage() {
print "\n\nUpload clean image has been called\n\n";
//$_POST["image"] = json_encode(image);
//$_POST["passedFileName"] = json_encode(passedFileName);

//$path= '';
//$type = pathinfo($path, PATHINFO_EXTENSION);
//$data = file_get_contents($path);
//$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);


// make sure the image-data exists and is not empty
// php is particularly sensitive to empty image-data 
if ( isset($_POST["image"]) && !empty($_POST["image"]) ) {    

    // get the dataURL
    $dataURL = $_POST["image"];  

    // the dataURL has a prefix (mimetype+datatype) 
    // that we don't want, so strip that prefix off
    $parts = explode(',', $dataURL);  
    $data = $parts[1];

    // Decode base64 data, resulting in an image
    $data = base64_decode($data);

    // create a temporary unique file name
    $file = "../uploads/images/clean_".$_POST["passedFileName"];
	$_SESSION["cleanFileName"] = $file;
	
	print "The cleanFileName session is set to ".$_SESSION["cleanFileName"]."\n";
	//$_SESSION['cleanFileName'] = $_POST["passedFileName"];

    // write the file to the upload directory
    $success = file_put_contents($file, $data);

    // return the temp file name (success)
    // or return an error message just to frustrate the user (kidding!)
    print $success ? $file : 'Unable to save this image.';
	print "\n";
}
}
ob_end_flush();
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-29056778-4', 'auto');
  ga('send', 'pageview');

</script>