<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Tech Board|スポーツ</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <?php 
        //サーバーの処理
        
        //変数の設定
        $title_id=2;
        $title="スポーツ";
       
        //外部ファイル
        include("function_library.php");
        
        //データベース接続
        $pdo = connectDB();

        //投稿フォーム
        if(isset($_POST["submit_post"])){
            
            //変数設定
            $edit_number = $_POST["edit_number"];//編集モード用　投稿番号参照
            
            if($_POST["comment"] != ""){
                $name = $_POST["name"];//名前設定//
                $comment = nl2br($_POST["comment"]);//コメント設定
                $date = date("Y/m/d H:i:s");//日付設定
                $password = $_POST["password"];//パスワード設定
                
                //投稿番号
                $sql = "SELECT number FROM tbtest WHERE threadID=2 ORDER BY number DESC LIMIT 1";
                $stmt = $pdo->query($sql);
                $result = $stmt->fetch();
                $number = $result["number"] + 1;
                
                if($name == ""){
                    $name = "匿名";
                }
                
                if(empty($edit_number)){//新規投稿モード
                    newPost($pdo, $number, $name, $comment, $date, $password, $title_id);
                    
                }else{//編集モード
                    editPost($pdo, $title_id, $name, $comment, $date, $password, $edit_number);
                }
                
            }
            
        }elseif(isset($_POST["submit_deletion"])){//削除フォーム  
            if(!empty($_POST["deletion"]) && $_POST["password_deletion"] != ""){
                $deletion = $_POST["deletion"];//削除番号設定
                $password_deletion = $_POST["password_deletion"];//パスワード受け取り　削除用

                $check = deletion($pdo, $title_id, $deletion, $password_deletion);
            }
            
        }elseif(isset($_POST["submit_edit"])){//編集フォーム 
            
            if(!empty($_POST["edit"]) && $_POST["password_edit"] != ""){
                $edit = $_POST["edit"];//編集番号設定
                $password_edit = $_POST["password_edit"];//パスワード受け取り　編集用
                
                $array = edit($pdo, $title_id, $edit, $password_edit);
                $edit_name = $array[0];
                $edit_comment = $array[1];
            }
            
        }
    ?>
    
    <div class="display">
        
        <header>
            <a href="/tb-250260/list-app/top-pre.php" class="header">Tech Board</a>
        </header>
        
        <?php
            //スレッドタイトル
            echo "タイトル：".$title."<br>";
        
            //ブラウザ表示　新規投稿モード、編集モード
            if(!isset($edit_name)){
                echo "新規投稿モード<br>";
            }else{
                echo "編集モード<br>";
            }
        ?>
        
        <br>投稿フォーム ※パスワードのない投稿は削除・編集が行えません
        <form method="post">
            <!--名前-->
            <input type="text" name="name" placeholder="名前" value=<?php
            
            if(isset($edit_name)){
                echo  $edit_name;
            }
            
            ?>>
            
            <!--コメント-->
            <textarea cols="30" rows="1" name="comment"><?php
            
            if(isset($edit_name)){
                echo $edit_comment; 
            }
            
            ?></textarea>
            
            <!--パスワード-->
            <input type="text" name="password" placeholder="パスワード" value=<?php
            
            if(isset($edit_name)){
                echo $password_edit;
            }
            
            ?>>
            
            <input type="submit" name="submit_post" value="投稿">
            
            <!--編集番号　隠し-->
            <input type="hidden" name="edit_number" value=<?php
            
            if(isset($edit_name)){
                echo $edit;
            }
            
            ?>>
        </form>
        
        <br>削除フォーム
        <form method="post">
            <input type="number" name="deletion" value="削除番号" placeholder="投稿番号を入力">
            <input type="text" name="password_deletion" placeholder="パスワード">
            <input type="submit" name="submit_deletion" value="削除">
        </form>
        
        <br>編集フォーム
        <form method="post">
            <input type="number" name="edit" value="編集番号" placeholder="投稿番号を入力">
            <input type="text" name="password_edit" placeholder="パスワード">
            <input type="submit" name="submit_edit" value="編集">
            <br>
        </form>
        
        <?php 
            //ブラウザ表示
            
            echo "<br>通知：";
            
            //条件分岐　送信結果
            if(isset($_POST["submit_post"])){//投稿通知
                
                if(empty($edit_number)){//新規投稿モード
                    
                    if($_POST["comment"] != ""){
                        echo "投稿を受け付けました<br>";
                    }else{
                        echo "コメントを入力してください（新規投稿）<br>";
                    }
                    
                }else{//編集モード
                    
                    if($_POST["comment"] != ""){
                        echo $edit_number."は編集されました<br>";
                    }else{
                        echo "コメント未入力での編集はできません　編集フォームからやり直してください　コメントを削除したい場合は削除フォームを使用してください（編集）<br>";
                    }
                    
                }
                
            }elseif(isset($_POST["submit_deletion"])){//削除フォーム
                
                if(!empty($check)){
                    echo $deletion."は削除されました<br>";
                }elseif($_POST["deletion"] != "" && $_POST["password_deletion"] != ""){
                    echo "投稿番号、またはパスワードが違います（削除）<br>";
                }else{
                    echo "投稿番号、パスワードを入力してください（削除）<br>";
                }
                
            }elseif(isset($_POST["submit_edit"])){//編集フォーム
                
                if(isset($edit_name)){
                    echo "投稿フォームで編集してください<br>";
                }elseif($_POST["edit"] != "" && $_POST["password_edit"] != ""){
                    echo "投稿番号、またはパスワードが違います（編集）<br>"; 
                }else{
                    echo "投稿番号、パスワードを入力してください（編集）<br>";
                }
                
            }else{
                echo "<br>";
            }
            
            echo "<br>";
            
            //投稿表示
            displayPost($pdo, $title_id);
        ?>
    </div>
</body>
</html>