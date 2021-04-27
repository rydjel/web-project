<?php
require("../frontend.php");
$db = dbConnect();
$projectList=projectList($_POST["Client"]);
$list='<option value=""></option>';
while ($data=$projectList->fetch()) {
    $list.='<option value="'.$data['ID'].'">'.$data['Titre'].'</option>';
}
echo $list;


