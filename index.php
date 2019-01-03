<!DOCTYPE html>
<html>
<link rel="stylesheet" href="myStyle.css">
<body text="white">


<?php
//session_register();
session_start();
$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","abdullah.ozer","z7qpck6l","abdullah_ozer");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

//On page 1
$_SESSION['mySqlConnection'] = $con;




$firstname = $lastname = $errorMsg = "";
$goToPage = "index.php";//"/info_page.php";

if(isset($_POST['passwordF']))
{
	//$sqlFirstName = $_POST['passwordF'];
	$sql = "SELECT sid FROM student WHERE password='";
	$sql .= $_POST['passwordF'];
	$sql .= "' AND sid='";
	$sql .= $_POST['studentIdF'];
	$sql .= "'";
	$result = mysqli_query($con, $sql);
	
	$resFirst = $result->fetch_assoc();
	//var_dump($resFirst);
	//echo count($resFirst);
	echo $resFirst['sid'];
	if(!is_null($resFirst['sid']))
	{
		$goToPage = 'info_page.php';
		/////$_SESSION['studentFirstName'] = $_POST['passwordF'];
		$_SESSION['studentId'] = $_POST['studentIdF'];
		header('Location: info_page.php');
	}	
	else
		echo "<script type='text/javascript'> alert('Wrong ID password combination.') </script>";
	//print_r($resFirst);
}


/*
$sqlFirstName = $_POST['passwordF'];
//$sqlFirstNameE = json_encode($sqlFirstName);
//$pass = json_encode($_POST["lastname"]);
$sql = "SELECT sid FROM student WHERE name=";
$sql .=$sqlFirstName;//$sqlFirstNameE;
$result = mysqli_query($con, $sql);
echo $result;
*/

/*
$dom = new DOMDocument();
$dom->loadHTML("index.php");
//$dom->validate();
$div = $dom->getElementById("firstnameID");
echo is_null($div);

//$attr = $div->getAttribute('value');
//echo $div;
*/
?>




<?php


/*
$sqlFirstName = $_POST["firstname"];
$sqlFirstNameE = json_encode($sqlFirstName);
$pass = json_encode($_POST["lastname"]);
$sql = "SELECT sid FROM student WHERE name=";
$sql .=$sqlFirstNameE;
$result = mysqli_query($con, $sql);
*/
//echo $firstname;

//	background:none;
//	border:none;
//	outline:none;
?>

<div class="container">

<form action=<?php echo 'index.php'?> method="post">

Student ID:<br>
<div class="tbox">
<input type="text" name="studentIdF" value="21000002">
</div>
<br><br>


Password:<br>
<div class="tbox">
<input type="password" name="passwordF" value="alipassword">
</div>

<br>
<input class="btn" type="submit" value="LOG IN">

</form>
</div>

<p></p>



</body>
</html>
