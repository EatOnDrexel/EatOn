<?php

	//grab input values from the form on EatON2.html
	$Cal_Limit = $_POST['RCal'];
	$Carb_Limit = $_POST['RCarb'];
	$Pro_Limit = $_POST['RPro'];
	$Fat_Limit = $_POST['RFat'];

	$Carb_Consumed = $_POST['CCarb'];
	$Pro_Consumed = $_POST['CPro'];
	$Fat_Consumed = $_POST['CFat'];

	$Search_Term = $_POST['Term'];

	//send to python script and get returned JSON values
	//$output should contain the returned value from the python script
	//exec("python newFunctions.py $Pro $Fat $Carb $Cal", $output); //this is the old one
	//exec("sudo python3 /var/www/eaton/BackEnd/GenerateCall.py $Pro_Limit $Fat_Limit $Carb_Limit $Cal_Limit $Pro_Consumed $Fat_Consumed $Carb_Consumed $Search_Term", $output);
	$returned = shell_exec("python3 /var/www/eaton/BackEnd/GenerateCall.py $Pro_Limit $Fat_Limit $Carb_Limit $Cal_Limit $Pro_Consumed $Fat_Consumed $Carb_Consumed $Search_Term");
	$recipe = explode(',', $returned);

	echo "<html>";
	echo "<head>";
	echo "</head>";
	echo "<body>";
	echo "<pre>";
	/*echo "<script type=\"text/javascript\">
		JSON.stringify($return);
	</script>";
	 */
	//echo shell_exec("python3 /var/www/eaton/BackEnd/GenerateCall.py $Pro_Limit $Fat_Limit $Carb_Limit $Cal_Limit $Pro_Consumed $Fat_Consumed $Carb_Consumed $Search_Term");
	echo $returned."<br>";
	echo json_encode((json_decode($returned)), JSON_PRETTY_PRINT);
	echo "</pre>";

	echo "<br>";
	echo "</body>";
	echo "</html>";

	//parse returned json values
	//var_dump($output);
	//var_dump($return);
	//print_r($output."<br>"); //this here for now so that we know it works and return json values


	//print out in html format
	//to be determined: what to display per recipe
	/*print('
	<html>
		<head>
		</head>
		<body>
		</body>
	</html>
	');*/
?>
