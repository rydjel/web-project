<?php
require("../frontend.php");
$db = dbConnect();
$query=$db->query('select MarketUnit.Nom from Client inner join MarketUnit on Client.ID_MarketUnit=MarketUnit.ID where NomClient="'.$_POST["field"].'"');
$donnee=$query->fetch();
$marketUnit = $donnee["Nom"];
echo json_encode($marketUnit);

//echo json_encode($marketUnit);
//echo '<input type="text" class="form-control input-lg" value="'.$donnee["Nom"].'" >';

//echo "value='Test'";

