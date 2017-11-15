<?php
$user = "ユーザー名";
$password = "パスワード";

try{
	$dbh=new PDO("データベース名",$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "CREATE TABLE IF NOT EXISTS Touroku
		(
		id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		name varchar(30) NOT NULL,
		pass varchar(30) NOT NULL,
		email varchar(50) NOT NULL,
		flag TINYINT(1) NOT NULL DEFAULT 1
		)";
	$stmt=$dbh->exec($sql);

}catch (PDOException $e){
	exit('Error occurred'.$e->getMessage());
}
?>