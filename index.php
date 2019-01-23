<html>
<style>
    body {
        background: red;
    }
</style>
<body>
<h1>OpsWorks PHP App</h1>
<div>
    <?php 
        echo "hello";
    ?>
</div>
</body>
</html>

<?php

    function connectDB() {
        try {

            $host = getenv("DB_HOST");
            $dbName = getenv("DB_NAME");
            $dbUser = getenv("DB_USERNAME");
            $dbPassword = getenv("DB_PASSWORD");

            $dbh = new PDO("mysql:host=$dBName;port=3306;dbname=$dbName", $dbUser, $dbPassword,
                array( PDO::ATTR_PERSISTENT => false)
            );

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

        return $dbh;
    }

    function printUsers() {
        $pdo = connectDB();
        $stmt = $pdo->prepare("select * from user");
        $stmt->execute();
        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
            echo "email: ".$rs->email."<br />";
        }
    }

    function addUser($email) {
        $pdo = connectDB();
        $sql = "INSERT INTO user (email) VALUES (?)";
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$email]);
    }

?>