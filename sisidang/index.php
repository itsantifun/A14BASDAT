<?php
	session_start();
	
	// Setup db connection
	//include "database.php";
	
	// Simpan session ketika login valid
	$resp = "";
	if(isset($_POST["username"])){
		if(login($_POST["username"], $_POST["password"])){
			$resp = "login success";	
			$_SESSION["userlogin"] = $_POST["username"];
		} else {
			$resp = "invalid login";
			header("Location: index.php");
		}
	}
	
	// Redirect ke dashboard.php ketika session masih ada
	if (isset($_SESSION["userlogin"])) {
		header("Location: dashboard.php");
	}
	
	// Fungsi login
	function login($user, $pass){		
		$success = false;
		if($user == "admin" && $pass == "admin"){
			$_SESSION["username"] = $user;
			$_SESSION['role'] = "ADMIN";
			$_SESSION["nama"] = "Admin";
			$success = true;
			return $success;
		}


		//$conn = connectDB();
		include "database.php";
		//   query the database to return username and password existence
		$sqlMhs = "SELECT username, password, nama FROM MAHASISWA WHERE username='$user' and password='$pass'";
		$sqlDosen = "SELECT username, password FROM DOSEN WHERE username='$user' and password='$pass'";
		$resultMhs = pg_query($conn, $sqlMhs);
		$resultDosen = pg_query($conn, $sqlDosen);
		if (!$resultMhs OR !$resultDosen) {
			die("Error in SQL query: " . pg_last_error());
		}
		
		if (pg_num_rows($resultMhs) != 0) {
			$field = pg_fetch_array($resultMhs);
			$_SESSION["username"] = $user;
			$_SESSION["role"] = "MHS";
			$_SESSION["nama"] = $field[2];
			$success = true;
		}
		
		if (pg_num_rows($resultDosen) != 0) {
			$field = pg_fetch_array($resultDosen);
			$_SESSION["username"] = $user;
			$_SESSION["role"] = "DOSEN";
			$_SESSION["nama"] = $field[2];
			$success = true;
		}
		
		pg_close($conn);
		return $success;		
	}
	
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Login sisidang</title>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link href="http://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
  <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"/>
  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
  
  <style>
    body img{
      width: 100%; /* Set width to 100% */
      height: 100%;
      margin: auto;
    }
    .row{
        padding-top: 10%; 
        padding-left: 10%;
    }
    .form-top {
        width: 500px;
        overflow: hidden;
        padding: 0 0px 10px 15px;
        background: #fff;
        -moz-border-radius: 4px 4px 0 0; -webkit-border-radius: 4px 4px 0 0; border-radius: 4px 4px 0 0;
        text-align: left;
    }
    .form-bottom {
        width: 400px;
        padding: 2px 2px 3px 2px;
        background: #fff;
        -moz-border-radius: 0 0 4px 4px; -webkit-border-radius: 0 0 4px 4px; border-radius: 0 0 4px 4px;
        text-align: left;
    }
    .form-bottom form button.btn {
        width: 30%;
    }
    .form-bottom form  .input-error {
        border-color: #4aaf51;
    }
  </style>
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>

<body style="background-image: url('https://img.okezone.com/content/2011/07/15/373/480422/2H1pGCGuwx.jpg');">
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a href="./"><alt="Logo" width="150px" height="50px" class="navbar-brand">home</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li data-toggle="modal" data-target="#myModal"><a href="#">Login</a></li>
      </ul>
    </div>
  </div>
</nav>



<div class="row" id="login">
  <div class="col-sm-6 col-sm-offset-3 form-box">
    <div class="form-top">
      <section class="container">
          
          <h1>Login</h1>
          <div class="form-bottom">
            <form id='#defaultForm' method="post" action="index.php">
              <div class="form-group">
                <p><input type="text" name="username" class="form-control input" value="" size="50" placeholder="Username"></p>
                <p><input type="password" name="password" class="form-control input" value="" size="50" placeholder="password"></p>
              </div>
              <p>

              </p>
              <p><input class="btn btn-danger" type="submit" name="commit" value="login"></p>
            </form>
          </div>
      </section>
    </div>
  </div>
</div>
</script>
</body>
</html>