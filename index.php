<?php include("config.php"); 
	if(isset($_POST['btn-add']))
	{
		
		$images=$_FILES['profile']['name'];
		$tmp_dir=$_FILES['profile']['tmp_name'];
		$imageSize=$_FILES['profile']['size'];
		$upload_dir='uploads/';
		$imgExt=strtolower(pathinfo($images,PATHINFO_EXTENSION));
		$valid_extensions=array('jpeg', 'jpg', 'png', 'pdf');
		$picProfile=$images;
		move_uploaded_file($tmp_dir, $upload_dir.$picProfile);
		$stmt=$db_conn->prepare('INSERT INTO fileupload(image) VALUES (:upic)');
		$stmt->bindParam(':upic', $picProfile);
		if($stmt->execute())
		{
			
			echo '<script>              
				setTimeout(function() {
				swal({  
				title: "Success..!",
				text: "File Uploded Successfully",
				type: "success"     
				}, 
				function() 
				{
				window.location = "index.php";
				});
				}, 1000);
			</script>'; 
		}else 
		{
			echo '<script>              
	            setTimeout(function() {
	            swal({  
	            title: "Oops..!",
	            text: "Something went wrong",
	            type: "warning"     
	            }, 
	            function() 
	            {
	            window.location = "index.php";
	            });
	            }, 1000);
	        </script>'; 
		
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="css/sweetalert.css" rel="stylesheet" />
	<link href="css/dist/magnific-popup.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>YouFrame</title>
	<style>
body 
{ font-family: Arial, Helvetica, sans-serif;background-color: #e2e8f0 }


::-webkit-file-upload-button {
	background: #0080FF;
	color: white;
	padding: 0.2rem;
    border:none;
    border-radius: .15rem;
    vertical-align: middle;
    height: 40px;
    width:100px;
	}
	button.button1 a{
	  color: #5C4AC7;
	  border-color: transparent;
	}
	button.button1:hover a{
	  color: white;
	}
	input[type=file]{
      
      color:transparent;
    }
    h3.head{  
	   background-color:#3182ce;
	   height: 32px;
	   color:white;
	   text-align: center;
	}
	.responsive {
  width: 100%;
  max-width: 250px;
  height: 250px;
}
</style>
<script>
function fileValidation() 
{ 
	var fileInput =  document.getElementById('file');
    if(fileInput.value == "")
    {
        fileLabel.innerHTML = "Choose file";
    }
    else
    {
        var theSplit = fileInput.value.split('\\');
        fileLabel.innerHTML = theSplit[theSplit.length-1];
    } 
	var filePath = fileInput.value; 
	// Allowing file type 
	var allowedExtensions = /(\.png|\.jpg|\.jpeg|\.PNG|\.JPG|\.JPEG)$/i; 
	var extension= "PNG, JPG, JPEG" ;
	if (!allowedExtensions.exec(filePath)) 
	{ 
		swal("Check File Type..!", "Kindly upload a valid file format\n"+extension, "warning")
		fileInput.value = ''; 
		fileLabel.innerHTML = "";
		return false; 
	}  
} 
</script>
</head>
<body>
<!-- form insert -->
	<div class="container">
		<div class="add-form">
		
				<h3 class="head">Gallery</h3> 
			
			<form method="post" enctype="multipart/form-data">
				<br>
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-3">
						<input type="file" name="profile"  required="" id="file" onchange="fileValidation()" > <label id="fileLabel"></label>
					</div>
					<div class="col-md-4"><button type="submit" name="btn-add" class="btn btn-success"><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Upload </button></div>
				</div>
				<br>
				
			</form>
		</div>
		<hr style="border-top: 2px red solid;">
	</div>	
<!-- end form insert -->
<!-- view form -->
<div class="container">
	<div class="view-form">
		<div class="row">
		<?php 
			$stmt=$db_conn->prepare('SELECT * FROM fileupload ORDER BY id DESC');
				$stmt->execute();
				if($stmt->rowCount()>0)
				{
					while($row=$stmt->fetch(PDO::FETCH_ASSOC))
					{
						extract($row);
						?>
			<div class="col-md-4" ><br>
			<center>
			<p style="background-color: white"><img  src="uploads/<?php echo $row['image']?>" class="responsive"  width="250" height="250"><br><a class="image-popup-vertical-fit" href="uploads/<?php echo $row['image']?>" ><?php echo $row['image']?></a></center></p>
	
</div>
<!-- The Modal -->

			<?php 

				} } ?>
 			
		</div>
		<?php 
			$stmt=$db_conn->prepare('SELECT * FROM fileupload ORDER BY id DESC');
				$stmt->execute();
				if($stmt->rowCount()>0)
				{ ?>
<footer>
		<h3 class="head">Fullstack Challenge - 2020</h3> 		
</footer>
<?php }  ?>
</div>
	
</div>

<!-- end view form -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script src= "js/jquery.min.js"></script> 
<script src="js/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
<script src="js/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>
</body>
</html>
