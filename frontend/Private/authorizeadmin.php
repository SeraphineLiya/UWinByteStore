<!-- This code confirms that the currently logged-in user account has admin permissions.
 Without it, the page will be redirected to a Permission Denied page and no protected content will
 render. It is placed at the top of protected pages through require().-->
<?php
    //Lock the page to only those who have authorization.
    session_start();
    if(!isset($_SESSION['AccountStatus'])){ //If session has not yet been created..
        header("/login.html"); //Redirect to the login page.
    }

    else if($_SESSION['AccountStatus'] !== 'Admin'){ //If session has been created but not for an Admin..
        header("/403.shtml"); //Redirect to the permission denied page.
        exit();
    }
?>
