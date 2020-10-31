<!DOCTYPE html> 
<html lang="en"> 
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
	<meta name="description" content="Web Programming :: Assignment 2" />
	<meta name="keywords" content="Web,programming" />
	<meta name="author" content="Connor Nee-Salvador"/>
	<link href= "style.css" rel="stylesheet"/>
	<title>My Friend System</title>
</head>
<body>

	<h1>My Friend System Assignment Home Page</h1> 

	<nav>
		<ul>
		<li><a href="index.php">Home</a></li>
		<li><a href="signup.php">Sign-Up</a></li>
		<li><a href="login.php">Log-In</a></li>
		<li><a href="about.php">About</a></li>
		</ul>		
	</nav>

	<h2>Log-In</h2>


	<article>
		<form action="login.php" method="post">
			<p>Enter E-mail:<input type="text" name="email" value="<?php if (isset($_POST['email'])) { echo $_POST['email']; } ?>"></p>
			<p>Enter Password:<input type="password" name="password">

				
			<input type= "submit" value="ENTER"/> 
			<input type= "reset" value="RESET"/>
		</form>

		<?php 
			if (isset ($_POST["email"]) && isset ($_POST["password"])) {


				$email = $_POST["email"];
				$password = $_POST["password"];

				require_once ("settings.php");
				$conn = @mysqli_connect($host,
					$user,
					$pswd,
					$dbnm
				);

				if (!$conn) {
					echo "<p>Database connection failure</p>";
				} else {
					$checkemail = mysqli_query($conn, "SELECT friend_id FROM friends WHERE friend_email = '$email'");
					if(!mysqli_num_rows($checkemail) == 0) {
						$query1 = mysqli_query($conn, "SELECT password FROM friends WHERE friend_email = '$email'");
						$row = mysqli_fetch_row($query1);
						$checkpassword = $row[0];
						if ($checkpassword == $password) {

							$get_ID = "SELECT friend_id FROM friends WHERE friend_email = '$email'";
							$IDresult = mysqli_query($conn, $get_ID);
							$row1 = mysqli_fetch_row($IDresult);
							$login_ID = $row1[0];

							$get_name = "SELECT profile_name FROM friends WHERE friend_email = '$email'";
							$nameresult = mysqli_query($conn, $get_name);
							$row2 = mysqli_fetch_row($nameresult);
							$login_name = $row2[0];

							$get_num = "SELECT num_of_friends FROM friends WHERE friend_email = '$email'";
							$numresult = mysqli_query($conn, $get_num);
							$row3 = mysqli_fetch_row($numresult);
							$nof = $row3[0];

							session_start(); 
							$_SESSION["id"] = $login_ID; 
							$_SESSION["name"] = $login_name;
							$_SESSION["number"] = $nof;
							header("location:friendlist.php");
							

						} else {
							echo "<p>Password is incorrect, please check again</p>";
						}

					} else {
						echo "<p>Email does not exist, please check again</p>";
					}
				}


			}

				
		?>

	</article>

</body>
</html>