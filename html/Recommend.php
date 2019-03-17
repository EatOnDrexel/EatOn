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
	$desiredinfo = array('label', 'image', 'shareAs');
	$recipesData = json_decode($returned, true);

	define("TAB", "    ");
	define("NL", "\r\n");

	echo "<html>";
	echo "<head>";
	echo "</head>";
	echo "<body>";
	echo "<pre>";

/*
	function printinfo($info)
	{
		global $desiredinfo;

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
				if (in_array($i, $desiredinfo))
				{
					echo $i . ': ' . $values . '<br>';
				}
				//echo $i . ':' . $values . '<br>';
			}

		}
	}
	
	function checkifempty($info)
	{
		$filteredhits = array_filter($info);
		//checks to see if there are no results
		if (empty($filteredhits))
		{
			echo "No results";
		}
		//if there are results, call the printinfo function
		else
		{
			//calls above function to print out data
			printinfo($info);
		}
	}
	
	checkifempty($recipesData['hits']);
	//echo json_encode((json_decode($returned)), JSON_PRETTY_PRINT);

*/


	$hits = $recipesData['hits'];
 
	foreach ($hits as $hit)
	{
    	$recipe = $hit['recipe'];
 
    	echo "\r\nRecipe: {$recipe['label']}";
    	echo "\r\nRecipe: {$recipe['image']}";
    	echo "\r\nRecipe: {$recipe['shareAs']}";
 
    	echo NL . TAB . "Nutrients:";
    	foreach ($recipe['totalNutrients'] as $nutrient)
    	{
    		if ($nutrient['label'] === "Fat" || $nutrient['label'] === "Carbs" || $nutrient['label'] === "Protein")
    		{
    			echo NL . TAB . TAB . $nutrient['label'] . " " . $nutrient['unit'] . ":" . $nutrient['quantity'];
    		}
    	}
    	echo NL . NL;
	}

	echo "</pre>";

	echo "<br>";
	echo "</body>";
	echo "</html>";

?>
