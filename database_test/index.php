<html>
<head>
	<title></title>

	<?php 

		include 'connect.php';
		
		$result = mysql_query("SELECT * FROM users");

		while($row = mysql_fetch_row($results)){
			echo $row[0] . ': ' . $row[1] ;
		}

	 ?>


</head>
<body>
	Hej 

</body>
</html>