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
		<li><a href="login.php">Log-in</a></li>
		<li><a href="about.php">About</a></li>
		</ul>		
	</nav>

	<h2>Home</h2>

	<article>
		<p>Name: Connor Nee-Salvador</p>
		<p>Student ID: 102061410</p>
		<p>Email: <a href='mailto:102061410@student.swin.edu.au'>102061410@student.swin.edu.au</a></p>
		<br>
		<p>I declare that this assignment is my individual work. I have not worked collaboratively nor have I copied from any other student’s work or from any other source</p>
	
		<?php
			require_once ("settings.php");
			$conn = @mysqli_connect($host,
				$user,
				$pswd,
				$dbnm
			);

			if (!$conn) {
				echo "<p>Database connection failure</p>";
			} else {

				$mytable = "CREATE TABLE IF NOT EXISTS friends (
									friend_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
									friend_email VARCHAR(50) NOT NULL,
									password VARCHAR(20) NOT NULL,
									profile_name VARCHAR(30) NOT NULL,
									date_started DATE NOT NULL,
									num_of_friends INT unsigned
								)";
				$mytable1 = "CREATE TABLE IF NOT EXISTS myfriends (
									friend_id1 INT NOT NULL,
									friend_id2 INT NOT NULL,
									PRIMARY KEY (friend_id1, friend_id2)
								)";

				$myData = "INSERT INTO friends (friend_id, friend_email, password, profile_name, date_started, num_of_friends)VALUES (1, 'connor@gmail.com', 'cookies11', 'Connor', NOW(), 2), (2, 'kanga@hotmail.com', 'poopoo', 'Kangaroo', NOW(), 2), (3, 'Bob@gmail.com', 'bob11', 'Bobby', NOW(), 2), (4, 'freddy@live.com.au', 'freddygood', 'Fred', NOW(), 2), (5, 'poopy@gmail.com', 'poop', 'pooy', NOW(), 2), (6, 'Samm@gmail.com', 'SAMMY', 'sammy', NOW(), 2), (7, 'Bread@hotmail.com', 'loaf11', 'Bread', NOW(), 2), (8, 'bruh@windows.com', 'peepee', 'Cookie', NOW(), 2), (9, 'boomboom@gmail.com', 'birdy', 'Bird', NOW(), 2), (10, 'doggo@live.com.au', 'kitten', 'Doggie', NOW(), 2)";

				$myData1 = "INSERT INTO myfriends (friend_id1, friend_id2) VALUES (1, 2), (1, 5), (2, 3), (2, 8), (3, 3), (3, 1), (4, 7), (4, 10), (5, 8), (5, 4), (6, 4), (6, 7), (7, 9), (7, 1), (8, 3), (8, 7), (9, 5), (9, 4), (10, 3), (10, 2)";
				
				$makeTable = mysqli_query($conn, $mytable);
				$makeTable1 = mysqli_query($conn, $mytable1);

				$makeData = mysqli_query($conn, $myData);
				$makeData1 = mysqli_query($conn, $myData1);



				echo "<p>Successfuly created new tables and populated data</p>";

				mysqli_close($conn);
			}
		?>
	</article>

</body>
</html>