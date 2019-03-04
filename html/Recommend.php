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
	exec("sudo python3 /var/www/eaton/BackEnd/GenerateCall.py $Pro_Limit $Fat_Limit $Carb_Limit $Cal_Limit $Pro_Consumed $Fat_Consumed $Carb_Consumed $Search_Term", $output);
	echo "sudo python3 /var/www/eaton/BackEnd/GenerateCall.py $Pro_Limit $Fat_Limit $Carb_Limit $Cal_Limit $Pro_Consumed $Fat_Consumed $Carb_Consumed $Search_Term";
	echo "<br>";

	//parse returned json values
	//var_dump($output);
	//var_dump($return);
	//print_r($output."<br>"); //this here for now so that we know it works and return json values
        var_dump($output);
	
	//print out in html format
	//to be determined: what to display per recipe
	print('
	<html>
		<head>
		</head>
		<body>
		</body>
	</html>
	');
?>
