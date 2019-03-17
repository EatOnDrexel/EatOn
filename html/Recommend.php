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
	$returned = exec("python3 /var/www/eaton/BackEnd/GenerateCall.py $Pro_Limit $Fat_Limit $Carb_Limit $Cal_Limit $Pro_Consumed $Fat_Consumed $Carb_Consumed $Search_Term");

	//converts output into a php array
	$recipes = json_decode($returned, TRUE);

	echo "<html>";
	echo "<head>";
	echo "</head>";
	echo "<body>";
	echo "<pre>";

	/*
	//loops over the layer containing hits. Seems redundant but it works.
	foreach ($recipes['hits'] as $i => $values)
	{
	//loops over the layer containing recipes.
	foreach ($values as $key => $value)
		{
		//loops over the layer containing url, label, etc.
		foreach ($value as $tags => $taginfo)
			{
			//echoes out tags on this layer
			echo $tags . ':' . $taginfo . '<br>';
			foreach ($taginfo as $nestkey => $nestvalue)
				{
				echo $nestkey . ':' . $nestvalue . '<br>';
				}
			}
		echo $key . ':' . $value . '<br>';
		}
	}
	*/

	function printinfo($info)
	{
		if (count($recipes['hits']))
		{
			echo "No results";
		}
		else
		{
			foreach ($info as $i => $values)
			{
			//if the value in the array is another array, recurse
			if (is_array($values))
				{
				printinfo($values);
				}
			//if the value is not an array, print out the key value pair
			else
				{
				echo $i . ':' . $values . '<br>';
				}

			}
		}
		
	}
	
	//calls above function to print out data
	printinfo($recipes['hits']);
	//echo json_encode((json_decode($returned)), JSON_PRETTY_PRINT);

	echo "</pre>";

	echo "<br>";
	echo "</body>";
	echo "</html>";

?>
