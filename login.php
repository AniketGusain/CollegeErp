<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
ob_end_flush();
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $_SESSION['system']['name'] ?></title>
 	

<?php include('../erp/header/header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>

</head>
<style>
	body{
		width: 100%;
	    height:100%;
	    position: fixed;
	    top: 10px;
	    left: 10px;
	}
	#main{
		width:100%;
		height: calc(100%);
		display: flex;
	}

</style>

<body class="bg-warning">


  <main id="main" >
  	
  		<div class="container py-5 h-100">
		<h3 class="text-success text-center"><b><?php echo $_SESSION['system']['name'] ?></b></h3>
  		<div id="login-center" class="bg-danger row justify-content-center">
  			<div class="card col-md-4">
  				<div class="card-body p-md-5 mx-md-4">
				  <div class="text-center">
		
                  <h4 class="mt-1 mb-5 pb-1">Please enter your ID</h4>
                </div>	
				<form id="enter" >
  						<div class="form-group">
  							<label for="username" class="control-label">Username</label>
  							<input type="text" id="username" name="username" class="form-outline">
  						</div>
  						<div class="form-group">
  							<label for="password" class="control-label">Password</label>
  							<input type="password" id="password" name="password" class="form-outline">
  						</div>
  						<center><button class="btn btn-primary btn-block mb-4">Login</button></center>
  					</form>

  				</div>
  			</div>
  		</div>
  		</div>
  </main>
</body>
<script>
	$('#enter').submit(function(e){
		e.preventDefault()
		$('#enter button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#enter button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=home';
				}else{
					$('#enter').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#enter button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	
</html>