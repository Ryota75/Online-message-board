<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Tech Boardへようこそ</title>
</head>
<body>
    
    <?php include('function_library.php'); ?>
    <a href="/tb-250260/list-app/top-pre.php" class="header">Tech Board</a>
    
    <br>スレッド作成
    <form action="create-thread.php" method="post">
        <input type="text" name="thread_title" placeholder="スレッドタイトルを入力">
        <input type="submit" name="create_thread" value="作成">
    </form>
</body>
</html>