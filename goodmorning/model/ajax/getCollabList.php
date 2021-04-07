<?php
require("../frontend.php");
$db = dbConnect();
$allCollabs=getCollabs(); // List of all Collabs
$UFList='<option value=""></option>'; // Unfiltred list of collabs
while ($data=$allCollabs->fetch()) {
    $UFList.='<option value="'.$data['ID'].'">'.$data['Nom']." ".$data['Prénom'].'</option>';
}

$collabFilteredList=getPUCollabList($_POST["pu"]); // List of the PU collabs
$FList='<option value=""></option>'; // Filtred List
while ($data=$collabFilteredList->fetch()) {
    $FList.='<option value="'.$data['ID'].'">'.$data['Nom_Prenom'].'</option>';
}
echo $UFList.":".$FList;


