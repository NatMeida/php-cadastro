<?php
    try {
        require("env.php");

        $db = "mysql:host=$host;dbname=$database;charset=utf8";
        $pdo = new PDO($db, $username, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $err) {
        echo "ERRO DE CONEXÃO:  $err\n<br>";
    }
