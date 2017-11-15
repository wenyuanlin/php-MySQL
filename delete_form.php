<?php
	session_start();
?>

<?php
$user = 'ユーザー名';
$pass = 'パスワード';



try{
		$dbh = new PDO ('データベース名',$user,$pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
		if($_POST['del'] && !empty($_POST['del'])){
			if($del_num = $_POST['filenum']){
				$sql_d = "DELETE FROM Toukou_latest WHERE Number = $del_num";
				$result = $dbh->prepare($sql_d);
				$exec = $result->execute();
				if($exec){
					?>
                    			<script type="text/javascript">
                        		alert('Successfully Deleted');
                        		window.location.href="keijiban.php";
                   		 	</script>
                   		 	<?php 
				}else
						?>
                			<script type="text/javascript">
                    			alert('Error');
                    			window.location.href="edit_form.php";
                			</script>
               			 	<?php 
			}
		}
}catch (PDOException $ex){
	exit('Error occurred'.$ex->getMessage());
}
?>
<html>
<head>
<title>Delete Form</title>
<style type="text/css">
	.edit-form img{
		width: 150px;
		height: 100px;
	}
</style>
</head>
<body>
<div class="container">
<div class="edit-form">
<h1 class="text-center">Delete form</h1>
<form action = "delete_form.php" method = post>
	number to delete:
	<input type = "number" name = "filenum">
	<button type= "submit" name = "del" value = "delete">Delete</button>
				
</form>
</div>
<hr style ="border-top: 2px red solid;">
</div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>	