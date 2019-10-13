<?php
ob_start();

if (!isset($_SESSION)) {
	session_start();
}

function uploadDirtyImage() {

if (isset($_FILES["file"]["name"])) {



	if ( (strcmp($_FILES["file"]["name"],""))!=0 ) {
		$allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG");
		$temp = explode(".", $_FILES["file"]["name"]);

		$extension = end($temp);

		if ((($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/jpg")
		|| ($_FILES["file"]["type"] == "image/JPG")
		|| ($_FILES["file"]["type"] == "image/JPEG")
		|| ($_FILES["file"]["type"] == "image/pjpeg")
		|| ($_FILES["file"]["type"] == "image/x-png")
		|| ($_FILES["file"]["type"] == "image/png"))
		&& ($_FILES["file"]["size"] <= 2097152) /*Size of file in bytes; equivalent to 2MB*/
		&& in_array($extension, $allowedExts)) {
			$_FILES["file"]["name"] = date('Ymd_gi_s_a.').$extension;
			if ($_FILES["file"]["error"] > 0) {
				echo "Error: " . $_FILES["file"]["error"] . "<br />";
			}
			else {
			
				//echo '<img src="images/confirm.png" alt="_" width="15" height="11" />'."Upload: " . $_FILES["file"]["name"] . "<br />";
				//echo '<img src="images/confirm.png" alt="_" width="15" height="11" />'."Type: " . $_FILES["file"]["type"] . "<br />";
				//echo '<img src="images/confirm.png" alt="_" width="15" height="11" />'."Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
				//echo '<img src="images/confirm.png" alt="_" width="15" height="11" />'."Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
			
				if (file_exists("uploads/images/" . $_FILES["file"]["name"])) {
					//echo '<img src="images/fail.png" alt="_" width="16" height="16" />'.$_FILES["file"]["name"] . " already exists.<br /> Please try again.";
					$_SESSION["notifier"] = "";
					unset($_SESSION["notifier"]);
				}				  
				else {
					move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/images/" . $_FILES["file"]["name"]);
					$_SESSION["dirtyFileName"] = $_FILES["file"]["name"];
					$_SESSION['filename'] = $_FILES["file"]["name"];
					$_SESSION["notifier"] = "";
					//cleanImage();
					?>
					<script>
/*                        $.ajax({
                          type: "POST",
                          url: "imagePreprocessingModule.php",
                          data: {
                              bluh: 'bluh'
                          }

                        }).done(function(respond) {
                          console.log('imagePreprocessingModule.php has been called to clean the file');
						  console.log('The file in session is <?php //echo json_encode($_SESSION["file_name"]); ?>');
                          //console.log(respond);
                        });
*/
					</script>

					<?php
					
					//require 'imagePreprocessingModule.php';
					//echo '<img src="images/confirm.png" alt="_" width="15" height="11" />'."Stored in: " . "uploads/images/" . $_FILES["file"]["name"]."<br />";
					//echo '<img src="images/confirm.png" alt="_" width="15" height="11" />'."Upload Successful.<br />";

				}
			}
		}
        }
}
}//End of function uploadImage();


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