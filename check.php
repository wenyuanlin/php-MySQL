
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

	���O�F<br/>
	<input type = "text" name = "name" size = "30" value = "<?php echo $_SESSION['name'] ?>"/>
	<br/>
	�p�X���[�h�F�F<br/>
	<input type = "password" style = "front-size:64px" name = "passset" value = "<?php echo $_SESSION['passset'] ?>"/>
	<br/>
	���[���A�h���X�F<br/>
	<input type = "email" name = "email" size = "50" value = "<?php echo $_SESSION['email'] ?>"/>
	<button type = "submit" name = "action" value = "send">�F��</button>
	<br/>
</form>
</body>
</html>

<?php
$user = '���[�U�[��';
$password = '�p�X���[�h';

$name = $_POST['name'];
$setpass = $_POST['passset'];
$email = $_POST['email'];

try{
	$dbh = new PDO ('�f�[�^�x�[�X��',$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if($_POST['action']){
		$insert = $dbh->prepare("INSERT INTO Touroku(name,pass,email) VALUES('$name','$setpass','$email')");
		$exec = $insert->execute();
			if($exec){
				$stmt = $dbh->query("SELECT * FROM Touroku WHERE name ='$name'");
				foreach($stmt as $row){
					echo "�o�^���ꂽ���e�͈ȉ��ɂȂ�܂��B<br/>";
					echo "ID:$row[0]<br/>";
					echo "���O�F$row[1]<br/>";
					echo "�p�X���[�h�F$row[2]<br/>";
					echo "���[���A�h���X�F$row[3]<br/>";
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

<a href="login.php">���O�C����ʂ�</a>