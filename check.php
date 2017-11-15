
<?php
	session_start();
?>
<html>
<mega charset = "utf-8">
<head>
</head>
<body>

<br/>
<form action = "check.php" method = "post">

	名前：<br/>
	<input type = "text" name = "name" size = "30" value = "<?php echo $_SESSION['name'] ?>"/>
	<br/>
	パスワード：：<br/>
	<input type = "password" style = "front-size:64px" name = "passset" value = "<?php echo $_SESSION['passset'] ?>"/>
	<br/>
	メールアドレス：<br/>
	<input type = "email" name = "email" size = "50" value = "<?php echo $_SESSION['email'] ?>"/>
	<button type = "submit" name = "action" value = "send">認証</button>
	<br/>
</form>
</body>
</html>

<?php
$user = 'ユーザー名';
$password = 'パスワード';

$name = $_POST['name'];
$setpass = $_POST['passset'];
$email = $_POST['email'];

try{
	$dbh = new PDO ('データベース名',$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if($_POST['action']){
		$insert = $dbh->prepare("INSERT INTO Touroku(name,pass,email) VALUES('$name','$setpass','$email')");
		$exec = $insert->execute();
			if($exec){
				$stmt = $dbh->query("SELECT * FROM Touroku WHERE name ='$name'");
				foreach($stmt as $row){
					echo "登録された内容は以下になります。<br/>";
					echo "ID:$row[0]<br/>";
					echo "名前：$row[1]<br/>";
					echo "パスワード：$row[2]<br/>";
					echo "メールアドレス：$row[3]<br/>";
				}
				$_SESSION = array();
				session_destroy();
			}
	}
}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}

 
?>

<a href="login.php">ログイン画面へ</a>