<!DOCTYPE HTML>
<html>
    <head>
         <meta charset ="utf-8">
         <title>mission 5-01</title>
    </head>
    
    <body>
        
    <?php
    $pass=$_POST["pass"];
    $delpass=$_POST["delpass"];
    $editpass=$_POST["editpass"];
    $editNo=$_POST["editNo"];
    $edit=$_POST["edit"];
    $name=$_POST["name"];
    $str=$_POST["comment"];
    $date1=date("Y/m/d H:i:s");
    $date=$date1;
    $dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	if($name && $str && $_POST["edit"] && $pass=="123"){
    $id =$edit; 
	$sql = 'UPDATE tb51 SET name=:name,comment=:comment,date=:date WHERE id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $str, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->bindParam(':date', $date, PDO::PARAM_STR);
	$stmt->execute();
	}
	if($name && $str && $pass=='123' && empty($_POST["edit"])){
	$sql = $pdo -> prepare("INSERT INTO tb51 (name, comment, date) VALUES (:name, :comment, :date)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $str, PDO::PARAM_STR);
	$sql -> bindParam(':date', $date, PDO::PARAM_STR);
	$sql -> execute();
	}
	if($_POST["deleteNo"] && $delpass=="123"){
	$id = $_POST["deleteNo"];
	$sql = 'delete from tb51 where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	}
	if($_POST["editNo"]){
        $id = $editNo ; 
        $sql = 'SELECT * FROM tb51 WHERE id=:id ';
        $stmt = $pdo->prepare($sql);                  
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
        $stmt->execute();                             
        $results = $stmt->fetchAll(); 
	    foreach ($results as $row){
		   $editnum=$row['id'];
		   $editname=$row['name'];
		   $editcom=$row['comment'];
	}
    }
    $sql = 'SELECT * FROM tb51';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['date']."<br>";
	}    
    ?>
    <form action="" method="post">
        <h1>【投稿フォーム】</h1>
          <input type="text" name="name" placeholder="名前" value="<?php echo $editname;?>">
          <input type="text" name="comment" placeholder="コメント" value="<?php echo $editcom;?>">
          <input tpye="text" name="pass" placeholder="パスワード">
          <input type="hidden" name="edit" value="<?php echo $editnum; ?>">
          <input type="submit" name="submit"><br>
        <h1>【削除フォーム】</h1>  
          <input type="number" name="deleteNo" placeholder="削除対象番号">
          <input type="text" name="delpass" placeholder="パスワード">
          <input type="submit" name="delete" value="削除"><br>
        <h1>【編集番号選択】</h1>
          <input type="number" name="editNo" placeholder="編集対象番号">
          <input type="text" name="editpass" placeholder="パスワード">
          <input type="submit" value="編集"><br>
    </form>
    
    </body>
</html>