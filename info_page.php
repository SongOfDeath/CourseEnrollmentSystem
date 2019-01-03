
<html>
<link rel="stylesheet" href="myStyle.css">
  <body>
<?php
session_start();
//On page 2
//$con = $_SESSION['mySqlConnection'];
$studentFirstName = $_SESSION['studentFirstName'];
$studentId = $_SESSION['studentId'];
/////////////////////

$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","abdullah.ozer","z7qpck6l","abdullah_ozer");

// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

echo '<br> </br>';
echo 'Student Name:';
echo $studentFirstName;
echo '<br> </br>';
echo 'Student ID:';
echo $studentId;
echo '<br> </br>';
echo '<br> </br>';


$sql = "SELECT * FROM course, enroll, student WHERE student.sid = enroll.sid AND enroll.cid = course.cid AND student.sid='";
$sql .= "$studentId'";


$result = mysqli_query($con, $sql);

$applicationCount = 0;
echo '<h2>CURRENTLY TAKEN COURSES</h2>';
echo '<br> </br>';
while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
    //printf("\n<br />\n<br />\n<br /> ID: %s  Name: %s  Total Quota: %s", $row[0], $row[1], $row[2]);
	echo "course ID:",  $row[0], '<br> </br>'; 
	echo "course Name:",  $row[1], '<br> </br>';
	echo "Total Quota:", $row[2], '<br> </br>';
	$applicationCount = $applicationCount +1;

	
	echo '<form action="info_page.php" method="post"> ';
	echo '<input class="btn" type="submit" ';
	echo 'name = "';
	echo $row[0];
	echo '" value="Drop this course"> ';
	echo '<input type="hidden" name="deletedCid" id="hiddenField" value=';
	echo $row[0];
	echo ' ?>';
	echo ' </form> ';
}


if(isset($_POST['deletedCid']))
{
	echo $_POST['deletedCid'];

	$sql = "DELETE FROM enroll WHERE cid = '";
	$sql .= $_POST['deletedCid'];
	$sql .= "' AND sid = '";
	$sql .= $studentId;
	$sql .= "'";

	mysqli_query($con, $sql);
	header("Refresh:0");
}

if(isset($_POST['courseIdApplyF']))
{
	//GET QUOTA FROM A course
	$sql = "SELECT quota FROM course WHERE cid='";
	$sql .= $_POST['courseIdApplyF'];
	$sql .= "';";
	$resultAdd = mysqli_query($con, $sql);
	
	while ($quota = mysqli_fetch_array($resultAdd, MYSQLI_NUM)) {
		$quotaVar = $quota[0];
    //printf("\n<br />\n<br />\n<br /> ID: %s  Name: %s  Quota: %s", $row[0], $row[1], $row[2]);
	}
	//GET NUMBER OF APPLICATIONS TO A course
	$sql = "SELECT sid FROM enroll WHERE cid='";
	$sql .= $_POST['courseIdApplyF'];
	$sql .= "';";
	$resultAdd = mysqli_query($con, $sql);
	$noOfApplications =0;
	while ($rowApp = mysqli_fetch_array($resultAdd, MYSQLI_NUM))
	{
	$noOfApplications = $noOfApplications+1;
	}
	if($applicationCount>6)
		echo "<script type='text/javascript'> alert('CANNOT enroll TO MORE THAN 6 courses.') </script>";
	else if($noOfApplications>=$quotaVar)
		echo "<script type='text/javascript'> alert('NOT ENOUGH QUOTA LEFT.') </script>";
	else
	{
	$sql = "INSERT INTO enroll (sid,cid) ";
	$sql .= "SELECT * FROM (SELECT '";
	$sql .= $studentId;
	$sql .= "','";
	$sql .= $_POST['courseIdApplyF'];
	$sql .= "') AS tmp ";
	$sql .= "WHERE NOT EXISTS (SELECT sid FROM enroll WHERE sid ='";
	$sql .= $studentId;
	$sql .= "' AND cid ='";
	$sql .= $_POST['courseIdApplyF'];
	$sql .= "')";
	}

	


/*
INSERT INTO table_listnames (name, address, tele)
SELECT * FROM (SELECT 'name1', 'add', '022') AS tmp
WHERE NOT EXISTS (
    SELECT name FROM table_listnames WHERE name = 'name1'
) LIMIT 1;
*/

	mysqli_query($con, $sql);
	header("Refresh:0");
}//IF ISSET POST courseApplyIdF

echo '<br> </br>';
echo '<h2>COURSES IN CURRICULUM</h2>';
echo '<br> </br>';
///////////////////////
//LIST COURSES TO APPLY
$sql = "SELECT DISTINCT cid, cname, quota FROM course";
//$sql .= "$studentId'";

$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
{
    //printf("\n<br />\n<br />\n<br /> course ID: %s course Name: %s  Total Quota: %s", $row[0], $row[1], $row[2]);
	echo "course ID:",  $row[0], '<br> </br>'; 
	echo "course Name:",  $row[1], '<br> </br>';
	echo "Total Quota:", $row[2], '<br> </br>';
	
	
	echo '<form action="info_page.php" method="post"> ';
	echo '<input class="btn" type="submit" ';
	echo 'name = "';
	echo $row[0];
	echo '" value="Enroll in this course"> ';
	echo '<input type="hidden" name="courseIdApplyF" id="hiddenField" value=';
	echo $row[0];
	echo ' ?>';
	echo ' </form> ';
	echo '<br> </br>';
}

echo "<script type='text/javascript'> console.log(`step1`) </script>";


/////////////////////////

if(isset($_POST['courseIdForSearch']))
{
	$sql = "SELECT enroll.sid, student.sname FROM enroll,course,student WHERE course.cid = enroll.cid AND student.sid = enroll.sid AND course.cid = '";
	$sql .= $_POST['courseIdForSearch'];
	$sql .= "'";
	$result = mysqli_query($con, $sql);

	//echo '<h1>STUDENTS</h1>';
	echo '<br> </br>';
	
while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
    //printf("\n<br />\n<br />\n<br /> ID: %s  Name: %s  Total Quota: %s", $row[0], $row[1], $row[2]);
	echo "Student ID:",  $row[0], ', ';
	echo "Student Name:",  $row[1], '<br> </br>';
	//echo "course Name:",  $row[1], '<br> </br>';
	//echo "Total Quota:", $row[2], '<br> </br>';
	//$applicationCount = $applicationCount +1;

	
	//echo '<form action="info_page.php" method="post"> ';
	//echo '<input class="btn" type="submit" ';
	//echo 'name = "';
	//echo $row[0];
	//echo '" value="Drop this course"> ';
	//
	//echo '<input type="hidden" name="deletedCid" id="hiddenField" value=';
	//echo $row[0];

}

	//mysqli_query($con, $sql);
	//header("Refresh:0");
}
//$sql = "SELECT student.sid FROM course, enroll, student WHERE student.sid = enroll.sid AND enroll.cid = course.cid AND course.cid=102";




echo '<h2>SEARCH</h2>';

/////////////////////////



?>



<form action=<?php echo 'info_page.php'?> method="post">

<div class="tbox">
Search students with course ID:

<input type="text" name="courseIdForSearch" value="C102">
</div>

<br></br>
<input class="btn" type="submit" value="search students">
</form> 

<a href="/index.php"><h2>Logout</h2></a>
  </body>
</html>