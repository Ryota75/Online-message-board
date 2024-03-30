<?php
    $dsn = 'mysql:dbname=tb250260db;host=localhost';
    $user = 'tb-250260';
    $password = 'zKsCErYh3h';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    $sql = "CREATE TABLE IF NOT EXISTS tbtest
                (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    number INT,
                    name char(32),
                    comment TEXT,
                    date DATETIME,
                    password varchar(32),
                    edited char(6),
                    threadID INT
                );";
    $stmt = $pdo->query($sql);
    
    $sql = "CREATE TABLE IF NOT EXISTS threadTitle
                (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    title char(50)
                );";
    $stmt = $pdo->query($sql);