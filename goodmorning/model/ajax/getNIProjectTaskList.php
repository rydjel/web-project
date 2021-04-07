<?php
require("../frontend.php");
$db = dbConnect();
$year=$_POST["year"];
$initMonth=$_POST["initMonth"];
$lastMonth=$_POST["lastMonth"];
$lastYear=$_POST["lastYear"];
$idCollab=$_POST['collab'];
$project=$_POST['project'];
$taskList=noneInternprojectTaskListFiltered($project,$idCollab,$year,$initMonth,$lastMonth,$lastYear);
$list='<option value=""></option>';
while ($data=$taskList->fetch()) {
    $list.='<option value="'.$data['taskID'].'">'.$data['Nom_Tache'].'-'.$data['TJM'].'</option>';
}
echo $list;


