<?php
require("../frontend.php");
$db = dbConnect();
$collabList=getAvailableCollabToBeManagers($_POST["pu"]);
$list='<option value=""></option>';
while ($data=$collabList->fetch()) {
    $list.='<option value="'.$data['idCollab'].'">'.$data['Nom'].' '.$data['Prénom'].'</option>';
}
echo $list;


