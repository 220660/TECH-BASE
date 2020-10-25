<!DOCTYPE html>
<html lamg="ja">
<head>
    <meta charset="UTF-8">
    <title>m5-1_1</title>
</head>
<body>
    <?php
    
    // DB接続設定
    $dsn = 'mysql:dbname=co_***_it_3919_com;host=localhost';
    $user = 'co-***.it.3919.c';
    $password = 'PASSWORD';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
	//編集機能　前半
	if (isset($_POST["editNo"]) and isset($_POST["edipass"])) {
              if(strlen($_POST["editNo"])!=0 and strlen($_POST["edipass"])!=0){
                $sql='SELECT * FROM 5_1_1';
                    $stmt=$pdo->query($sql);
                    $results = $stmt->fetchAll();
                    foreach ($results as $row){
                        if($row['id']==$_POST["editNo"]){
                            if($row['dpass']==$_POST["edipass"]){
                            $name1=$row['name'];
                            $comment1=$row['comment'];
                            $edit2=$row['id'];
                            $passkey=$row['dpass'];
                            }
                        }
                    }
        }
     }
        


	?>
	
	<!--formを書き込む-->
	<label for="message">message</label><br>
    <form action="" method="POST">
    入力フォーム<br>
    名前<input type="text" name="name1" value="<?php if(isset($name1)) {echo $name1;} ?>" placeholder="名前">
    コメント<input type="text" name="comment1" value="<?php if(isset($comment1)) {echo $comment1;} ?>" placeholder="コメント">
    <input type="hidden" name="edit2" value="<?php if(isset($edit2)) {echo $edit2;} ?>"placeholder="編集投稿番号">
    パスワード<input type="text" name="pass" value="<?php if (isset($pass)){echo $pass;}?>" placeholder="パスワード">
    <input type="hidden" name="passkey" value="<?php if (isset($passkey)){echo $passkey;}?>" placeholder="編集対象パスワード表示"> 
    <input type="submit" name="sumbit" value="送信"> 
    </form>
    </form>
    <form action="" method="POST">
    削除対象番号<input type="text" name="deleteNo" placeholder="消去したい投稿番号">
    パスワード<input type="text" name="delpass" placeholder="消去したい投稿のパスワード">
    <input type="submit" name="delete" value="削除">
    </form>
    <form action="" method="POST">
    編集番号<input type="text" name="editNo" placeholder="編集したい投稿番号">
    パスワード<input type="text" name="edipass" placeholder="編集したい投稿のパスワード">
    <input type="submit" name="edit" value="編集">
    </form>
	<?php
    $date = date("Y/m/d H:i:s");

	//もし空でなければ以下のことを行う
	if (isset($_POST["name1"]) and isset($_POST["comment1"]) and isset($_POST["pass"])){
     	if(strlen($_POST["name1"])!=0 and strlen($_POST["comment1"])!=0 and strlen($_POST["pass"])!=0){
     	    $name1 = $_POST["name1"];
            $comment1 = $_POST["comment1"];
            $str=$name1.$comment1;
            $pass = $_POST["pass"];
            
            if(strlen($_POST["edit2"]==0)){
                $edit2=$_POST["edit2"];

	 //データの入力
	$sql = $pdo -> prepare("INSERT INTO 5_1_1 (time, name, comment, dpass) VALUES (:time, :name, :comment, :dpass)");
	$sql -> bindParam(':time', $time, PDO::PARAM_STR);
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':dpass', $dpass, PDO::PARAM_STR);
	        $time=$date;
	        $name=$name1; 
	        $comment=$comment1;
	        $dpass=$pass;
        	$sql -> execute();
	echo "新しい投稿を送信しました <br>";
     	}
	 
            //編集機能
            
            else{
	             $id = $_POST["edit2"]; //変更する投稿番号
	             $time=$date;
	             $name = $_POST["name1"];
	             $comment = $_POST["comment1"]; //変更したい名前、変更したいコメント
	             $dpass=$_POST["passkey"];
            	 $sql = 'UPDATE 5_1_1 SET time=:time,name=:name,comment=:comment,dpass=:dpass WHERE id=:id';
             	 $stmt = $pdo->prepare($sql);
             	 $stmt->bindParam(':time', $time, PDO::PARAM_STR);
            	 $stmt->bindParam(':name', $name, PDO::PARAM_STR);
	             $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	             $stmt->bindParam(':dpass', $dpass, PDO::PARAM_STR);
	             $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	             $stmt->execute();
            }
            }
	}

	//消去機能
    if (isset($_POST["delpass"]) and isset($_POST["deleteNo"])){
     	if(strlen($_POST["delpass"])!=0 and strlen($_POST["deleteNo"])!=0 ){
     	    
    $delpass=$_POST["delpass"];
    $deleteNo=$_POST["deleteNo"];
    
     	$sql = 'SELECT * FROM 5_1_1';
	    $stmt = $pdo->query($sql);
	    $results = $stmt->fetchAll();
	    foreach ($results as $row){
                if ($row['id'] == $_POST["deleteNo"]){
                    if  ($row['dpass'] == $_POST["delpass"]){
	    $id = $_POST["deleteNo"];
	    $sql = 'delete from 5_1_1 where id=:id';
	    $stmt = $pdo->prepare($sql);
	    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	    $stmt->execute();
	    echo"投稿を削除しました。<br>" ;
     	}
        else{
            echo " ";
            }
        }	
    }
    }
    }
    
	

        //表示機能  4-6参考に
	    $sql = 'SELECT * FROM 5_1_1';
	    $stmt = $pdo->query($sql);
	    $results = $stmt->fetchAll();
	        foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['time'].',';
		echo $row['name'].',';
		echo $row['comment'].'<br>';
	    echo "<hr>";
	    }
	
	?>
</body>
</html>