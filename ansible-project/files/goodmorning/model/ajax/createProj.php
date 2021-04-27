<?php
require("../frontend.php");
//$db = dbConnect();
$pu=$_POST['pu'];
$codeProjet=$_POST['codeProjet'];
$titreProjet=$_POST['titreProjet'];
$Commercial=$_POST['Commercial'];
$rfa=$_POST['rfa'];
$client=$_POST['client'];
$typeProjet=$_POST['typeProjet'];
$VolJourVendu=$_POST['VolJourVendu'];
$BudgetVendu=$_POST['BudgetVendu'];
if ($_POST['codeGen']=='true') {
    $codeGen=1;
}else {
    $codeGen=0;
}

$tbody=""; // Table des tâches est vide initialement

//Liste activités
$listActivityTypes1=getActivityTypes();
$listActivityTypes2=getActivityTypes();
$listActivityTypes3=getActivityTypes();

//Création Nouveau Projet
if ($codeProjet=="" or $titreProjet=="" or $Commercial=="" or $VolJourVendu=="" or $BudgetVendu=="" or $rfa=="") {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    les champs "Code Projet", "Titre Projet", "Commercial", "Volume Jour vendu", "Budget Vendu" et "RFA" sont <strong>obligatoires<strong>. </div>';
    $result="KO";
}
elseif (strpos($codeProjet,"\"")!==false or strpos($titreProjet,"\"")!==false or strpos($Commercial,"\"")!==false
        or strpos($codeProjet,":")!==false or strpos($titreProjet,":")!==false or strpos($Commercial,":")!==false) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    Les caractères double-quote et deux-points sont interdits. </div>';
    $result="KO";
}
elseif (!is_numeric($VolJourVendu) or $VolJourVendu<0 or !is_numeric($BudgetVendu) or $BudgetVendu<0 or !is_numeric($rfa) or $rfa <0 ) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    Les éléments suivants doivent être des nombres positifs ou nuls : "Volume de Jours vendus","Budget Vendu", "RFA" . </div>';
    $result="KO";
}
elseif (existProject($codeProjet)) { // Cas où Projet existant
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong>
    Projet déjà existant. </div>';
    $result="KO";
}
else {
    $message1='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Erreur de création du projet. </div>';
    $result="KO";
    // Création du nouveau projet avec extraction de son identifiant
    $newProjID=newInsertedProjID($pu,$codeProjet,$titreProjet,$Commercial,$rfa,$client,$typeProjet,$VolJourVendu,$BudgetVendu,$codeGen);
    // Succes de création du projet
    $message1='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Succès de création du projet. </div>';
    $result="OK";

    // Création des activités et tâches selon le type du nouveau projet
    if (($typeProjet=='Assistance Technique Simple' or $typeProjet=='Engagement de Moyen' or $typeProjet=='Engagement de Résultat') and $codeGen==0)
     {
        $message2='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Erreur de sélection des activités. </div>';
        $message3='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Erreur de création des tâches. </div>';
        $result="KO";
        //Création des activiés correspondantes
        /* $idActivity1=getActivityTypeID('Perte Production','négatif',0);
        $idActivity1=$idActivity1->fetch();
        $idActivity2=getActivityTypeID('Concession','négatif',0);
        $idActivity2=$idActivity2->fetch();
        $idActivity3=getActivityTypeID('Production','positif',1);
        $idActivity3=$idActivity3->fetch(); */

        //Activities and Tasks names
        /* $task1Name='97-Perte de Prod';
        $task2Name='98-Concession';
        $task3Name='1 - Tâche 1';

        $activity1Name='Perte Production';
        $activity2Name='Concession';
        $activity3Name='Production'; */

        // Récupération des 3 tâches par défaut
        $DTask1=getDTbyID(1);
        $DTask1=$DTask1->fetch();
        $DTask2=getDTbyID(2);
        $DTask2=$DTask2->fetch();
        $DTask3=getDTbyID(3);
        $DTask3=$DTask3->fetch();




        $message2='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Succès de sélection des activités. </div>';
        // Création des tâches correspondantes
        /* $idNewTask1=newTask($newProjID,'97-Perte de Prod',18);
        $idNewTask2=newTask($newProjID,'98-Concession',5);
        $idNewTask3=newTask($newProjID,'1 - Tâche 1',16); */

        $idNewTask1=newTask($newProjID,$DTask1['nomTache'],$DTask1['ID_TypeActivite']);
        $idNewTask2=newTask($newProjID,$DTask2['nomTache'],$DTask2['ID_TypeActivite']);
        $idNewTask3=newTask($newProjID,$DTask3['nomTache'],$DTask3['ID_TypeActivite']);
        $message3='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> succes de création des tâches. </div>';
        $result="OK";
        // Add the 3 new rows to the table
        $tbody.='<tr>
                    <td><input type="text" class="form-control" value="'.$DTask1['nomTache'].'" id="task-'.$idNewTask1.'" disabled ></td>
                    <td><select class="form-control" id="activity-'.$DTask1['ID_TypeActivite'].'" onchange=getTACEandFact(this.id,"TACE-'.$DTask1['ID_TypeActivite'].'","Fact-'.$DTask1['ID_TypeActivite'].'"); disabled>';
        while ($data=$listActivityTypes1->fetch()) {
            $tbody.='<option value="'.$data['ID'].'"';
            if ($data['ID']==$DTask1['ID_TypeActivite']) {
                $tbody.='selected';
            }
            $tbody.='>'.$data['Nom_typeActivite'].'</option>';
        }
        $tbody.='</td>
                    <td><input type="text"  class="form-control" value='.$DTask1['Impact_TACE'].' id="TACE-'.$DTask1['ID_TypeActivite'].'" disabled></td>
                    <td><input type="checkbox" class="form-control" id="Fact-'.$DTask1['ID_TypeActivite'].'" disabled></td>
                    <td>
                    <button type="button" id="edit-'.$idNewTask1.'" onclick=allowTaskModif(this.id,"task-'.$idNewTask1.'");>
                    <span class="glyphicon glyphicon-edit" ></span> Editer</button>
                    <button type="button" id="validation-'.$idNewTask1.'" disabled
                    onclick=taskUpdateValidation("task-'.$idNewTask1.'","activity-'.$DTask1['ID_TypeActivite'].'","TACE-'.$DTask1['ID_TypeActivite'].'","Fact-'.$DTask1['ID_TypeActivite'].'",this.id);>
                    <span class="glyphicon glyphicon-ok"></span>Valider</button>
                    <button type="button" id="annuler-'.$idNewTask1.'"
                    onclick="cancelTaskModif(\'task-'.$idNewTask1.'\',\'activity-'.$DTask1['ID_TypeActivite'].'\',\'TACE-'.$DTask1['ID_TypeActivite'].'\',\'Fact-'.$DTask1['ID_TypeActivite'].'\',this.id,\'validation-'.$idNewTask1.'\')";>
                    <span class="glyphicon glyphicon-refresh"></span> Rafraichir/Annuler</button>
                    </td>
                 </tr>
                 <tr>
                    <td><input type="text" class="form-control" value='.$DTask2['nomTache'].' id="task-'.$idNewTask2.'" disabled></td>
                    <td><select class="form-control" id="activity-'.$DTask2['ID_TypeActivite'].'" onchange=getTACEandFact(this.id,"TACE-'.$DTask2['ID_TypeActivite'].'","Fact-'.$DTask2['ID_TypeActivite'].'"); disabled>';
        while ($data=$listActivityTypes2->fetch()) {
            $tbody.='<option value="'.$data['ID'].'"';
            if ($data['ID']==$DTask2['ID_TypeActivite']) {
                $tbody.='selected';
            }
            $tbody.='>'.$data['Nom_typeActivite'].'</option>';
        }
        $tbody.='</td>
                    <td><input type="text" class="form-control" value='.$DTask2['Impact_TACE'].' id="TACE-'.$DTask2['ID_TypeActivite'].'" disabled></td>
                    <td><input type="checkbox" class="form-control" id="Fact-'.$DTask2['ID_TypeActivite'].'" disabled></td>
                    <td>
                    <button type="button" id="edit-'.$idNewTask2.'" onclick=allowTaskModif(this.id,"task-'.$idNewTask2.'");>
                    <span class="glyphicon glyphicon-edit" ></span> Editer</button>
                    <button type="button" id="validation-'.$idNewTask2.'" disabled 
                    onclick=taskUpdateValidation("task-'.$idNewTask2.'","activity-'.$DTask2['ID_TypeActivite'].'","TACE-'.$DTask2['ID_TypeActivite'].'","Fact-'.$DTask2['ID_TypeActivite'].'",this.id);>
                    <span class="glyphicon glyphicon-ok" ></span> Valider</button>
                    <button type="button" id="annuler-'.$idNewTask2.'"
                    onclick="cancelTaskModif(\'task-'.$idNewTask2.'\',\'activity-'.$DTask2['ID_TypeActivite'].'\',\'TACE-'.$DTask2['ID_TypeActivite'].'\',\'Fact-'.$DTask2['ID_TypeActivite'].'\',this.id,\'validation-'.$idNewTask2.'\')";>
                    <span class="glyphicon glyphicon-refresh"></span> Rafraichir/Annuler</button>
                    </td>
                 </tr>
                 <tr>
                    <td><input type="text" class="form-control" value="'.$DTask3['nomTache'].'" id="task-'.$idNewTask3.'" disabled></td>
                    <td><select class="form-control" id="activity-'.$DTask3['ID_TypeActivite'].'" onchange=getTACEandFact(this.id,"TACE-'.$DTask3['ID_TypeActivite'].'","Fact-'.$DTask3['ID_TypeActivite'].'"); disabled>';
        while ($data=$listActivityTypes3->fetch()) {
            $tbody.='<option value="'.$data['ID'].'"';
            if ($data['ID']==$DTask3['ID_TypeActivite']) {
                $tbody.='selected';
            }
            $tbody.='>'.$data['Nom_typeActivite'].'</option>';
        }
        $tbody.='</td>
                    <td><input type="text"  class="form-control" value='.$DTask3['Impact_TACE'].' id="TACE-'.$DTask3['ID_TypeActivite'].'" disabled></td>
                    <td><input type="checkbox" class="form-control" checked id="Fact-'.$DTask3['ID_TypeActivite'].'" disabled></td>
                    <td>
                    <button type="button" id="edit-'.$idNewTask3.'" onclick=allowTaskModif(this.id,"task-'.$idNewTask3.'");>
                    <span class="glyphicon glyphicon-edit" ></span> Editer</button>
                    <button type="button" id="validation-'.$idNewTask3.'" disabled 
                    onclick=taskUpdateValidation("task-'.$idNewTask3.'","activity-'.$DTask3['ID_TypeActivite'].'","TACE-'.$DTask3['ID_TypeActivite'].'","Fact-'.$DTask3['ID_TypeActivite'].'",this.id);>
                    <span class="glyphicon glyphicon-ok" ></span> Valider</button>
                    <button type="button" id="annuler-'.$idNewTask3.'"
                    onclick="cancelTaskModif(\'task-'.$idNewTask3.'\',\'activity-'.$DTask3['ID_TypeActivite'].'\',\'TACE-'.$DTask3['ID_TypeActivite'].'\',\'Fact-'.$DTask3['ID_TypeActivite'].'\',this.id,\'validation-'.$idNewTask3.'\')";>
                    <span class="glyphicon glyphicon-refresh"></span> Rafraichir/Annuler</button>
                    </td>
                 </tr>';
        $message=$message1.$message2.$message3;
    }else {
        $message=$message1;
    }

}
$donnees=array($message,$tbody,$result);
echo json_encode($donnees);