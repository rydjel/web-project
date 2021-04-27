<?php
require("../frontend.php");
$db = dbConnect();

if ($_POST["inOut"]=='in') {
    $collabList=getManagerCollabListIN($_POST["idManager"]);
}
elseif ($_POST["inOut"]=='out') {
    $collabList=getManagerCollabListOUT($_POST["idManager"]);
}

$list='<option value="Sélectionner un Collaborateur ..." selected>Sélectionner un Collaborateur ...</option>';
while ($data=$collabList->fetch()) {
    $list.='<option value="'.$data['ID'].'">'.$data['Nom'].' '.$data['Prénom'].'</option>';
}
echo $list;


