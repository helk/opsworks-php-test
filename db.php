<?php

    function getOpsworksDBConfig() {
        $db = NULL;
        if (file_exists(dirname(__FILE__) . "/opsworks.php")){
            require_once(dirname(__FILE__) . "/opsworks.php");
            $opsWorks = new OpsWorks();
            $db = $opsWorks->db;
        }      
        return $db;  
    }

    function connectDB() {
        $pdo = NULL;
        try {

            $db = getOpsworksDBConfig();

            if(!$db) {
                die("no db config");
            }

            $dbHost = $db->host;
            $dbName = $db->database;
            $dbUser = $db->username;
            $dbPassword = $db->password;

            $pdo = new PDO("mysql:host=$dbHost;port=3306;dbname=$dbName",
                $dbUser,
                $dbPassword,
                array( PDO::ATTR_PERSISTENT => false)
            );

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

        return $pdo;
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