<?php
global $validationErrorArray;

function startForm($pageName, $array){
    echo "<form action=\"$pageName\" method=\"get\">";
    $GLOBALS['validationErrorArray'] = $array;
}
function endForm(){
    echo "<div class=\"row\">";
    echo "<input type=\"submit\" name=\"submit\" class=\"button-primary\" value=\"Submit\" />";
    echo "<div class=\"row\">";
    echo "</form>";
}

function validated($name){
    $validationName = "val" . substr( $name, 1 );
    if(!array_key_exists($validationName, $GLOBALS['validationErrorArray'])){
        return true;
    }
    else {
        return false;
    }
}

function addFormElement($element, $name, $label, $value){
    $addclass = "";
    switch($element){
        case "text":
            if (!validated($name)) $addclass = "class= \"validationError\"";
            if(!empty($label)) echo "<label $addclass>$label</label>";
            echo "<input type=\"text\" name=\"$name\" value=\"$value\">";
            break;
        case "tags":
            if (!validated($name)) $addclass = "class= \"validationError\"";
            if(!empty($label)) echo "<label $addclass>$label</label>";
            echo "<input type=\"text\" name=\"$name\" value=\"$value\">";
            break;
        case "submit":
            echo "<input type=\"submit\" name=\"submit\" class=\"button-primary\" value=\"Submit\" />";
            break;
        case "multitext":
            if (!validated($name)) $addclass = "class= \"validationError\"";
            if(!empty($label)) echo "<label $addclass>$label</label>";
            echo "<textarea type=\"text\" name=\"$name\" cols=\"40\" rows=\"5\">$value</textarea>";
            break;
        case "dropdown":
            $firstElement = true;
            $nameFromArray = array_values($name)[0];
            if (!validated($nameFromArray)) $addclass = "class= \"validationError\"";
            if(!empty($label)) echo "<label $addclass>$label</label>";
            echo "<select name=\"$nameFromArray\">";
            foreach ($name as $arrayLabel => $arrayValue) {
                if($value == $arrayValue){
                    $selectedValue = "selected=\"selected\"";
                }
                else {
                    $selectedValue = "";
                }
                if($firstElement){
                    $firstElement = false;
                }
                else {
                    echo "<option value=\"$arrayValue\" $selectedValue>$arrayLabel</option>";
                }
            }
            echo "</select>";
            break;
        case "radio":
            $firstElement = true;
            $nameFromArray = array_values($name)[0];
            if (!validated($nameFromArray)) $addclass = "class= \"validationError\"";
            if(!empty($label)) echo "<label $addclass>$label</label>";
            echo "<div class=\"row\">";
            foreach ($name as $arrayLabel => $arrayValue) {
                if($value == $arrayValue){
                    $checkedValue = " checked=\"checked\"";
                }
                else {
                    $checkedValue = "";
                }
                if($firstElement){
                    $firstElement = false;
                }
                else {
                    echo "<input type=\"radio\" name=\"$nameFromArray\" value=\"$arrayValue\"$checkedValue class=\"servingRadio\"><div class=\"servingRadioLabel\">$arrayLabel</div>";
                    
                }
            }
            echo "</div>";
            break;
        case "ingredients":
            $ingredientArray = array_values($value)[0];
            $quantityArray = array_values($value)[1];
            $unitArray = array_values($value)[2];
            if (!validated("rIngredient1")) $addclass = "class= \"validationError\"";
            echo "<label $addclass>$label</label>";
            for ($i = 1; $i <= 10; $i++) {
                $ingredient = array_values($ingredientArray)[$i - 1];
                $quantity = array_values($quantityArray)[$i - 1];
                $unit = array_values($unitArray)[$i- 1];
                echo "<input type=\"text\" name=\"$name" . $i . "\" value=\"$ingredient\">";
                echo "<input type=\"number\" name=\"rQuantity" . $i . "\" value=\"$quantity\">";
                addFormElement("dropdown", array(
                    'rUnit'. $i, 
                    'pound(s)' => 'pound', 
                    'gram(s)' => 'gram',
                    'ounce(s)' => 'ounce',
                    'piece(s)' => 'pcs',
                    'ml' => 'ml',
                    'tablespoon(s)' => 'tbl',
                    'teaspoon(s)' => 'tsp',
                    'cup(s)' => 'cup',
                ), "", $unit);
            }
            break;
    }
}

function checkIngredients($name){
            $a = array();
            $b = array();
            $c = array();
            for ($i = 1; $i <= 10; $i++) {
                $multipleUnits = false;
                if(isset($_GET[$name . $i])){
                    array_push($a, htmlspecialchars(trim($_GET[$name . $i])));
                }
                else {
                    array_push($a, "");
                }
                if(isset($_GET[$name . $i])){
                    $quantityGET = htmlspecialchars(trim($_GET["rQuantity" . $i]));
                    array_push($b, $quantityGET);
                    if($quantityGET > 1) $multipleUnits = true;
                }
                else {
                    array_push($b, "");
                }
                if(isset($_GET[$name . $i])){
                    $unit = htmlspecialchars(trim($_GET["rUnit" . $i]));
                    switch($unit){
                        case "pound":
                            if($multipleUnits) $unit = "pounds";
                            else $unit = "pound";
                            break;
                        case "gram":
                            if($multipleUnits) $unit = "grams";
                            else $unit = "gram";
                            break;
                        case "ounce":
                            if($multipleUnits) $unit = "ounces";
                            else $unit = "ounce";
                            break;
                        case "pcs":
                            if($multipleUnits) $unit = "pieces";
                            else $unit = "piece";
                            break;
                        case "ml":
                            if($multipleUnits) $unit = "ml";
                            else $unit = "ml";
                            break;
                        case "tbl":
                            if($multipleUnits) $unit = "tablespoons";
                            else $unit = "tablespoon";
                            break;
                        case "tsp":
                            if($multipleUnits) $unit = "teaspoons";
                            else $unit = "teaspoon";
                            break;
                        case "cup":
                            if($multipleUnits) $unit = "cup";
                            else $unit = "cups";
                            break;
                    }
                    array_push($c, $unit);
                }
                else {
                    array_push($c, "");
                }
                
            }
            return array($a, $b, $c);
}

?>