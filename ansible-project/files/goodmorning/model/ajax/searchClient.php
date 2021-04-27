<?php
/* require('../frontend.php');
$db = dbConnect(); */
$connect = mysqli_connect("localhost", "root", "M@@mstm7", "CIS");
$request = mysqli_real_escape_string($connect, $_POST["query"]);
$query = "
 SELECT * FROM Client WHERE NomClient LIKE '%".$request."%'
";

$result = mysqli_query($connect, $query);

$data = array();

if(mysqli_num_rows($result) > 0)
{
 while($row = mysqli_fetch_assoc($result))
 {
  $data[] = $row["NomClient"];
 }
 echo json_encode($data);
}

