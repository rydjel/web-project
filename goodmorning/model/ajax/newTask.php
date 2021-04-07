<?php
require("../frontend.php");
$listActivityTypes=getActivityTypes(); //get the list of activities types
$newLine='<tr>
            <td><input type="text" class="form-control" id="taskName" name="taskName"></td>
            <td><select id="typeActivite" class="form-control" name="typeActivite" onchange=getTACEandFact(this.id,"impactTACE","fact");><option value=""></option>';
while ($data=$listActivityTypes->fetch()) {
    $newLine.='<option value="'.$data['ID'].'">'.$data['Nom_typeActivite'].'</option>';
}
$newLine.='</td>
            <td><input type="text"  class="form-control"  id="impactTACE" name="impactTACE" disabled></td>
            <td><input type="checkbox" class="form-control" id="fact" name="fact" disabled></td>
            <td>
            <button type="button" onclick=taskCreateValidation(\'taskName\',\'typeActivite\',\'impactTACE\',\'fact\',\'codeProjet\',\'newTask\',\'codeGen\',\'anneeProjTypeGen\');><span class="glyphicon glyphicon-ok"></span> Valider</button>
            </td>
            </tr>';
echo $newLine;


//<button type="submit" name="newTaskValidation"><span class="glyphicon glyphicon-ok" ></span> Valider</button>