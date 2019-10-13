<?php
ob_start();
if (!isset($_SESSION)) {
	session_start();
}
?>
<!DOCTYPE HTML>
<head>
<title>Smart Harvester - desktop</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="web/css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="web/css/nav.css" rel="stylesheet" type="text/css" media="all"/>
<!-- This just slows me down, iish! <link href='http://fonts.googleapis.com/css?family=Carrois+Gothic+SC' rel='stylesheet' type='text/css'>-->
<script type="text/javascript" src="web/js/jquery.js"></script>
<script type="text/javascript" src="web/js/login.js"></script>
<script type="text/javascript" src="web/js/Chart.js"></script>
<script type="text/javascript" src="web/js/jquery.easing.js"></script>
<script type="text/javascript" src="web/js/jquery.ulslide.js"></script>
<!----Calender -------->
<link rel="stylesheet" href="web/css/clndr.css" type="text/css" />
<script src="web/js/underscore-min.js"></script>
<script src= "web/js/moment-2.2.1.js"></script>
<script src="web/js/clndr.js"></script>
<script src="web/js/site.js"></script>
<!----End Calender -------->

</head>
<body>
<!--/*************************NEEDED FOR IMAGE UPLOAD AND PREPROCESSING************************start*/-->
<!-- Used to execute functions on image load-->
<img id="dirtyFruitImage" style="display:none;">
<img id="cleanFruitImage" style="display:none;">

<?php
if (isset($_POST['beginCycle'])){
	//Starts by uploading the original image which is referred to as
	//"dirty" due to the assumed presence of noise
	require_once ('common/uploadDirtyImage.php');
	uploadDirtyImage();
?>	
	<!-- The "dirty" image is taken through image preprocessing to reduce the level of noise-->
	<!-- The image preprocessing makes use of a Gaussian blurr algorithm to reduce the level of noise-->
	<script src="common/reduceTheNoise.js"></script>

	<script>
	console.log('Dirty image has been uploaded to the server');
	//Assumes the upload of the "dirty" image was successful and goes ahead to clean it
	cleanDirtyImage ();

	function cleanDirtyImage () {
		//Uses the dirtyFileName session variable because the cleanFileName session variable takes too long to be set
		//by the cleanUpload.php file called via AJAX
		var dirtyFileName = <?php echo json_encode($_SESSION["dirtyFileName"]); ?>;
		var dataURL = null;
		var tests = [];
		var test = function(name, var_args) {
			var args = [];
			for (var i=1; i<arguments.length; i++)
				  args.push(arguments[i]);
				  tests.push({name:name, args:args});
		};
		var runTests = function() {
		if (tests.length != 0) {
		  var test = tests.shift();
			  var canvas = null;
			  try {
				var res = Filters[test.name].apply(Filters, test.args);
				canvas = Filters.toCanvas(res);
				//The image that has been taken through a Gaussian blurr algorithm
				//is considered clean and stored with the prefix clean_ in the web server
				if (canvas != null) {
				  dataURL = canvas.toDataURL();
				  //alert(dataURL);
				  //Uploads the cleaned image using cleanUpload.php via AJAX
				  //cleanUpload.php sets the cleanFileName session variable after uploading the file
						$.ajax({
						  type: "POST",
						  url: "common/uploadCleanImage.php",
						  data: {
							  image: dataURL,
							  passedFileName: dirtyFileName
						  },
						  dataType: "json",
						  success: function(event, XMLHttpRequest, ajaxOptions){
						  	console.log("event= "+event);
						  	console.log("XMLHttpRequest= "+XMLHttpRequest);
						  	console.log("ajaxOptions= "+ajaxOptions);
						  	console.log('Clean image has been uploaded to the server');},
						  /*error: function(xhr) {
						  	//alert('Error! Status = ' + xhr.status);
						  	//alert('Response1 = ' + respond);
						  	alert('Response2 = ' + xhr);}*/
						  error: function (xhr, ajaxOptions, thrownError) {
						  	console.log("The xhr status is "+xhr.status);
						  	console.log("The thrown error is "+thrownError);
						  	console.log("ajaxOptions= "+ajaxOptions);}
						}).done(function(respond) {
						  console.log('Dirty image has been cleaned');
						  console.log(respond);
						  //var cleanFileName = <?php //echo json_encode($_SESSION["cleanFileName"]); ?>;
						});
				}
			  } catch(e) {
				console.log(e);
			  }
			  runTests();
		}
		};
		
		var img = document.getElementById('dirtyFruitImage');
		
		img.onload = function() {
			var c = Filters.getPixels(img);
			//A Gaussian Blurr algorithm with a diameter of 8 is considered sufficient to reduce the noise
			//on a browser running on a desktop/laptop PC
			test('gaussianBlur', c, 5);
			runTests();
		};
		
		img.src = 'uploads/images/'+ dirtyFileName;
		console.log("The name of the dirty image is " + dirtyFileName);
		//console.log("Clean image file name = " + cleanFileName);
	}
	</script>
<?php
	//The beginCycle variable is unset so that the upload function is not re-executed upon page reload
	unset($_POST['beginCycle']);
	//The page is refreshed so as to correctly capture the session variable
	header("Refresh:2");
} else {
	if (isset($_SESSION)) {
		//Was used to render the page afresh but later deemed unnecessarry
		//session_destroy();
		//session_start();
	}
}
?>
<!--/*************************NEEDED FOR IMAGE UPLOAD AND PREPROCESSING************************end*/-->

<div class="wrap">	 
	      <div class="header">
	      	  <div class="header_top">
					  <div class="menu">
						  <a class="toggleMenu" href="#"><img src="web/images/nav.png" alt="" /></a>
							<ul class="nav">
								<li><a href="#prediction-div"><i><img src="web/images/statistics.png"></i>Prediction</a></li>
								<li><a href="#prescription-div"><i><img src="web/images/events.png"></i>Prescription</a></li>
								<li><a href="common/colour-index.html" target="_blank"><i><img src="web/images/favourite.png" alt="" /></i>Colour Index</a></li>
								<li><a href="common/pawpaw-fruit-images-for-demo1.zip" target="_self"><i><img src="web/images/invites.png"></i>Test Data </a></li>
							    <div class="clear"></div>
						    </ul>
							<script type="text/javascript" src="web/js/responsive-nav.js"></script>
		        </div>	
					  <div class="profile_details">
				    		   <div id="loginContainer">
				                  <a id="loginButton" class=""><span></span><img src="web/images/settings.png" alt="" /></a>
				                    <div id="loginBox">                
				                      <form id="loginForm">
				                        <fieldset id="body">
				                            <div class="user-info">
							        			<ul><center>
							        				<li class="profile active"><a href="index.php?browser_t=web&page_name=index.php">Desktop</a></li><br><br>
							        				<li class="profile"><a href="index.php?browser_t=smartphone&page_name=index.php">Tablet</a></li><br><br>
							        				<li class="profile"><a href="index.php?browser_t=mobile&page_name=index.php">Mobile</a></li><br><br>
													</center>
							        				<div class="clear"></div>		
							        			</ul>
							        		</div>			                            
				                        </fieldset>
				                    </form>
				                </div>
				            </div>
				             <div class="profile_img">	
				             	<a href="#"><img src="web/images/maize32.jpg" alt="" />	</a>				             </div>
				             <div class="clear"></div>		  	
			    </div>	
		 		      <div class="clear"></div>				 
		    </div>
		  </div>	  					     
</div>
	  <div class="main">  
	    <div class="wrap">  		 
	       <div class="column_left">
		   		<div class="tweets" style="margin-top:0px;">
		               <h3>Preprocessing</h3>
						<div class="tweets_list">
				      		<ul>
						  	   <li>
							   		Upload an image of the fruit:<br>
							   		<br>
<!--/*************************NEEDED FOR IMAGE UPLOAD AND PREPROCESSING************************start*/-->
								<center>
								<form id="image_upload" name="image_upload" enctype="multipart/form-data" method="post" action="" target="_self">
									 <input name="file" type="file">
									 <br>
									<input type="submit" class="my_button" value="Upload">
									<input name="beginCycle" type="hidden" id="beginCycle" value="1">
								</form>
								</center>
<!--/*************************NEEDED FOR IMAGE UPLOAD AND PREPROCESSING************************end*/-->
									<span>Max. size: 2MB</span>
						      </li>
							   <li>
							   		Cleaned Image<br>
							   		<img style="
										border: 2px solid;
										border-radius: 25px;
										margin-left: auto;
										margin-right: auto;" 
									src="<?php echo "uploads/images/clean_".$_SESSION["dirtyFileName"]?>">
							   </li>
							   <li>
							   		Dominant Colour in Image<br>
									<span>
										<div id="color-box-actual" style="
											width: 100%;
											border-radius: 25px;
											margin-left: auto;
											margin-right: auto;"
										 >
										 	<br><br><br><br>
								    </div>
										 <br>
										 <div id="textual-output-CD"></div>
									</span>
							   </li>
							   <li>
							   		Desired Colour for Maturity<br>
									<span>
										<div id="colour-box-desired" style="
											width: 100%;
											border-radius: 25px;
											margin-left: auto;
											margin-right: auto;"
										 >
										 	<br><br><br><br>
								    </div>
										 <br>
										 <div id="colour-box-desired-text"></div>
									</span>
							   </li>
							   <li>
							   		Colour Index in Image <br>
							   		<span>
									<div id = "colour-index" align="left"></div>
							   		</span>
							   </li>
							   <li>
									Colour Difference Value <br>
									<span>
										<div id="textual-output-CDI"></div>
									</span>
							   </li>
							   
				    		</ul>
				      </div>
	          </div>
  		  </div> 
	  		
          <div class="column_middle">
		  		<div class="tweets" style="margin-top:0px;">
		               <h3 id="prediction-div">Prediction</h3>
						<div class="tweets_list">
				      		<ul>
								<li>
								Prediction Model<br>
								<a href="common/prediction-model.jpeg" target="_blank"><img src="common/prediction-model.jpeg" alt="" border="0"></a> </li>
						  	   <li>
							   		Time Since Fruit Formation <br>
							   		<span>
									<div id = "prediction-DAA" align="left"></div>
									<div id = "DAA-gauge" align="center"></div>
									</span>
							   </li>
							   <li>
							   		Time Left to Reach Harvesting Stage<br>
							   		<span>
									<div id = "days-left" align="left"></div>
									<div id = "DAA-timeline" style="height:100px; width:180px" align="center"></div>
									</span>
							   </li>
							   
				    		</ul>
				      </div>
	          </div>
		  </div>
            <div class="column_right">
						<div class="tweets" style="margin-top:0px;">
							   <h3 id="prescription-div">Prescription</h3>
								<div class="tweets_list">
									<ul>
									   <li>
											<div id="prescription"></div><br>
									   </li>
									</ul>
							  </div>
					  </div>
		  		<div class="tweets">
		               <h3>Feedback</h3>
						<div class="tweets_list">
				      		<ul>
							  <li>
								Your feedback is highly appreciated.<br><br>Please fill in the following questionnaire to provide feedback.<br>
								<span><u>Feedback Form</u></span>								</li>
				    		</ul>
				      </div>
	          </div>
				   <div class="column_right_grid calender" style="display:none">
                      <div class="cal1"> </div>
				   </div>
          </div>
    	<div class="clear"></div>
 	 </div>
   </div>
    <div class="copy-right">

				<p style="display:none">© 2013 Designed by <a href="http://graphicburger.com/flat-design-ui-components/" target="_blank">GraphicBurger</a>  • Template by <a href="http://w3layouts.com" target="_blank">w3layouts</a> </p>
</div>




<!--/*************************NEEDED FOR COLOUR DIFFERENCE MODULE************************start*/-->
<?php 
if (isset($_SESSION["dirtyFileName"]) && !isset($_POST['beginCycle'])) {
	if (isset($_SESSION["notifier"])) {
?>
		<script>alert("Upload Successful");</script>
		<?php
} else {?>
		<script>alert("Analysing Data");</script>
<?php
}
		unset($_SESSION["notifier"]);
?>



<script src="common/colour-quantization.js"></script>
<script src="common/jquery.min.js"></script>
<script src="common/highcharts.js"></script>
<script src="common/highcharts-more.js"></script>
<script src="common/ciede2000.js"></script>
<script>

		var red;
		var green;
		var blue;
		
		var myImage = document.getElementById('cleanFruitImage');
		
		myImage.src = '<?php echo json_encode("uploads/images/clean_".$_SESSION["dirtyFileName"]);?>';
		myImage.src = myImage.src.replace('%22', '');
		myImage.src = myImage.src.replace('%22', '');
		myImage.src = myImage.src.replace('"', '');
		
		//alert(myImage.src);
		
		
			var colorThief = new ColorThief();
			var start = Date.now();
			ascendantColour = colorThief.getColor(myImage, 9); //10 is lowest quality level
			elapsedTimeForGetColor = Date.now() - start;
			
			//alert("Dominant Colour = rgb(" + ascendantColour[0] + ", " + ascendantColour[1] + ", " + ascendantColour[2] + ")");
			//document.getElementById('textual-output-CD').innerHTML += "Time Taken = " + elapsedTimeForGetColor + "ms <br />";
			document.getElementById('textual-output-CD').innerHTML += "rgb(" + ascendantColour[0] + ", " + ascendantColour[1] + ", " + ascendantColour[2] + ")";
			document.getElementById('color-box-actual').style.backgroundColor = "rgb(" + ascendantColour[0] + ", " + ascendantColour[1] + ", " + ascendantColour[2] + ")";
			document.getElementById('colour-box-desired').style.backgroundColor = "rgb(145,192,57)";
			document.getElementById('colour-box-desired-text').innerHTML += "rgb(145,192,57)<br>Forest-green with a mixture of 45-55% lemon-yellow";
										 
			window.red = ascendantColour[0];
			window.green = ascendantColour[1];
			window.blue = ascendantColour[2];
			plotGauge(red, green, blue);
		
		
		function plotGauge(red, green, blue) {
			fruitRed = red;
			fruitGreen = green;
			fruitBlue = blue;
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		//difference1 = Colordiff.compare({r: 64, g: 160, b: 0}, {r: 191, g: 95, b: 255}, 'rgb');
		//document.write ('The difference is = ' + difference1);
		//document.write ("rgb(" + window.red + ", " + window.green + ", " + window.blue + ")");
		
		//100% - [ (Difference between the new colours and a perfect yellow)/(Difference between a perfect yellow and a perfect blue -> a 100% percent difference because they are opposites) ] * 100
		
		pureDegreeOfPerfection = (Colordiff.compare({r:145, g:192, b:57}, {r: ascendantColour[0], g: ascendantColour[1], b: ascendantColour[2]}, 'rgb'));
		
		degreeOfPerfection = (Colordiff.compare({r:145, g:192, b:57}, 
		//Change this value for each new colour
		{r: ascendantColour[0], g: ascendantColour[1], b: ascendantColour[2]}, 'rgb')) 
		//r:57, g:156, b:0
		/ 
		(Colordiff.compare({r:145, g:192, b:57}, {r: 110, g: 63, b: 198}, 'rgb'))*100;
		
		degreeOfPerfection = 100 - degreeOfPerfection;
		//alert(puredegreeOfPerfection);
		document.getElementById('textual-output-CDI').innerHTML += pureDegreeOfPerfection.toFixed(2) + " units <br />";
		var daysAfterAnthesis = -422.745778695191 + (114.52711914906 * pureDegreeOfPerfection) + (-5.88691315552068 * (pureDegreeOfPerfection*pureDegreeOfPerfection)) + (0.0854111142950544 * (pureDegreeOfPerfection*pureDegreeOfPerfection*pureDegreeOfPerfection));
		//var daysAfterAnthesis = (47.180519644008-(3.1015512369311*pureDegreeOfPerfection)+(0.052190624542893*(pureDegreeOfPerfection*pureDegreeOfPerfection))).toFixed(0);
		
		document.getElementById('prediction-DAA').innerHTML += daysAfterAnthesis.toFixed(0);
		document.getElementById('prediction-DAA').innerHTML += " day(s)";
		document.getElementById('prediction-DAA').innerHTML += " (" + (daysAfterAnthesis/30).toFixed(0) + " month(s))";
		
		/*Computes the colour index based on the derived Days After Anthesis*/
		if (daysAfterAnthesis >= 0 && daysAfterAnthesis <= 30) {
			colourIndex = "G";
			document.getElementById('prescription').innerHTML += "It is not yet ready. Continue cultivating.";
		}
		else if (daysAfterAnthesis >= 31 && daysAfterAnthesis <= 120) {
			colourIndex = "1";
			document.getElementById('prescription').innerHTML += "It is not yet ready. Continue cultivating.";
		}
		else if (daysAfterAnthesis >= 121 && daysAfterAnthesis <= 150) {
			colourIndex = "2";
			document.getElementById('prescription').innerHTML += "It is not yet ready. Continue cultivating.";
		}
		else if (daysAfterAnthesis >= 151 && daysAfterAnthesis <= 160) {
			colourIndex = "3";
			document.getElementById('prescription').innerHTML += "It is ready for harvest.";
		}
		else if (daysAfterAnthesis >= 161 && daysAfterAnthesis <= 180) {
			colourIndex = "4";
			document.getElementById('prescription').innerHTML += "It is ready for harvest.";
		}
		else if (daysAfterAnthesis >= 181 && daysAfterAnthesis <= 200) {
			colourIndex = "5";
			document.getElementById('prescription').innerHTML += "It is too late.";
		}
		else if (daysAfterAnthesis >= 201 /*&& daysAfterAnthesis <= 220*/) {
			colourIndex = "6";
			document.getElementById('prescription').innerHTML += "It is too late.";
		}
		document.getElementById('colour-index').innerHTML += colourIndex;
		
		var daysLeftLower = 136 - daysAfterAnthesis;
		var daysLeftUpper = 171 - daysAfterAnthesis;
		var daysLeft = (daysLeftLower + daysLeftUpper) / 2;
		var gaugeDayseLeft;
		if (daysLeft<0) {
			var absoluteDaysLeft = daysLeft * -1;
			gaugeDayseLeft = 0;
			document.getElementById('days-left').innerHTML += "The harvesting stage passed by<br>";
			document.getElementById('days-left').innerHTML += absoluteDaysLeft.toFixed(0);
			document.getElementById('days-left').innerHTML += " day(s)";
			document.getElementById('days-left').innerHTML += " (" + (absoluteDaysLeft/30).toFixed(0) + " month(s))";
		} else {
			gaugeDayseLeft = daysLeft;
			document.getElementById('days-left').innerHTML += daysLeft.toFixed(0);
			document.getElementById('days-left').innerHTML += " day(s)";
			document.getElementById('days-left').innerHTML += " (" + (daysLeft/30).toFixed(0) + " month(s))";
		}


/****************************START OF GRAPH********************************/
		var normalizedDaysAfterAnthesis = daysAfterAnthesis;
		if (normalizedDaysAfterAnthesis > 220) {
			normalizedDaysAfterAnthesis = 220;
		}
		$(function () {
			$('#DAA-gauge').highcharts({
				chart: {
					type: 'gauge',
					alignTicks: false,
					plotBackgroundColor: '#394264',
					plotBackgroundImage: null,
					plotBorderWidth: 0,
					plotBorderColor: '#394264',
					plotShadow: false
				},
		
				title: {
					text: null
				},
		
				pane: {
					startAngle: -150,
					endAngle: 150
				},
		
				yAxis: [{
					min: 0,
					max: 220,
					lineColor: '#000000',
					tickColor: '#000000',
					minorTickColor: '#000000',
					offset: -25,
					lineWidth: 1,
					labels: {
						distance: -20,
						rotation: 'auto',
						enabled: false
					},
					tickLength: 0,
					minorTickLength: 2,
					endOnTick: false,
					plotBands: [{
							from: 0,
							to: 30,
							color: '#FF0000'
						},  {
							from: 31,
							to: 120,
							color: '#FF0000'
						},  {
							from: 121,
							to: 150,
							color: '#FF0000'
						},  {
							from: 151,
							to: 160,
							color: '#00FF00'
						},  {
							from: 161,
							to: 180,
							color: '#00FF00'
						}, {
							from: 181,
							to: 200,
							color: '#FF0000'
						}, {
							from: 201,
							to: 220,
							color: '#FF0000'
						}]
					}, {
					min: 0,
					max: 220,
					tickPosition: 'inside',
					lineColor: '#FFFF00',
					lineWidth: 4,
					minorTickPosition: 'inside',
					tickColor: '#000000',
					tickLength: 10,
					minorTickLength: 0,
					labels: {
						distance: 12,
						rotation: 'auto'
					},
					offset: -35,
					endOnTick: false
				}],
		
				series: [{
					name: 'Days Since Fruit Formation',
					data: [normalizedDaysAfterAnthesis],
					dataLabels: {
						formatter: function () {
							
							var percentage = parseFloat(Math.round(this.y * 100) / 100).toFixed(0);
							if (percentage >= 0 && percentage <= 30) {
								maturity = "Do Not Harvest";
								return percentage + '<br />' +
									'<span style="color:#DC143C">' + maturity + '</span>';
							} else if (percentage > 30 && percentage <= 120) {
								maturity = "Do Not Harvest";
								return percentage + '<br />' +
									'<span style="color:#DC143C">' + maturity + '</span>';
							} else if (percentage > 120 && percentage <= 150) {
								maturity = "Do Not Harvest";
								return percentage + '<br />' +
									'<span style="color:#DC143C">' + maturity + '</span>';
							} else if (percentage > 150 && percentage <= 160) {
								maturity = "Harvest";
								return percentage + '<br />' +
									'<span style="color:#32CD32">' + maturity + '</span>';
							} else if (percentage > 160 && percentage <= 180) {
								maturity = "Harvest";
								return percentage + '<br />' +
									'<span style="color:#32CD32">' + maturity + '</span>';
							} else if (percentage > 180 && percentage <= 200) {
								maturity = "Do Not Harvest";
								return percentage + '<br />' +
									'<span style="color:#DC143C">' + maturity + '</span>';
							} else if (percentage > 200 && percentage <= 220) {
								maturity = "Do Not Harvest";
								return percentage + '<br />' +
									'<span style="color:#DC143C">' + maturity + '</span>';
							} else {
								maturity = "Not Ready for Harvest";
								return percentage + '<br />' +
									'<span style="color:#DC143C">' + maturity + '</span>';
							}
						},
						backgroundColor: {
							linearGradient: {
								x1: 0,
								y1: 0,
								x2: 0,
								y2: 1
							},
							stops: [
								[0, '#DDD'],
								[1, '#FFF']
							]
						}
					},
					tooltip: {
						valueSuffix: ''
					}
				}]
		
				});
		});
/****************************END OF GRAPH********************************/		

/****************************START OF GRAPH******************************/
$(function() {
    $(document).ready(function() {
        var chart = new Highcharts.Chart({
            chart: {
                renderTo: 'DAA-timeline',
                defaultSeriesType: 'bar',
                plotBorderWidth: 2,
                plotBackgroundColor: '#F5E6E6',
                plotBorderColor: '#D8D8D8',
                plotShadow: true,
                spacingBottom: 20,
                width: 280
            },
            credits: {
                enabled: false
            },
            xAxis: {
                labels: {
                    enabled: false
                },
                tickLength: 0
            },
            title: {
                text: null
            },
            legend: {
                enabled: false
            },
            yAxis: {
                title: {
                    text: null
                },
                labels: {
                    y: 20
                },
                min: 0,
                max: 220,
                tickInterval: 20,
                minorTickInterval: 10,
                tickWidth: 1,
                tickLength: 8,
                minorTickLength: 5,
                minorTickWidth: 1,
                minorGridLineWidth: 0
            },
            plotOptions: {},
            series: [{
					name: 'Time Left to Reach Harvesting Stage',
					data: [gaugeDayseLeft],
                borderColor: '#7070B8',
                borderRadius: 3,
                borderWidth: 1,
                color: {
                    linearGradient: {
                        x1: 0,
                        y1: 0,
                        x2: 1,
                        y2: 0
                    },
				stops: [ //[ 0.35, '#7070B8' ], [0, '#D69999'],
											   [0.3, '#B84D4D'],
											   [0.45, '#7A0000'],
											   [0.55, '#7A0000'],
											   [0.7, '#B84D4D'],
											   [1, '#D69999']]
                },
                pointWidth: 50
			}]
        });
    });

});
		}

</script>
<?php
}
?>
<!--/*************************NEEDED FOR COLOUR DIFFERENCE MODULE************************end*/-->


</body>
</html>
<?php
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