<!-- This page runs the logic for the sign up form before redirecting to the catalog page --> 
<?php
    require_once("../Private/dbConnect.php"); //Calls file that establishes a connection to the database.
    require_once("../Private/functions.php"); //Calls portable functions to allow input verification.

    //Save the user's input from the signup form in variables
    $userEmail = $_POST['userEmail'];
    $fName = $_POST['firstName'];
    $lName = $_POST['lastName'];
    $password = $_POST['setPassword'];
    $confirmPass = $_POST['confirmPassword'];

    /*Before going through the trouble of input validation, we will check if there is already an account with
    the same username in the database.*/
    //Query safely
    $sqlQuery = $dbAdminConn->prepare("SELECT Username FROM Accounts WHERE Username = ?");
    $sqlQuery->bind_param("s", $userEmail); //Put user email into query
    $sqlQuery->execute(); //Run the query
    $queryResult = $sqlQuery->get_result(); //Save the results of the query

    //Check number of rows in the result. If it is not zero, it means there is already a user with that email in the database.
    if($queryResult->num_rows !== 0){
        //Outputs an error message and link to the login page.
        echo "<p>Error: There is already an account registered with this email.</p>";
        echo "<a href = 'login.html' class = 'hyperButton'>Proceed to login</a>";
        exit();
    }
    
    //Perform basic validation on the user's input in the sign up form.
    $errorMsg = ''; //Create a string to store all the error messages.

    /*Validate user inputs with custom function in functions.php that takes the input value, custom input type, and its name.
    It returns an error message if needed.*/
    $errorMsg = $errorMsg . validate_input($userEmail, 'email', "Email");
    $errorMsg = $errorMsg . validate_input($fName, 'shortString', "First Name");
    $errorMsg = $errorMsg . validate_input($lName, 'shortString', "Last Name");
    $errorMsg = $errorMsg . validate_input($password, 'password', "Password");

    //Check that the password matches its confirmation entry.
    if($password !== $confirmPass){
        $errorMsg = $errorMsg . "<li>The passwords do not match.</li>";
    }

    //If the error message is not blank, display error message and a button to try again or cancel.
    //Note: I may update this to use flash messages and sessions if we cover that in class. For now, this will do though.
    if($errorMsg !== ''){
        //Output the error message.
        echo "<p>Error:
              <ul>$errorMsg</ul>
              </p>"; 

        //@NotDashy, these might look better either as a CSS button.
        echo "<a href='index.html' class = 'hyperButton'>Cancel</a>"; //Return to home page
        echo "<a href='signup.html' class = 'hyperButton'>Try Again</a>"; //Return to sign up page
    }
    //Else if there is no errors..
    else{
        //Hash the password
        $password = password_hash($password, PASSWORD_DEFAULT);

        //Add the user account to the database.
        $sqlQuery = $dbAdminConn->prepare("INSERT INTO Accounts (Username, FirstName, LastName, EncryptedPassword, AccountStatus) 
                                           VALUES (?, ?, ?, ?, 'Pending')");
        $sqlQuery->bind_param("ssss", $userEmail, $fName, $lName, $password); //Put user email into query safely
        
        //Run the query with error checking, and present result to user.
        if($sqlQuery->execute()){
            echo "<p>Success! Your account request has been created and is pending review by the website administrators.</p>";
        } 
        else { //If the above statement is false, an error occurred.
            echo "<p>An unexpected error has occurred while creating your account. Please contact an administrator for support.</p>";
        }
        echo "<a href='index.html' class = 'hyperButton'>Return Home</a>";
    }
?>
