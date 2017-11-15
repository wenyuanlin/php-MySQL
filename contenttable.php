<?php
$user = "ユーザー名";
$password = "パスワード";

try{
	$dbh=new PDO("データベース名",$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "CREATE TABLE IF NOT EXISTS Toukou_latest
		(
		Number INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		Name varchar(30) NOT NULL,
		Comment varchar(30) NOT NULL,
		Image varchar(200) NOT NULL,
		Video varchar(10000) NOT NULL,
		created_at TIMESTAMP
		)";
	$stmt=$dbh->exec($sql);

}catch (PDOException $e){
	exit('Error occurred'.$e->getMessage());
}
?>