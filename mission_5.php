<!DOCTYPE HTML>
<html>
    <head>
         <meta charset ="utf-8">
         <title>mission 5-01</title>
    </head>
    
    <body>
        
    <?php
    $dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	//編集
	if(isset($_POST["name"],$_POST["comment"],$_POST["edit"],$_POST["pass"])){
	if($_POST["name"]!=""&&$_POST["comment"]!=""&&$_POST["edit"]!=""
	   &&$_POST["pass"]!=""){    
       $name=$_POST["name"];
       $str=$_POST["comment"];
       $id=$_POST["edit"];
       $pass=$_POST["pass"];
       $date=date("Y/m/d H:i:s");
       //投稿番号の取り出し
       $sql = 'SELECT * FROM m_51 WHERE id=:id';
       $stmt = $pdo->prepare($sql);
	   $stmt->bindParam(':id', $id, PDO::PARAM_INT);
       $stmt->execute();                             
       $results = $stmt->fetchAll();
       foreach($results as $row)
       if($row['password']==$pass){
	      $sql = 'UPDATE m_51 SET name=:name,comment=:comment,date=:date,password=:password WHERE id=:id';
	      $stmt = $pdo->prepare($sql);
	      $stmt->bindParam(':name', $name, PDO::PARAM_STR);
	      $stmt->bindParam(':comment', $str, PDO::PARAM_STR);
	      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	      $stmt->bindParam(':date', $date, PDO::PARAM_STR);
	      $stmt->bindParam(':password', $pass, PDO::PARAM_STR);
	      $stmt->execute();
	   }
	}
	}
	//新規書き込み
	if(isset($_POST["name"],$_POST["comment"],$_POST["pass"])&&
	   empty($_POST["edit"])){
	   if($_POST["name"]!=""&&$_POST["comment"]!=""&&$_POST["pass"]!=""){
	   $name=$_POST["name"];
	   $str=$_POST["comment"];
	   $pass=$_POST["pass"];
	   $date=date("Y/m/d H:i:s");
	   $sql = $pdo -> prepare("INSERT INTO m_51 (name, comment, date, password) VALUES (:name, :comment, :date, :password)");
	   $sql -> bindParam(':name', $name, PDO::PARAM_STR);
	   $sql -> bindParam(':comment', $str, PDO::PARAM_STR);
	   $sql -> bindParam(':date', $date, PDO::PARAM_STR);
	   $sql -> bindParam(':password', $pass, PDO::PARAM_STR);
	   $sql -> execute();
	   }
	   }   
	//削除
	if(isset($_POST["deleteNo"],$_POST["delpass"])){
	   if($_POST["deleteNo"]!=""&&$_POST["delpass"]!=""){
	   $id = $_POST["deleteNo"];
	   $delpass=$_POST["delpass"];
	   $sql = 'SELECT * FROM m_51 WHERE id=:id ';
	   $stmt = $pdo->prepare($sql);
	   $stmt->bindParam(':id', $id, PDO::PARAM_INT);
       $stmt->execute();                             
       $results = $stmt->fetchAll();
       foreach ($results as $row){
       if($row['password']==$delpass){
          $id = $_POST["deleteNo"]; 
	      $sql = 'delete from m_51 WHERE id=:id';
	      $stmt = $pdo->prepare($sql);
	      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	      $stmt->execute();
	   }
	}
	}
	}
	//編集番号選択
	if(isset($_POST["editNo"],$_POST["editpass"])){
	    if($_POST["editNo"]!=""&&$_POST["editpass"]!=""){
        $id = $_POST["editNo"];
        $editpass=$_POST["editpass"];
        $sql = 'SELECT * FROM m_51 WHERE id=:id ';
        $stmt = $pdo->prepare($sql);                  
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
        $stmt->execute();                             
        $results = $stmt->fetchAll(); 
        foreach($results as $row){
        if($row['password']==$editpass){
	       foreach ($results as $row){
		      $editnum=$row['id'];
		      $editname=$row['name'];
		      $editcom=$row['comment'];
	          }
        }
        }
	} 
	}
    //表示
    $sql = 'SELECT * FROM m_51';
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
          <input type="text" name="name" placeholder="名前" value="<?php if(isset($editname)){echo $editname;}?>">
          <input type="text" name="comment" placeholder="コメント" value="<?php if(isset($editcom)){echo $editcom;}?>">
          <input tpye="text" name="pass" placeholder="パスワード">
          <input type="hidden" name="edit" value="<?php if(isset($editnum)){echo $editnum;} ?>">
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