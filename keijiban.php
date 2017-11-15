<?php
	session_start();
?>
<?php
$user = 'ユーザー名';
$pass = 'パスワード';
try{
	$dbh = new PDO ('データベース名',$user,$pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
/*投稿判定*/
	if(isset($_POST['upload'])){
		$image = $_FILES['profile']['name'];
		$video = $_FILES['profile']['name'];
		$tmp_dir=$_FILES['profile']['tmp_name'];
		$name = $_POST['name'];
		$comment = $_POST['comment'];
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
			move_uploaded_file($tmp_dir, $upload_img.$picProfile);
			$sql = "INSERT INTO Toukou_latest(Name,Comment,Image) VALUES(:uname, :ucom, :upic)";
			$result = $dbh->prepare($sql);
			$result->bindParam(':uname', $name);
			$result->bindParam(':ucom', $comment);
			$result->bindParam(':upic', $picProfile);
			$result->execute();
			
		}else if(in_array($vidExt,$video_extensions)){
			move_uploaded_file($tmp_dir, $upload_vid.$vidProfile);
			$sql = "INSERT INTO Toukou_latest(Name,Comment,Video) VALUES(:uname, :ucom, :uvid)";
			$result = $dbh->prepare($sql);
			$result->bindParam(':uname', $name);
			$result->bindParam(':ucom', $comment);
			$result->bindParam(':uvid', $vidProfile);
			$result->execute();
		}
		$_SESSION['name'] = ":uname";
	}

}catch (PDOException $ex){
	exit('Error occurred'.$ex->getMessage());
}
?>

<html>
<megacharset = "utf-8">
<head> 
<div class="container">
        <div class="add-form">
            <h1 class="text-center">簡易レビュー掲示板</h1>
<style type="text/css">
	form{
		width: 50%;
		margin: 20px auto;
	}
	form div{
		margin-top: 5px;
	}
	#img_div{
		width: 80%;
		padding: 5px;
		margin: 15px auto;
		border: 1px solid #cbcbcb;
	}
	#img_div:after{
		content: "";
		display: block;
		clear: both;
	}
	img{
		float: left;
		margin: 5px;
		width: 300px;
		height: 140px;
	}
</style>
 <?php include 'css.html'; ?>
</head>
<body>

<?php
$sql_select = $dbh->prepare("SELECT * from Toukou_latest ORDER BY Number DESC ");
$sql_select->execute();
		foreach($sql_select as $row){
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
?>
<form action = "keijiban.php" method = "post" enctype = "multipart/form-data">
	<br/>
	<br/>
	<br/>
	Name:<br/>
	<input type = "text" name = "name" size = "30" value = "<?php echo $_SESSION['name'] ?>"/><br/>
	<br/>
	Comment:<br/>
	<textarea name = "comment" cols = "30" rows = "5"></textarea><br/>
	<br/>

	<br/>
	File:<br/>
	<div>
	<input type = "file" name = "profile">
	</div>
	<small>Only JPG, MP4 files.</small>
	<input type = "submit" name = "upload" value = "upload"/><br/>

	<button type= "submit" name = "del" value = "delete">Delete</button>
	<button type = "submit" name = "ed" value = "save">Edit</button>
	<button type = "submit" name = "logout" value = "logout">Logout</button>
	<a href="keijiban.php"><button class="button button-block"/>Top</button></a>
</form>

</body>
</html>
<?php
	if($_POST['ed']){
		header("Location:edit_form.php");
	}
	if($_POST['del']){
		header("Location:delete_form.php");
	}
	if($_POST['logout']){
		header("Location:login.php");
	}
?>
