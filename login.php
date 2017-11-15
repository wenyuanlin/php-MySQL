<?php
	session_start();
?>
<html>
<mega charset = "utf-8">
<head>
<h1>簡易レビュー掲示板</h1>
</head>
<body>
本掲示板を登録したユーザーのみが使用できるものです。<br/>
初めての方は登録をお願いします。<br/>
<br/>
<form action = "login.php" method = "post">

	名前：<br/>
	<input type = "text" name = "name" size = "30">
	<br/>
	パスワード:<br/>
	<input type = "password" style = "front-size:64px" name = "passset">
	<br/>
	メールアドレス：<br/>
	<input type = "email" name = "email" size = "50">
	<button type = "submit" name = "action" value = "send">登録</button>
	<br/>
	<br/>
すでに登録した方は下によりログインをお願いします。<br/>
	ID：<br/>
	<input type = "text" name = "id" size = "10">
	<br/>
	パスワード：<br/>
	<input type = "password" style = "front-size:64px" name = "passw">
	<button type = "submit" name = "log" value = "login">ログイン</button>
	<br/>

<?php
$user = 'ユーザー名';
$password = 'パスワード';
$id = $_POST['id'];

try{
	$dbh = new PDO ('データベース名',$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
	$stmt = $dbh->prepare("SELECT * FROM Touroku WHERE id ='$id'");
	$stmt->execute(array($id));
	if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    		if ( strcmp($_POST['passw'], $row['pass']) == 0) {
         		session_regenerate_id(true);

			$userid = $row['id'];
			$sql_id = "SELECT * FROM Touroku WHERE id ='$id'";
			$stmt = $dbh->query($sql_id);
			foreach($stmt as $row){
				$row['name'];
			}
        		$_SESSION['name'] = $row['name'];
			$_SESSION['id'] = $row['id'];
        		header("location: keijiban.php");
			exit();
   	 	}else {
        		$_SESSION['message'] = "パスワードが間違いました。再入力をお願いします。";
   		 }
	}
	$_SESSION = array();
	session_destroy();
}catch (PDOException $ex){
	exit('Error occurred'.$ex->getMessage());
}
?>


</form>
</body>
</html>

<?php
	session_start();
?>

<?php
$user = 'ユーザー名';
$password = 'パスワード';
$name = $_POST['name'];
$setpass = $_POST['passset'];
$email = $_POST['email'];
try{
	$dbh = new PDO ('データベース名',$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
if(empty($name)){
	echo "名前を入力してください";
}elseif(empty($setpass)){
	echo "パスワードを設定してください";
}elseif(empty($email)){
	echo "メールアドレスを入力してください";
}else{
	$insert = $dbh->prepare("INSERT INTO PreTouroku(name,pass,email) VALUES('$name','$setpass','$email')");
	$exec = $insert->execute();
	if($exec){
		echo "仮登録を完了しました。メールにて認証をお願いします。<br/>";
	$_SESSION['name'] = $name;
	$_SESSION['passset'] = $setpass;
	$_SESSION['email'] = $email;
	}
}

}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}

$errors = array();

	
$url = "http://co-743.it.99sv-coco.com/check.php"."?name=".$name;

//メールの宛先

$to = $email;
$subject = "Account Verification";
$body = "
Thank you for signing up!
 Please click this link to activate your account in 24 hours:
{$url}
";
	
if (mb_send_mail($to, $subject, $body)) {
 	$message = "メールをお送りしました。24時間以内にメールに記載されたURLからご登録下さい。";
} 
?>