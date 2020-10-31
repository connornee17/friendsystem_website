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

	<h2>Sign-Up</h2>

	<article>
		<form action="signup.php" method="post">
			<p>Enter E-mail:<input type="text" name="email" value="<?php if (isset($_POST['email'])) { echo $_POST['email']; } ?>"></p>
			<p>Enter Profile Name:<input type="text" name="name" value="<?php if (isset($_POST['name'])) { echo $_POST['name']; } ?>"></p>
			<p>Enter Password:<input type="password" name="password">
			<p>Confirm Password:<input type="password" name="conpassword"></p>
				
			<input type= "submit" value="ENTER"/> 
			<input type= "reset" value="RESET"/>
		</form>

		<?php 
			if (isset ($_POST["email"]) && isset ($_POST["name"]) && isset ($_POST["password"]) && isset ($_POST["conpassword"])) {

				$email = $_POST["email"];
				$name = $_POST["name"];
				$password = $_POST["password"];
				$confirm = $_POST["conpassword"];

				$month = date('m');
				$day = date('d');
				$year = date('Y');
				$date = $year . '-' . $month . '-' . $day;

				$numfriends = 0;

				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					echo "<p>You have entered an invalid Email</p>";
				} else {
					if ($password != $confirm) {
						echo "<p>Passwords must match</p>";
					} else {
						if (preg_match("/^[a-zA-Z]+$/", $name)) {
							if (preg_match("/^[a-zA-Z0-9]+/", $password)) {
								require_once ("settings.php");
								$conn = @mysqli_connect($host,
									$user,
									$pswd,
									$dbnm
								);

								if (!$conn) {
									echo "<p>Database connection failure</p>";
								} else {
									$result = mysqli_query($conn, "SELECT friend_id FROM friends WHERE friend_email = '$email'");
									if(mysqli_num_rows($result) == 0) {
										$addtotable = "INSERT INTO friends (friend_email, password, profile_name, date_started, num_of_friends)
															VALUES ('$email', '$password', '$name', '$date', 'numfriends')";
										$addquery = mysqli_query($conn, $addtotable);

										$get_ID = "SELECT friend_id FROM friends WHERE friend_email = '$email'";
										$IDresult = mysqli_query($conn, $get_ID);
										$row = mysqli_fetch_row($IDresult);
										$login_ID = $row[0];

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
										header("location:friendadd.php");


									} else {
										echo "<p>Email already exists in database!</p>";
									}
								}

								



							} else {
								echo "<p>Please enter a valid password</p>";
							}
						} else {
							echo "please enter a valide user name</p>";
						}
					}
				}
			} else {
				echo "<p>Please fill out the whole form</p>";
			}
		?>

	</article>

</body>
</html>