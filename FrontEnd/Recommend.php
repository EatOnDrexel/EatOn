<?php
	//grab input values from the form on EatON2.html
	$Cal_Limit = $_POST['RCal'];
	$Carb_Limit = $_POST['RCarb'];
	$Pro_Limit = $_POST['RPro'];
	$Fat_Limit = $_POST['RFat'];
	
	$Cal_Consumed = $_POST['CCal'];
	$Carb_Consumed = $_POST['CCarb'];
	$Pro_Consumed = $_POST['CPro'];
	$Fat_Consumed = $_POST['CFat'];
	
	//do the calculations for the leftover macros and cals here
	$Cal = $Cal_Limit - $Cal_Consumed;
	$Carb = $Carb_Limit - $Carb_Consumed;
	$Pro = $Pro_Limit - $Pro_Consumed;
	$Fat = $Fat_Limit - $Fat_Consumed;
	
	//check that no calculated value is less than 0, if true, change to 0
	if($Cal < 0)
	{
		$Cal = 0; 
	}
	
	if($Carb < 0)
	{
		$Carb = 0;
	}
	
	if($Pro < 0)
	{
		$Pro = 0;
	}
	
	if($Fat < 0)
	{
		$Fat = 0;
	}
	
	//send to python script and get returned JSON values
	//$output should contain the returned value from the python script
	exec("python newFunctions.py $Pro $Fat $Carb $Cal", $output);
	
	//parse through returned json values
	print($output); //this here for now so that we know it works and return json values
	
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
