<?php
    //Insert Header
    require('header.php');
?>

    <div class="row">
        <div class="two columns">
            <a class="button" href="add-recipe.php">Add Recipe</a>
        </div>
    </div>

    <table class="u-full-width recipeList">
    <thead>
      <tr>
        <th>Recipe</th>
        <th>Prep Time</th>
        <th>Cook Time</th>
        <th>Level</th>
      </tr>
    </thead>
    <tbody>


<?php

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


while ($entry = fgetcsv($fp)) {
    $recipeURL = "details.php" . '?id=' . $entry[0];
    echo "<tr>";
    echo "<td><a href=\"./$recipeURL\">". $entry[1] ."</a></td>";
    echo "<td>" . $entry[5] . " " . $entry[6] ."</td>";
    echo "<td>" . $entry[7] . " " . $entry[8] ."</td>";
    echo "<td>" . $entry[10] . "</td>";
    echo "</tr>";
}

?>
    </tbody>
  </table>

<?php
    //Insert Footer
    require('footer.php');
?>

