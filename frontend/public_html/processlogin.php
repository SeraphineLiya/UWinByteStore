<!-- Checks the user's credentials and generates a admin session if successful -->
<?php
    require_once('../Private/dbConnect.php'); //Connects to the database
    session_start(); //Start the user's session.

    //Store the login details received from login.html
    $username = $_POST["username"];
    $password = $_POST["password"];

    //Query the password and status / permission level of the matching username
    $sqlQuery = $dbAdminConn->prepare("SELECT Username, EncryptedPassword, AccountStatus FROM Accounts WHERE Username = ?");
    $sqlQuery->bind_param("s", $username); //Put user email into query safely
    $sqlQuery->execute(); //Run the query
    $queryResult = $sqlQuery->get_result();
    $queryResult = $queryResult->fetch_assoc(); //Save the results of the query (username is unique so there will be only one record returned at most).

    //This block will run if the password matches one retrieved from the database.
    //If it is incorrect or nothing was retrieved from the database (wrong username for example), the following block is executed instead.
    if($queryResult && password_verify($password, $queryResult['EncryptedPassword'])){ //Uses truthiness of queryResult to check something was retrieved.
        //These session settings are used for both tracking permission levels and determining if the user is logged in.
        $_SESSION['username'] = $queryResult['Username'];
        $_SESSION['AccountStatus'] = $queryResult['AccountStatus']; //Pending, Admin, or Blocked are the current options.
        
        //This switch statement will give different options based on account permission level.
        switch($_SESSION['AccountStatus']){
            //Accounts that have not been reviewed are sent to the home page.
            case 'Pending':
                //TODO: @Souper, supplementing this with JavaScript redirection might be valuable.
                header("refresh: 5; url=index.html"); //Redirect to profile summary page after 5 seconds.
                echo "Login successful. Admin access pending review. Redirecting automatically...<br>";
                echo "<a href='index.html'>Click here</a><span> if you are not redirected automatically.</span>";
                break;
            
            //Accounts that have been granted admin access go to the control panel.
            case 'Admin':
                header("refresh: 3; url=admin/adminpanel.php"); //Redirect to admin main page after 3 seconds.
                echo "Administrator login successful. Redirecting automatically...<br>";
                echo "<a href='admin/adminpanel.php'>Click here</a><span> if you are not redirected automatically.</span>";
                break;

            //Accounts whose admin access has been blocked get a page telling them so.
            case 'Blocked':
                header("refresh: 5; url=index.html"); //Redirect to the home page after 5 seconds.
                echo "Login successful. Admin access is not granted. Redirecting automatically...<br>";
                echo "<a href='index.html'>Click here</a><span> if you are not redirected automatically.</span>";
                break;
        }
    }
    //Else the login failed for some reason. Tell the user this, but vaguely (no point giving hackers hints).
    else {
        //This is intentionally vague and will not give the user information about why the login failed in case they are malicious.
        //Note: I may replace this with flash messages on the login page itself if we cover that in class.
        echo "Login failed.<br>"; 
        echo "<a href='index.html' class = 'hyperButton'>Cancel</a> <a href='login.html' class = 'hyperButton'>Try Again</a>";
    }
?>