<?php
	session_start();
?>
<html>
<mega charset = "utf-8">
<head>
<h1>�ȈՃ��r���[�f����</h1>
</head>
<body>
�{�f����o�^�������[�U�[�݂̂��g�p�ł�����̂ł��B<br/>
���߂Ă̕��͓o�^�����肢���܂��B<br/>
<br/>
<form action = "login.php" method = "post">

	���O�F<br/>
	<input type = "text" name = "name" size = "30">
	<br/>
	�p�X���[�h:<br/>
	<input type = "password" style = "front-size:64px" name = "passset">
	<br/>
	���[���A�h���X�F<br/>
	<input type = "email" name = "email" size = "50">
	<button type = "submit" name = "action" value = "send">�o�^</button>
	<br/>
	<br/>
���łɓo�^�������͉��ɂ�胍�O�C�������肢���܂��B<br/>
	ID�F<br/>
	<input type = "text" name = "id" size = "10">
	<br/>
	�p�X���[�h�F<br/>
	<input type = "password" style = "front-size:64px" name = "passw">
	<button type = "submit" name = "log" value = "login">���O�C��</button>
	<br/>

<?php
$user = '���[�U�[��';
$password = '�p�X���[�h';
$id = $_POST['id'];

try{
	$dbh = new PDO ('�f�[�^�x�[�X��',$user,$password);
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
        		$_SESSION['message'] = "�p�X���[�h���ԈႢ�܂����B�ē��͂����肢���܂��B";
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
$user = '���[�U�[��';
$password = '�p�X���[�h';
$name = $_POST['name'];
$setpass = $_POST['passset'];
$email = $_POST['email'];
try{
	$dbh = new PDO ('�f�[�^�x�[�X��',$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
if(empty($name)){
	echo "���O����͂��Ă�������";
}elseif(empty($setpass)){
	echo "�p�X���[�h��ݒ肵�Ă�������";
}elseif(empty($email)){
	echo "���[���A�h���X����͂��Ă�������";
}else{
	$insert = $dbh->prepare("INSERT INTO PreTouroku(name,pass,email) VALUES('$name','$setpass','$email')");
	$exec = $insert->execute();
	if($exec){
		echo "���o�^���������܂����B���[���ɂĔF�؂����肢���܂��B<br/>";
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

//���[���̈���

$to = $email;
$subject = "Account Verification";
$body = "
Thank you for signing up!
 Please click this link to activate your account in 24 hours:
{$url}
";
	
if (mb_send_mail($to, $subject, $body)) {
 	$message = "���[���������肵�܂����B24���Ԉȓ��Ƀ��[���ɋL�ڂ��ꂽURL���炲�o�^�������B";
} 
?>