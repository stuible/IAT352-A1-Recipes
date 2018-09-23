<?php
    //Insert Header
    require('header.php');

    if( isset($_GET['id'])) $id=trim($_GET['id']);
    else $id="";

    $document_root = $_SERVER['DOCUMENT_ROOT'];
    $filepath = join(DIRECTORY_SEPARATOR, array($document_root, "IAT352", "A1", "recipes", "recipes.txt"));

    if (!file_exists($filepath)) {
        require('header.php');
        echo "<strong>Recipe File Not Found.</strong>";
        require('footer.php');
        exit;
    }
    $fp = @fopen($filepath,"r");
    if(!$fp) {
        require('header.php');
        echo "<strong>Unable to load Recipes. Please try again later.</strong>";
        require('footer.php');
        exit;
    }

    $foundRecipe = false;
    while ($entry = fgetcsv($fp)) {
        if($entry[0] == $id){
            $foundRecipe = true;
            echo "<div class=\"row\">";
            
            echo "<h1>" . $entry[1] . "<h1>";
            echo "<h6><a href=\"./". $entry[2] ."\">". $entry[2] ."</a><h6>";

            echo "</div>";
            echo "<div class=\"row\">";
            echo "<div class=\"six columns\">";

            echo "<h6 class=\"detailName\">Category</h6>";
            echo "<h6 class=\"detailEntry\">" . $entry[3] . "</h6>";
            echo "<h6 class=\"detailName\">Description</h6>";
            echo "<h6 class=\"detailEntry\">" . $entry[4] . "</h6>";
            echo "<h6 class=\"detailName\">Preptime</h6>";
            echo "<h6 class=\"detailEntry\">" . $entry[5] . " " . $entry[6] . "</h6>";
            echo "<h6 class=\"detailName\">Cooktime</h6>";
            echo "<h6 class=\"detailEntry\">" . $entry[7] . " " . $entry[8] . "</h6>";
            
            echo "</div>";
            echo "<div class=\"six columns\">";

            echo "<h6 class=\"detailName\">Servings</h6>";
            echo "<h6 class=\"detailEntry\">" . $entry[9] . "</h6>";
            echo "<h6 class=\"detailName\">Difficulty</h6>";
            echo "<h6 class=\"detailEntry\">" . $entry[10] . "</h6>";
            echo "<h6 class=\"detailName\">Instructions</h6>";
            echo "<h6 class=\"detailEntry\">" . $entry[11] . "</h6>";
            echo "<h6 class=\"detailName\">Tags</h6>";
            echo "<h6 class=\"detailEntry\">";
            for ($i=42; $i < count($entry) - 1; $i++) {
                echo $entry[$i] . ", ";
            }
            echo $entry[count($entry) - 1];
            echo "</h6>";
            echo "</div>";
            echo "</div>";
        }
    }

    if(!$foundRecipe) {
        echo "<strong>Unable to find Recipe. Probaly doesn't exist....</strong>";
        exit;
    }

    $document_root = $_SERVER['DOCUMENT_ROOT'];
    $filepath = join(DIRECTORY_SEPARATOR, array($document_root, "IAT352", "A1", "recipes", "recipes.txt"));

    if (!file_exists($filepath)) {
        echo "<strong>Recipe File Not Found.</strong>";
        exit;
    }
    $fp = @fopen($filepath,"r");
    if(!$fp) {
        echo "<strong>Unable to load Recipes. Please try again later.</strong>";
        exit;
    }

?>

<table class="u-full-width recipeList">
    <thead>
      <tr>
        <th>Ingredient</th>
        <th>Amount</th>
        <th>Unit</th>
      </tr>
    </thead>
    <tbody>


<?php

$document_root = $_SERVER['DOCUMENT_ROOT'];
$filepath = join(DIRECTORY_SEPARATOR, array($document_root, "IAT352", "A1", "recipes", "recipes.txt"));

if (!file_exists($filepath)) {
	echo "<strong>Recipe File Not Found.</strong>";
	exit;
}
$fp = @fopen($filepath,"r");
if(!$fp) {
	echo "<strong>Unable to load Recipes. Please try again later.</strong>";
	exit;
}


while ($entry = fgetcsv($fp)) {
    if($entry[0] == $id){
        for ($i=12; $i < 22; $i++) {
            if(!empty(trim($entry[$i]))){
                echo "<tr>";
                echo "<td>" . $entry[$i] . "</td>";
                echo "<td>" . $entry[$i + 10] . "</td>";
                echo "<td>" . $entry[$i + 20] . "</td>";
                echo "</tr>";
            }
        }
    }
}

?>
    </tbody>
  </table>


<?php
    //Insert Footer
    require('footer.php');
?>