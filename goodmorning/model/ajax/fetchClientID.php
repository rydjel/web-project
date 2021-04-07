<?php
require("../frontend.php");
$db = dbConnect();
$query=$db->query('select ID from Client where NomClient="'.$_POST["field"].'"');
$donnee=$query->fetch();
$idClient = $donnee["ID"];
echo json_encode($idClient);

//echo json_encode($marketUnit);
//echo '<input type="text" class="form-control input-lg" value="'.$donnee["Nom"].'" >';

//echo "value='Test'";

