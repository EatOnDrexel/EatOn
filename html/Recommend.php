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
	$Carb_Remaining_Grams = ((($Cal_Limit * ($Carb_Limit / 100)) / 4) - $Carb_Consumed);
	$Pro_Remaining_Grams = ((($Cal_Limit * ($Pro_Limit/ 100)) / 4) - $Pro_Consumed);
	$Fat_Remaining_Grams = ((($Cal_Limit * ($Fat_Limit / 100)) / 9) - $Fat_Consumed);

	//send to python script and get returned JSON values
	$returned = exec("python3 /var/www/eaton/BackEnd/GenerateCall.py $Pro_Limit $Fat_Limit $Carb_Limit $Cal_Limit $Pro_Consumed $Fat_Consumed $Carb_Consumed $Search_Term");

	//converts output into a php array
	$recipesData = json_decode($returned, true);
	$hits = $recipesData['hits'];

	define("TAB", "    ");
	define("NL", "\r\n");

	echo "<html>";
	echo "<head>";
	echo "<style>";
	echo "table {";
  		echo "font-family: Georgia, serif;";
  		echo "border-collapse: collapse;";
  		echo "width: 60%;";
  		echo "margin: 0 auto;";
		echo "}";

	echo "td, th {";
  		echo "border: 1px solid #dddddd;";
  		echo "text-align: left;";
  		echo "padding: 8px;";
		echo "}";

	echo "tr:nth-child(even) {";
  		echo "background-color: #dddddd;";
		echo "}";

	echo "td[colspan=\"3\"] {";
    	echo "text-align: center;";
    	echo "background-color: #fff;";
		echo "}";

	echo "</style>";
	echo "</head>";
	echo "<body>";
	echo "<img src="hml/eatONbanner.png">";
	function generatevars()
	{
		global $recipesData;
		global $hits;
		global $Cal_Limit;
		global $Carb_Remaining_Grams;
		global $Pro_Remaining_Grams;
		global $Fat_Remaining_Grams;
 
		foreach ($hits as $hit)
		{
			$recipe = $hit['recipe'];
			
			foreach ($recipe['totalNutrients'] as $nutrient)
			{
				if ($nutrient['label'] === "Fat")
				{
					$Fat_In_Recipe = round(floatval($nutrient['quantity'])/intval($recipe['yield']), 2);
					$Fat_Leftover = round(($Fat_Remaining_Grams - $Fat_In_Recipe), 2);
				}
				elseif ($nutrient['label'] === "Carbs")
				{
					$Carb_In_Recipe = round(floatval($nutrient['quantity'])/intval($recipe['yield']), 2);
					$Carb_Leftover = round(($Carb_Remaining_Grams - $Carb_In_Recipe), 2);
				}
				elseif ($nutrient['label'] === "Protein")
				{
					$Pro_In_Recipe = round(floatval($nutrient['quantity'])/intval($recipe['yield']), 2);
					$Pro_Leftover = round(($Pro_Remaining_Grams - $Pro_In_Recipe), 2);
				}
			}
				$Calories_In_Recipe = round(floatval($recipe['calories'])/intval($recipe['yield']),2);
				

			#Prints for recipes go here
			echo "<table>";
			echo "<tr>";
				echo "<td colspan=\"3\" swf_fontsize(30px)><b>" . "Recipe: " . "</b><a href='" . $recipe['url'] . "'>" . $recipe['label'] . "</a></b></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td colspan=\"3\"><a href='" . $recipe['url'] . "'><img src='" . $recipe['image'] . "' alt='Recipe_Img'></a><br></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td colspan=\"3\"><b>" . "Makes " . $recipe['yield'] . " serving(s)" . "</b></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td colspan=\"3\"><b>" . "Calories: " . $Calories_In_Recipe . "</b></td>";
			echo "</tr>";
  			echo "<tr>";
    			echo "<th></th>";
    			echo "<th>In Recipe</th>";
    			echo "<th>Remaining</th>";
  			echo "</tr>";
  			echo "<tr>";
    			echo "<td><b>Fat</b></td>";
    			echo "<td>" . $Fat_In_Recipe . "g</td>"; 
    			echo "<td>" . $Fat_Leftover . "g</td>";
  			echo "</tr>";
  			echo "<tr>";
    			echo "<td><b>Carbs</b></td>";
    			echo "<td>" . $Carb_In_Recipe . "g</td>";
    			echo "<td>" . $Carb_Leftover . "g</td>";
  			echo "</tr>";
  			echo "<tr>";
    			echo "<td><b>Protein</b></td>";
    			echo "<td>" . $Pro_In_Recipe . "g</td>";
    			echo "<td>" . $Pro_Leftover . "g</td>";
  			echo "</tr>";
			echo "</table>";

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
			generatevars();
		}
	}

	checkifempty();

	echo "<br>";
	echo "</body>";
	echo "</html>";

?>
