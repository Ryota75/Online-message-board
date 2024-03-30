<?php
    $dsn = 'mysql:dbname=tb250260db;host=localhost';
    $user = 'tb-250260';
    $password = 'zKsCErYh3h';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE  => PDO::ERRMODE_WARNING));

    $sql = 'TURNCATE tbtest';
    $stmt = $pdo->query($sql);
    
    $sql = 'TURNCATE threadTitle';
    $stmt = $pdo->query($sql);