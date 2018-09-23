<?php 
global $validForm;
global $validationMessages;
$GLOBALS['validForm'] = true;

function validate($input, $inputType, $name){
    switch($inputType){
        case "URL":
            if (filter_var($input, FILTER_VALIDATE_URL) || empty($input)) {
                return true;
            } else {
                $GLOBALS['validationMessages']["val" . $name] = "$name is not a valid URL";
                validate($input, "", $name);
                $GLOBALS['validForm'] = false;
                return false;
            }
            break;
        case "Category":
            if ($input == 'app' || $input == 'break' || $input == 'des' || $input == 'drinks' || $input == 'main') {
                return true;
            } else {
                $GLOBALS['validationMessages']["val" . $name] = "Please enter a valid $name";
                validate($input, "", $name);
                $GLOBALS['validForm'] = false;
                return false;
            }
            break;
        case "Timetype":
            if ($input == 'm' || $input == 'h') {
                return true;
            } else {
                $GLOBALS['validationMessages']["val" . $name] = "Please pick a valid time incrementation";
                validate($input, "", $name);
                $GLOBALS['validForm'] = false;
                return false;
            }
            break;
        case "Ingredient1":
            if (!empty($input)){
                return true;
            }
            else {
                $GLOBALS['validationMessages']["val" . $name] = "Please enter at least one ingredient";
                $GLOBALS['validForm'] = false;
                return false;
            }
        default:
            if (!empty($input)){
                return true;
            }
            else {
                $GLOBALS['validationMessages']["val" . $name] = "Please enter a $name";
                $GLOBALS['validForm'] = false;
                return false;
            }
    }
}

function formValid(){
    if($GLOBALS['validForm'] == true){
        return true;
    }
    else {
        return false;
    }
}
?>