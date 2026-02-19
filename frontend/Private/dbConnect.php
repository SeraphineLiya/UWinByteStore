<!--This file is used to create connections to the website's database.-->
<?php
    //This connection has full access to the database with all permissions (including write).
    $dbAdminConn = new mysqli(
        "localhost", //Server
        "username", //Username
        "password", //Password
        "database" //Database
    );

    //This connection is limited to only SELECT statements for retrieving data from the database.
    $dbPublicConn = new mysqli(
        "localhost",
        "username", //Username
        "password", //Password
        "database" //Database
    );
?>
