<?php
$user = 'ユーザー名';
$pass = 'パスワード';
try{
	$dbh = new PDO ('データベース名',$user,$pass);
	if($dbh == null){
		print('connection failed');
	}else{
		print('connection succeed');
	}
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$sql = $dbh->query("SELECT * from PreTouroku");
	foreach($sql as $row){
		echo "<br/>";
		echo "$row[0] - $row[1] - $row[2] - $row[3]<br>";
	}
}catch (PDOException $ex){
	exit('Error occurred'.$ex->getMessage());
}
?>