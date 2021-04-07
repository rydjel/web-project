<?php
require("../frontend.php");
$db = dbConnect();
//$taskList=projectTaskList($_POST["project"]);
$taskList=projectTaskListFiltered($_POST["project"],$_POST["collab"],$_POST["initYear"],$_POST["initMonth"],$_POST["lastMonth"],$_POST["lastYear"]);
$list='<option value=""></option>';
while ($data=$taskList->fetch()) {
    $list.='<option value="'.$data['taskID'].'">'.$data['Nom_Tache'].'</option>';
}
echo $list;


