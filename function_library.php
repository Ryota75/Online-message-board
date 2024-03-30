<?php
    //データベース接続
    function connectDB(){
        $dsn = 'mysql:dbname=tb250260db;host=localhost';
        $user = 'tb-250260';
        $password = 'zKsCErYh3h';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        return $pdo;
    }
    
    //投稿フォーム
    
    //新規投稿モード
    function newPost($pdo, $number, $name, $comment, $date, $password, $title_id){
        $sql = "INSERT INTO tbtest (number, name, comment, date, password, threadID) VALUES (:number, :name, :comment, :date, :password, :threadID)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':number', $number, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':threadID', $title_id, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    //編集モード
    function editPost($pdo, $thread_id, $name, $comment, $date, $password, $edit_number){
        $edited = "（編集済み）";
        $sql = 'UPDATE tbtest SET name=:name,comment=:comment,date=:date,password=:password,edited=:edited WHERE threadID=:threadID && number=:number';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':edited', $edited, PDO::PARAM_STR);
        $stmt->bindParam(':threadID', $thread_id, PDO::PARAM_INT);
        $stmt->bindParam(':number', $edit_number, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    //削除フォーム
    function  deletion($pdo, $thread_id, $deletion, $password_deletion){
        $sql = "SELECT id,password FROM tbtest WHERE threadID=:threadID && number=:number";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':threadID', $thread_id, PDO::PARAM_INT);
        $stmt->bindParam(':number', $deletion, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch();
        
        if($results["password"] == $password_deletion){
            $delecom = "";
            $sql = 'UPDATE tbtest SET comment=:comment where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':comment', $delecom, PDO::PARAM_STR);
            $stmt->bindParam(':id', $results['id'], PDO::PARAM_INT);
            $stmt->execute();
            $check = 1;
            return $check;
        }
    }
    
    //編集フォーム
    function edit($pdo, $thread_id, $edit, $password_edit){
        $sql = 'SELECT name,comment,password FROM tbtest WHERE threadID=:threadID && number=:number';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':threadID', $thread_id, PDO::PARAM_INT);
        $stmt->bindParam(':number', $edit, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch();
        
        if($results['password'] == $password_edit){
            return array($results['name'], $results['comment']);
        }
    }
    
    //投稿表示
    function displayPost($pdo, $title_id){
        $sql = 'SELECT * FROM tbtest WHERE threadID='.$title_id;
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            
            if($row['comment'] != ""){
                //$rowの中にはテーブルのカラム名が入る
                echo $row['number'].'　';
                echo $row['name'].'・';
                echo $row['date'].'　';
                echo $row['edited'].'<br>';
                echo $row['comment'].'<br><br>';
            }
            
        }
    } 
?>