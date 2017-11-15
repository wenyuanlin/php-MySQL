<?php
$user = 'ユーザー名';
$pass = 'パスワード';
$num=$_POST['edit_n'];
try{
	$dbh = new PDO ('パスワード',$user,$pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if($_POST['ed']){
	
		$sql= "SELECT * FROM Toukou_latest WHERE Number = '$num' ORDER BY Number DESC";
		$stmt= $dbh->prepare($sql);
		$exec= $stmt->execute();
			foreach($stmt as $row){
				if(empty($row[4])){
					echo "<div id ='img_div'>";		
					echo "<img src='images/".$row[3]."'>";
					echo "</div>";
					echo "<p>".$row[0]."</p>";
					echo "<p>".$row[1]."</p>";
					echo "<p>".$row[2]."</p>";
					echo "<p>".$row[5]."</p>";
				}else if(empty($row[3])){
					echo "<video width = '400' height = '400' controls>
						<source src = 'videos/".$row[4]."' type='video/mp4'>
						</video>";
					echo "<p>".$row[0]."</p>";
					echo "<p>".$row[1]."</p>";
					echo "<p>".$row[2]."</p>";
					echo "<p>".$row[5]."</p>";
				}else{
					echo "<p>".$row[0]."</p>";
					echo "<p>".$row[1]."</p>";
					echo "<p>".$row[2]."</p>";
					echo "<p>".$row[5]."</p>";
				}
			}
	}

	if(isset($num) && !empty($num)){
		$sql_ed= "SELECT * FROM Toukou_latest WHERE Number = '$num'";
		$stmt_ed= $dbh->prepare($sql_ed);
		$stmt_ed->execute(array(':num'=>$num));
		$editrow=$stmt_ed->fetch(PDO::FETCH_ASSOC);
		extract($editrow);
	}
			
	if($_POST['update']){
	
		$num=$_POST['edit_new'];
		$editcomment = $_POST['comment'];
		$image = $_FILES['profile']['name'];
		$video = $_FILES['profile']['name'];
		$tmp_dir=$_FILES['profile']['tmp_name'];
		$Size=$_FILES['profile']['size'];

		$upload_img = 'images/';
		$upload_vid = 'videos/';
		$imgExt = pathinfo($image,PATHINFO_EXTENSION);
		$vidExt = pathinfo($video,PATHINFO_EXTENSION);
		$image_extensions = array('jpg');
		$video_extensions = array('mp4');

		$picProfile = rand(1, 1000000).".".$imgExt;
		$vidProfile = rand(1, 10000000).".".$vidExt;
		if(in_array($imgExt,$image_extensions)){
			unlink("/../images/" .$editrow['picProfile']);
			move_uploaded_file($tmp_dir, $upload_img.$picProfile);
		
			$sql = "UPDATE Toukou_latest SET Comment= :comment, Image= :image WHERE Number = :num";
			$edition = $dbh->prepare($sql);
			$edition->bindParam(':comment',$editcomment);
			$edition->bindParam(':image',$picProfile);
			$edition->bindParam(':num',$num);
			$exec = $edition->execute();
			if($exec){
				 ?>
                    		<script type="text/javascript">
                        	alert('Successfully Update');
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

		}else if(in_array($vidExt,$video_extensions)){
			unlink("/../videos/" .$editrow['vidProfile']);
			move_uploaded_file($tmp_dir, $upload_vid.$vidProfile);
	
			$sql = "UPDATE Toukou_latest SET Comment= :comment, Video= :video WHERE Number = '$num'";
			$edition = $dbh->prepare($sql);
			$edition->bindParam(':comment',$editcomment);
			$edition->bindParam(':video',$vidProfile);
			$exec = $edition->execute();
			if($exec){
				 ?>
                    		<script type="text/javascript">
                        	alert('Successfully Update');
                        	window.location.href="keijiban.php";
                   		 </script>
                   		 <?php 
			}else
				?>
                		<script type="text/javascript">
                    		alert('Error while update data and iamge');
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
<title>Edit Form</title>
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
<h1 class="text-center">Edit form</h1>
<form action = "edit_form.php" method = post enctype="multipart/form-data">
	number to edit:<br/>
	<input type = "text" name = "edit_n">
	<button type= "submit" name = "ed" value = "edit">Edit</button>
	<br/>
	number to edit:<br/>
	<input type = "text" name = "edit_new" value = "<?php echo $num ?>">
	<br/>
	Name:<br/>
	<input type = "text" name = "name" size = "30" value = "<?php echo $row[1] ?>"/><br/>
	<br/>
	Comment:<br/>
	<textarea name = "comment" cols = "30" rows = "5"><?php echo $row[2]; ?></textarea><br/>
	<br/>
	File:<br/>
	<div>
	<input type = "file" name = "profile">
	</div>
	<small>Only JPG, MP4 files.</small>
	<input type = "submit" name = "update" value = "update"/><br/>
</form>
</div>
<hr style ="border-top: 2px red solid;">
</div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>	
