<?php 
    include('function_library.php');
    
    $pdo = connectDB();
    
    $sql = 'SELECT * From threadTitle';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    
    $filename = "top.php";
    $fp = fopen($filename,"w");
    fwrite($fp,
'<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Tech Boardへようこそ</title>
</head>
<body>
    <header>Tech Board</header>
    <br>
    <a href="/tb-250260/list-app/create-form.php">スレッド作成はこちら</a>
    
    <br><br>スレッド一覧<br>'    
    );
    
    foreach($results as $thread){
       $filename = $thread["id"].".php";
       $title =  $thread["title"];
       fwrite($fp,PHP_EOL."    <a href='/tb-250260/list-app/".$filename."'>".$title."</a><br>");
    }
    
    fwrite($fp,PHP_EOL.
'</body>
</html>'
    );
    
    header("Location:/tb-250260/list-app/top.php");
    exit();
