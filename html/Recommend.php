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

	//Find out how many grams of each macro user needs. This is done in Python but needs done again here (for now)
	$Carb_MaxGrams = (($Cal_Limit * ($Carb_Limit / 100)) / 4);
	$Pro_MaxGrams = (($Cal_Limit * ($Pro_Limit/ 100)) / 4);
	$Fat_MaxGrams = (($Cal_Limit * ($Fat_Limit / 100)) / 9);

	$Carb_Remaining_Grams = ($Carb_MaxGrams - $Carb_Consumed);
	$Pro_Remaining_Grams = ($Pro_MaxGrams - $Pro_Consumed);
	$Fat_Remaining_Grams = ($Fat_MaxGrams - $Fat_Consumed);

	//send to python script and get returned JSON values
	$returned = exec("python3 /var/www/eaton/BackEnd/GenerateCall.py $Pro_Limit $Fat_Limit $Carb_Limit $Cal_Limit $Pro_Consumed $Fat_Consumed $Carb_Consumed $Search_Term");

	//converts output into a php array
	$recipesData = json_decode($returned, true);
	$hits = $recipesData['hits'];

	define("TAB", "    ");
	define("NL", "\r\n");

	echo "<html>";
	echo "<head>";
	echo "</head>";
	echo "<body>";
	//echo "<pre>";

	function printinfo()
	{
		global $recipesData;
		global $hits;

		global $Cal_Limit;
		global $Carb_MaxGrams;
		global $Pro_MaxGrams;
		global $Fat_MaxGrams;
 
		foreach ($hits as $hit)
		{
			$recipe = $hit['recipe'];
		
			echo "<b>Recipe: </b><a href='".$recipe['url']."'>".$recipe['label']."</a><br>";
			//echo '<b>Recipe: </b><a href="'.$recipe['label'].'">'.$recipe['label'].'</a>';
			echo "<a href='".$recipe['url']."'><img src='".$recipe['image']."' alt='Recipe_Img'></a><br>";
			//echo "<b>Link: </b>{$recipe['url']}<br>";
			echo "&emsp;<b>Servings: </b>{$recipe['yield']}<br>";
			echo "&emsp;<b>Total Nutrients: </b><br>";
			foreach ($recipe['totalNutrients'] as $nutrient)
			{
				if ($nutrient['label'] === "Fat" || $nutrient['label'] === "Carbs" || $nutrient['label'] === "Protein")
				{
					echo "&emsp;&emsp;" . $nutrient['label'] . ": " . round(floatval($nutrient['quantity']),2) . $nutrient['unit'] . "<br>";
				}
			}
			echo "&emsp;&emsp;Calories: " . round(floatval($recipe['calories']),2) . "kcal<br>";
			echo "&emsp;<b>Nutrients per serving: </b><br>";
			foreach ($recipe['totalNutrients'] as $nutrient)
			{
				if ($nutrient['label'] === "Fat" || $nutrient['label'] === "Carbs" || $nutrient['label'] === "Protein")
				{
					if ($recipe['yield'] > 1)
					{
						$div = floatval($nutrient['quantity'])/intval($recipe['yield']);
					}
					else
					{
						$div = floatval($nutrient['quantity']);
					}
					
					echo "&emsp;&emsp;" . $nutrient['label'] . ": " . round($div,2) . $nutrient['unit'] . "<br>";


					if ($nutrient['label'] === "Fat")
					{
						echo "&emsp;&emsp;" . "Fat Remaining: " . ($Fat_Remaining_Grams - $div) . $nutrient['unit'] . "<br>";
					}
					elseif ($nutrient['label'] === "Carbs")
					{
						echo "&emsp;&emsp;" . "Carbs Remaining: " . ($Carb_Remaining_Grams - $div) . $nutrient['unit'] . "<br>";
					}
					elseif ($nutrient['label'] === "Protein")
					{
						echo "&emsp;&emsp;" . "Protein Remaining: " . ($Pro_Remaining_Grams - $div) . $nutrient['unit'] . "<br>";
					}


				}
			}
			if ($recipe['yield'] > 1)
			{
				echo "&emsp;&emsp;Calories: " . round(floatval($recipe['calories'])/intval($recipe['yield']),2) . "kcal<br>";
			}
			else
			{
				echo "&emsp;&emsp;Calories: " . round(floatval($recipe['calories']),2) . "kcal<br>";
			}
			//echo NL . NL;
			echo "<br><br>";
		}
	}


	function checkifempty()
	{
		global $hits;

		$filteredhits = array_filter($hits);
		//checks to see if there are no results
		if (empty($filteredhits))
		{
			echo "No results";
		}
		//if there are results, call the printinfo function
		else
		{
			//calls above function to print out data
			printinfo();
		}
	}

	checkifempty();

	//echo "</pre>";

	echo "<br>";
	echo "</body>";
	echo "</html>";

?>
