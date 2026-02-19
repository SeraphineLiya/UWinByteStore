<!-- This file contains all of the portable functions used in this website -->

<?php
    //Function to verify user entered a reasonable value
    function validate_input($input, string $type, string $inputName): string {
        
        $errorMsg = ''; //String to store error message.

        //Check if input is null or blank. Regardless of input type, we don't want that if we're validating it.
        if($input === null || trim($input) === ""){
            $errorMsg = "<li>" . $inputName . ' cannot be blank or null.</li>';
        }

        //Check that it does not exceed the maximum length if it is a short string type. If it does, record an error.
        if(($type === 'email' || $type === 'password' || $type === 'shortString') && strlen($input) > 254){
            $errorMsg .= "<li>" . $inputName . ' cannot exceed 254 characters.</li>';
        } 

        //Check that it does not exceed the maximum length if it is a long string type. If it does, record an error.
        if(($type === 'longString') && strlen($input) > 9999){
            $errorMsg .= "<li>" . $inputName . ' cannot exceed 9999 characters.</li>';
        } 

        //Validation specific to email
        else if($type === 'email'){
            //Validate the email using PHP's built in function
            if(!filter_var($input, FILTER_VALIDATE_EMAIL)){ //If not valid..
                $errorMsg .= "<li>" . $inputName . ' is not a valid email address.</li>';
                return $errorMsg;
            }
        }

        //Validation specific to passwords
        else if($type === 'password'){
            
            //Ensure input is at least 8 characters long.
            if(strlen($input) < 8){
                $errorMsg .= "<li>" . $inputName . ' must contain at least 8 characters.</li>';
                return $errorMsg;
            }
        }

        //Validation for recommended prices
        else if($type === 'price'){
            
            if($input < 0.00){
                $errorMsg .= "<li>" . $inputName . " cannot be negative.</li>";
                return $errorMsg;
            }
            else if($input > 10000){
                $errorMsg .= "<li>" . $inputName . " cannot exceed $10K. That's too much, please be more reasonable.</li>";
                return $errorMsg;
            }
        }

        //...More checks to be added as needed!

        return $errorMsg; //Returns the empty error message which tells us the value is not blank or null.
    }
?>
