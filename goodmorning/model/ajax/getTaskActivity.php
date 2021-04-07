<?php
require("../frontend.php");
$db = dbConnect();
$values=taskActivity($_POST["task"]);
$data=$values->fetch();
$donnees=array();
$donnees[0]=$data['Nom_typeActivite'];
$donnees[1]=$data['Impact_TACE'];
$donnees[2]=$data['Facturable'];

echo json_encode($donnees);


