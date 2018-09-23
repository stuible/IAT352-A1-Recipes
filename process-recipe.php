<?php 
    //Use functions
	require('recipe-functions.php');
	require('recipe-validator.php');
	//Define seed for generating unique IDs
	define("SEED", 7694201);

	$title = $link = $category = $description = $preptime = $preptimeType = $cooktime = $cooktimeType = $servings = $difficulty = $ingredient1 = $prepInstructions = "";
    if( isset($_GET['rTitle'])) $title=htmlspecialchars(trim($_GET['rTitle'])); 
    if( isset($_GET['rLink'])) $link=htmlspecialchars(trim($_GET['rLink'])); 
    if( isset($_GET['rCategory'])) $category=htmlspecialchars($_GET['rCategory']); 
    if( isset($_GET['rDescription'])) $description=htmlspecialchars(trim($_GET['rDescription'])); 
    if( isset($_GET['rPreptime'])) $preptime=htmlspecialchars(trim($_GET['rPreptime'])); 
    if( isset($_GET['rPreptimeType'])) $preptimeType=htmlspecialchars(trim($_GET['rPreptimeType'])); 
    if( isset($_GET['rCooktime'])) $cooktime=htmlspecialchars(trim($_GET['rCooktime'])); 
    if( isset($_GET['rCooktimeType'])) $cooktimeType=htmlspecialchars(trim($_GET['rCooktimeType'])); 
    if( isset($_GET['rServings'])) $servings=htmlspecialchars(trim($_GET['rServings'])); 
    if( isset($_GET['rDifficulty'])) $difficulty=htmlspecialchars(trim($_GET['rDifficulty'])); 
    if( isset($_GET['rIngredient1'])) $ingredient1=htmlspecialchars(trim($_GET['rIngredient1'])); 
	if( isset($_GET['rPrepInstructions'])) $prepInstructions=htmlspecialchars(trim($_GET['rPrepInstructions'])); 
	if( isset($_GET['rTags'])) $tags=htmlspecialchars(trim($_GET['rTags'])); 

	$ingredients = checkIngredients("rIngredient");
	
	$prevQuery = http_build_query($_GET);

	validate($title, "", "Title");
	validate($link, "URL", "Link");
	validate($category, "Category", "Category");
	validate($preptime, "", "Preptime");
	validate($preptimeType, "Timetype", "PreptimeType");
	validate($cooktime, "", "Cooktime");
	validate($cooktimeType, "Timetype", "CooktimeType"); 
	validate($servings, "", "Servings");
	validate($difficulty, "", "Difficulty");
	validate($ingredient1, "Ingredient1", "Ingredient1");
	validate($prepInstructions, "", "PrepInstructions");
	validate($description, "", "Description");
	//validate($tags, "", "Tag");
	

	if (!formValid()) {

		$validationMessagesQuery = http_build_query($GLOBALS['validationMessages']);
		
		header('Location: add-recipe.php'."?".$prevQuery."&".$validationMessagesQuery);
		exit;
	}
	
	//Insert Header
    require('header.php');

	$document_root = $_SERVER['DOCUMENT_ROOT'];
	$filepath = join(DIRECTORY_SEPARATOR, array($document_root, "IAT352", "A1", "recipes", "recipes.txt"));

	$linecount = 0;
	$handle = fopen($filepath, "r");
	while(!feof($handle)){
		$line = fgets($handle);
		$linecount++;
	}

	fclose($handle);

	switch($difficulty){
		case "e":
			$difficulty = "Easy";
			break;
		case "i":
			$difficulty = "Intermediate";
			break;
		case "d":
			$difficulty = "Difficult";
			break;
	}

	switch($preptimeType){
		case "h":
			$preptimeType = "hours";
			break;
		case "m":
			$preptimeType = "minutes";
			break;
	}

	switch($cooktimeType){
		case "h":
			$cooktimeType = "hours";
			break;
		case "m":
			$cooktimeType = "minutes";
			break;
	}

	$tagArray = explode(',', $tags);
	$tagArray = array_map('trim', $tagArray);

	$description = str_replace( "\n", '<br>', $description);
	$prepInstructions = str_replace( "\n", '<br>', $prepInstructions);

	$UID = $linecount * SEED;

		$fp = @fopen($filepath,'a');
		if(!$fp) {
			echo "<br><strong>Error Writing File.</strong>";
			exit;
		}
		$out = 	$UID.","
				.$title.","
				.$link.","
				.$category.","
				.$description.","
				.$preptime.","
				.$preptimeType.","
				.$cooktime.","
				.$cooktimeType.","
				.$servings.","
				.$difficulty.","
				.$prepInstructions.","
				.implode($ingredients[0], ", ").","
				.implode($ingredients[1], ", ").","
				.implode($ingredients[2], ", ").","
				.implode($tagArray, ", ").
				"\n";
		fwrite($fp,$out);
		fclose($fp);

	$recipeURL = "details.php" . '?id=' . $UID;
	echo "<div class=\"successMessage\">Sucess: Your recipe can be found <a href=\"./$recipeURL\">here</a></div>";

	//Insert Footer
    require('footer.php');
	
?>
