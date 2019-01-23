<?php

    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    require_once(dirname(__FILE__) . "/db.php");

    if(isset($_POST['Submit'])) {
        $email = $_REQUEST['email'];

        addUser($email);
    }
?>

<html>
<style>
    body {
        background: green;
    }
</style>
<body>
<h1>OpsWorks PHP App</h1>
<div>

    <?php 
        printUsers();
    ?>

    <form action=""  method="POST">
        <label for="name" id="email">Email</label>
        <input type="text" name="email" id="email" />

        <input type="submit" name="Submit" value="send" />
    </form>
</div>
</body>
</html>