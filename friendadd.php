<!DOCTYPE html> 
<html lang="en"> 
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
	<meta name="description" content="Web Programming :: Assignment 2" />
	<meta name="keywords" content="Web,programming" />
	<meta name="author" content="Connor Nee-Salvador"/>
	<link href= "style1.css" rel="stylesheet"/>
	<title>My Friend System</title>
</head>

<body>
	
	<h1>My Friend System</h1>

	<nav>
		<ul>
		<li><a href="friendlist.php">Friend List</a></li>
		<li><a href="logout.php">Log-Out</a></li>
		</ul>		
	</nav>

	<h2>Add Friends</h2>
	
	<article>



		<?php

			session_start();
			$login_ID = $_SESSION["id"];
			$login_name = $_SESSION["name"];
			$nof = $_SESSION["number"];

			
			
			require_once ("settings.php");

			$conn = @mysqli_connect($host,
				$user,
				$pswd,
				$dbnm
			);

			if (!$conn) {
				echo "<p>Database connection failure</p>";
			} else {

				$countme = "SELECT COUNT(*) FROM myfriends WHERE friend_id1 = '$login_ID'";
				$blabla = mysqli_query($conn, $countme);
				$rowbla = mysqli_fetch_row($blabla);
			    $frencount = $rowbla[0];

			    echo "<p>Logged in as: ". $login_name. ", You currently have ". $frencount. " friends</p>";

			    if (!isset($_GET['startrow']) or !is_numeric($_GET['startrow'])) {
			    	$startrow = 0;
			    } else {
			    	$startrow = (int) $_GET['startrow'];
			    }

				$sql = "SELECT profile_name FROM friends WHERE NOT EXISTS (SELECT * FROM myfriends WHERE friends.friend_id = myfriends.friend_id2 AND myfriends.friend_id1 = '$login_ID') AND profile_name != '$login_name' LIMIT $startrow, 5";
				$queryResult = mysqli_query($conn, $sql);


	       			

				
				echo "<table>"; 

				$row = mysqli_fetch_row($queryResult); 
				while ($row) {
					echo "<tr><td>{$row[0]}</td>";
					echo "<td>"; $mutsql = "SELECT COUNT(c1.friend_id2) FROM myfriends AS c1 INNER JOIN myfriends AS c2 ON c1.friend_id2 = c2.friend_id2 WHERE c1.friend_id1 = '$login_ID' AND c2.friend_id1 = (SELECT friend_id FROM friends WHERE profile_name = '$row[0]');";
	       			$mutualResult = mysqli_query($conn, $mutsql);
	       			$myrow = mysqli_fetch_row($mutualResult);
	       			echo $myrow[0]; echo " Mutual friends</td>";
					echo "<td><form method='post' action='friendadd.php'><input type='hidden' name='addfriend' value='$row[0]'><input type='submit' name='submit_btn' value='Add Friend'></form></td></tr>";
					$row = mysqli_fetch_row($queryResult);
				}
	       		echo "</table>";	

       			if (isset ($_POST['addfriend'])) {
       				$var = $_POST['addfriend'];
       				$sql1 = "INSERT INTO myfriends (friend_id1, friend_id2) VALUES ('$login_ID', (SELECT friend_id FROM friends WHERE profile_name = '$var'))";
					$queryResult = mysqli_query($conn, $sql1);

					$frencount = $frencount + 1;

					$sql2 = "UPDATE friends SET num_of_friends = '$frencount' WHERE friend_id = '$login_ID'";
					$queryResult2 = mysqli_query($conn, $sql2);

					echo "<meta http-equiv='refresh' content='0'>";
					
       			}

	       		$sql3 = "SELECT profile_name FROM friends WHERE NOT EXISTS (SELECT * FROM myfriends WHERE friends.friend_id = myfriends.friend_id2 AND myfriends.friend_id1 = '$login_ID') AND profile_name != 'Connor'";
				$queryResult3 = mysqli_query($conn, $sql3);

				

	       		
	       		$prev = $startrow - 5;
	       		if ($startrow <= mysqli_num_rows($queryResult3) -6) {
		        	echo '<a href="' . $_SERVER['PHP_SELF'] . '?startrow=' . ( $startrow + 5 ) . '">Next</a><br>';
		        }
	       		if ( $prev >= 0 ) {
		            echo '<a href="' . $_SERVER['PHP_SELF'] . '?startrow=' . $prev . '">Previous</a>';
		        }


	       		
				
			}
		?>
	</article>
</body>
</html>
