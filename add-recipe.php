<?php 
    //Use functions
    require('recipe-functions.php');

    $title = $link = $category = $description = $preptime = $preptimeType = $tags = $cooktime = $cooktimeType = $servings = $difficulty = $ingredient1 = $prepInstructions = "";
    if( isset($_GET['rTitle'])) $title=trim($_GET['rTitle']); 
    if( isset($_GET['rLink'])) $link=trim($_GET['rLink']); 
    if( isset($_GET['rCategory'])) $category=$_GET['rCategory']; 
    if( isset($_GET['rDescription'])) trim($description=$_GET['rDescription']); 
    if( isset($_GET['rPreptime'])) trim($preptime=$_GET['rPreptime']); 
    if( isset($_GET['rPreptimeType'])) trim($preptimeType=$_GET['rPreptimeType']); 
    if( isset($_GET['rCooktime'])) trim($cooktime=$_GET['rCooktime']); 
    if( isset($_GET['rCooktimeType'])) trim($cooktimeType=$_GET['rCooktimeType']); 
    if( isset($_GET['rServings'])) trim($servings=$_GET['rServings']); 
    if( isset($_GET['rDifficulty'])) trim($difficulty=$_GET['rDifficulty']); 
    if( isset($_GET['rIngredient1'])) trim($ingredient1=$_GET['rIngredient1']); 
    if( isset($_GET['rPrepInstructions'])) trim($prepInstructions=$_GET['rPrepInstructions']); 
    if( isset($_GET['rTags'])) trim($tags=$_GET['rTags']); 

    $ingredients = checkIngredients("rIngredient");

?>
<?php 

    //Insert Header
    require('header.php');

    echo "<div class=\"row errorContainer\">";
    echo "<div class=\"twelve columns\">";

    //Validation Errors
    $validationErrors = array();
    foreach ($_GET as $key => $value){
        if(substr($key, 0, 3 ) == "val"){
            $validationErrors[$key] = $value;
            echo $value . "<br>";
        }
    }

    echo "</div>";
    echo "</div>";

    echo "<div class=\"row mainRecipeAddContainer\">";
    echo "<div class=\"six columns\">";

    //Add Form
    startForm("process-recipe.php", $validationErrors);
    addFormElement("text", "rTitle", "Recipe Title*", $title);
    addFormElement("text", "rLink", "Related Link", $link);
    addFormElement("dropdown", array(
        'rCategory', 
        'Appetizers' => 'app', 
        'Breakfast' => 'break',
        'Deserts' => 'des',
        'Drinks' => 'drinks',
        'Main Courses' => 'main'
    ), "Category", $category);
    addFormElement("multitext", "rDescription", "Short Description*", $description);
    addFormElement("text", "rPreptime", "Prep Time*", $preptime);
    addFormElement("dropdown", array(
        'rPreptimeType', 
        'Minutes' => 'm', 
        'Hours' => 'h'
    ), "", $preptimeType);
    addFormElement("text", "rCooktime", "Cook Time*", $cooktime);
    addFormElement("dropdown", array(
        'rCooktimeType', 
        'Minutes' => 'm', 
        'Hours' => 'h'
    ), "", $cooktimeType);
    addFormElement("radio", array(
        'rServings', 
        '1' => '1', 
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6+' => '6'
    ), "Servings*", $servings);
    addFormElement("dropdown", array(
        'rDifficulty', 
        'Easy' => 'e', 
        'Intermediate' => 'i',
        'Difficult' => 'd'
    ), "Difficultly", $difficulty);


    echo "</div>";
    echo "<div class=\"six columns\">";

    addFormElement("ingredients", "rIngredient", "Ingredients*", $ingredients);
    addFormElement("multitext", "rPrepInstructions", "Preparation Instructions*", $prepInstructions);
    addFormElement("tags", "rTags", "Tags", $tags);
    endForm();
    echo "</div>";
    echo "</div>";

    //Insert Footer
    require('footer.php');
?>