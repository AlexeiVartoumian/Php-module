<?php

    /*
    In here I will will include all ther functions  needed to valifdate the pass word and  also use the valid email function
    * */

    function read_user_input(){
        $email = "";
        $username = "";
        $password = "";
        if (isset( $_POST['email'] )){
            $email = $_POST['email'];
        }
        if (isset($_POST['username'])){
            $username = $_POST['username'];
        }
        if (isset($_POST['password'])){
            $password = $_POST['password'];
        }
        $array = [$email,$username,$password];
        return $array;
    }
    function valid_email($name){   
        if (!filter_var($name,FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            //echo $emailErr;
            return FALSE;
            }
        return True;

    }
    // invalid email formal
    function valid_username($name){
        if(strlen($name)<8 or !ctype_alnum($name)){
            //echo "Username Less than 8 characters or NOT alphanumeric!";
            return FALSE;
        } 
        return True;
    }

    #mycurrent idea is to validate the isset variables after which store them into an array where this func below will accept the arguements
    #as arr[0],arr[1]arr[2]
    function valid_email_and_username_and_password1($array){
        $emailErr = "Invalid email format";
        $userres = "Username Less than 8 characters or NOT alphanumeric!";
        $passwordErr  = "not in the required password format";
        $values = [FALSE,FALSE,FALSE];
        $messages = [$emailErr,$userres,$passwordErr];
        $track = FALSE;
        $errors = [0,0,0];
        $email = $array[0];
        $name = $array[1];
        $password = $array[2];
        if(!valid_email($email)){
            $values[0] = TRUE;
            $track = TRUE;
        }
        if (!valid_username($name)){
            $values[1] = TRUE;
            $track = TRUE;
        }
        if(!check_booleans($password)){
            $values[2] = TRUE;   
            $track = TRUE;
        }
        if($track){
            for ($i = 0; $i<sizeof($values);$i++){
                if ($values[$i]){
                    $errors[$i] = $messages[$i];
                }
            }
        
            return [$errors, FALSE];
        }
        return [0,True];
    }
    function valid_email_and_username_and_password($email,$name,$password){
        $emailErr = "Invalid email format";
        $userres = "Username Less than 8 characters or NOT alphanumeric!";
        $passwordErr  = "not in the required password format";
        $values = [FALSE,FALSE,FALSE];
        $messages = [$emailErr,$userres,$passwordErr];
        $track = FALSE;
        $errors = [0,0,0];
        if(!valid_email($email)){
            $values[0] = TRUE;
            $track = TRUE;
        }
        if (!valid_username($name)){
            $values[1] = TRUE;
            $track = TRUE;
        }
        if(!check_booleans($password)){
            $values[2] = TRUE;   
            $track = TRUE;
        }
        if($track){
            for ($i = 0; $i<sizeof($values);$i++){
                if ($values[$i]){
                    $errors[$i] = $messages[$i];
                }
            }
        
            return [$errors, FALSE];
        }
        return [0,True];
    }
    

    function has_no_special_chars($string) {
        
        $special_chars = '!-<>£$%&*~#';
        for ($i = 0; $i < strlen($string); $i++){
            for ($j = 0; $j < strlen($special_chars); $j++){
                if ($string[$i] == $special_chars[$j]){
                    return FALSE;
                }
            }
        }
        return TRUE;
      }
    function has_no_uppercase($string) {
        for ($i = 0; $i < strlen($string); $i++) {
          if (ctype_upper($string[$i])) {
            return FALSE;
          }
        }
        return TRUE;
      }
    function has_no_lowercase($string) {
        for ($i = 0; $i < strlen($string); $i++) {
          if (ctype_lower($string[$i])) {
            return False;
          }
        }
        return True;
      }
    function has_no_numeric($string) {
        for ($i = 0; $i < strlen($string); $i++) {
          if (ctype_digit($string[$i])) {
            return False;
          }
        }
        return TRUE;
      }

      function is_valid($string,$values){
        $number = 8;
        if (strlen($string) < 8){
            $values[0] = TRUE;
        }
        if (has_no_special_chars($string)){
            $values[1] = TRUE;
            }
        if (has_no_uppercase($string)){
            $values[2] = TRUE;
        }
        if (has_no_lowercase($string)){
            $values[3] = TRUE;
        }
        if (has_no_numeric($string)){
            $values[4] = TRUE;
        }
        return $values;
    }		
    # purpose of this function is to avoid extra work in generation of valid password. if this function return true it means given password has all the requirements passed to be a valid password 
    function check_booleans($string, $values =  [FALSE,FALSE,FALSE,FALSE,FALSE]){
        $newvals = is_valid($string,$values);
        for ($i = 0; $i < sizeof($newvals); $i++) {
            if ($newvals[$i] == TRUE) {
                return FALSE;
            }
        }
        return True;
    }




?>