<?php
require("../frontend.php");
$db = dbConnect();
$query=$db->query('select Date_Fin from MarketUnit where Nom="'.$_POST["field"].'"');
$donnee=$query->fetch();
$date = $donnee["Date_Fin"];
echo json_encode($date);


