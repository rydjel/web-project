<?php
require("../frontend.php");
$db = dbConnect();
$query=$db->query('select Region from ProductionUnit where Nom="'.$_POST["field"].'"');
$donnee=$query->fetch();
$region=$donnee["Region"];

//$region= $donnee["Region"];

echo json_encode($region);


