
<html>
<head>
  <meta charset="utf-8">
  <title>mission_4-1</title>
</head>

<body>
<!--フォームを作成-->
<form  action="mission_4-1.php" method="POST">

<!--名前のフォーム-->
<input type="text" name="name"value = "名前"><br/>

<!--コメントのフォーム-->
<input type="text" name="coment"value = "コメント"><br/>

<!--パスワードのフォーム-->
<input type="text" name="pass"value = "パスワード">

<!--送信ボタン-->
<input type="submit" name="send" value = "送信" ><br/><br/>

<!--削除のフォーム-->
<input type="text" name="deleteNO"value="削除対象番号"><br/>

<!--パスワードのフォーム-->
<input type="text" name="d_pass"value = "パスワード">
<!--削除ボタン-->
<input type="submit" name="delete" value="削除"><br/><br/>

<!--編集対象番号のフォーム-->
<input type="text" name="hensyu"value = "編集対象番号"><br/>

<!--パスワードのフォーム-->
<input type="text" name="h_pass"value = "パスワード">
<input type="submit" name="hensyu_botton" value="編集">
 </form>

<?php
//データベースへ接続する
$dsn ='mysql:dbname=データベース;host=localhost';
$user='ユーザー名';
$password ='パスワード';
$pdo = new PDO($dsn,$user,$password);


//テーブルを作成する
$sql ="CREATE TABLE tbtest2"
."("."id INT AUTO_INCREMENT,"
."name char(32),"
."comment TEXT,"
."INDEX(id)".");";
$stmt = $pdo->query($sql);



//phpのプログラム
	$name=$_POST["name"];
	$coment=$_POST["coment"];
	$now=date("Y")."/".date("m/d H:i:s");
	$pass=$_POST["pass"];


//入力フォーム
if(isset($_POST['send'])){

if(!empty($_POST["pass"])&&($pass!="パスワード")){
//passwardを取得する場所
//password用のテーブルを作成する
//passのテーブル作成
$sql ="CREATE TABLE ptb"
."("."id INT AUTO_INCREMENT,"
."pass char(32),
"."INDEX(id)".");";
$stmt = $pdo->query($sql);

//passwordを受け取る
$sql=$pdo->prepare("INSERT INTO ptb(pass) VALUES (:pass)");
$sql->bindParam(':pass',$pass,PDO::PARAM_STR);
$sql->execute();


		  if(!empty($_POST["name"])&&($name!="名前")){
			     if(!empty($_POST["coment"])&&($coment!="コメント")){


//投稿内容を受け取る場所
$sql=$pdo->prepare("INSERT INTO tbtest2(name,comment) VALUES (:name,:comment)");
$sql->bindParam(':name',$name,PDO::PARAM_STR);
$sql->bindParam(':comment',$coment,PDO::PARAM_STR);
$sql->execute();


            }else{print("コメントが記入されてません<br/>");} //comentがない
      }else{print("名前が記入されてません<br/>");}//nameがない

	}else{print("パスワードが記入されてません<br/>");}//passwartが無い場合
}
//max idを取得する



$sql = 'SELECT * FROM  ptb WHERE id=(select max(id) from ptb)';
$results = $pdo -> query($sql);
foreach($results as $row2){
//$rowの中にはテーブルのカラム名が入る　パスワードが表示されるか実験
$test= $row2['pass'];
}



//編集フォーム
$id_h=$_POST["hensyu"];
$h_pass=$_POST["h_pass"];
if(isset($_POST['hensyu_botton'])){
//編集モード
	if(!empty($_POST["h_pass"])&&($h_pass!="パスワード")){
		if($h_pass == $test){
		    if(!empty($_POST["hensyu"])&&($id_h!="編集対象番号")){//編集番号があるときのみ実行
			       if(!empty($_POST["name"])&&($name!="名前")){
				           if(!empty($_POST["coment"])&&($coment!="コメント")){
//編集の場所
$sql = "update tbtest2 set name='$name',comment='$coment'where id = $id_h";
$result = $pdo -> query($sql);

						        }
						}
				}
		}else{print("パスワードが違います<br/>");}
	}else{print("パスワードが記入されてません<br/>");}
}



$id_d=$_POST["deleteNO"];
//削除フォーム
$d_pass=$_POST["d_pass"];
if (isset($_POST['delete'])){ //もし削除ボタンを受けたら
if(!empty($_POST["d_pass"])&&($d_pass!="パスワード")){
		if($d_pass == $test){

$sql = "delete from tbtest2 where id = $id_d";
$result = $pdo->query($sql);



		}else{print("パスワードが違います<br/>");}

	}else{print("パスワードが記入されてません<br/>");}
}

//テキストの中身を表示
$sql = 'SELECT * FROM tbtest2';//tbtest2の内容検索する
$results = $pdo -> query($sql);
foreach($results as $row){
//$rowの中にはテーブルのカラム名が入る
echo $row['id'].',';
echo $row['name'].',';
echo $row['comment'].'<br>';
}




?>

</body>
</html>
