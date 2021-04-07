<?php
require("../frontend.php");
$db = dbConnect();
$query=$db->query('select Date_Debut from MarketUnit where Nom="'.$_POST["field"].'"');
$donnee=$query->fetch();
$date = $donnee["Date_Debut"];
echo json_encode($date);

//echo json_encode($marketUnit);
//echo '<input type="text" class="form-control input-lg" value="'.$donnee["Nom"].'" >';

//echo "value='Test'";

