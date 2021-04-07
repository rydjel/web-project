<?php
require("../frontend.php");
$db = dbConnect();
$values=explode(":",$_POST['affDetails']);

// Extraction of different values
$idCollab=$values[1];
$idTask=$values[2];
$debutMois=$values[3];
$debutMoisBU=$values[4]; // début de Mois avant mise à jour
$finMois=$values[5];
$finMoisBU=$values[6]; // fin de mois avant mise à jour
$idTJM=$values[7];
$debutAnnee=$values[8];
$tjm=$values[9];
$budgetInit=$values[10];
$budgetComp=$values[11];
$volJoursInit=$values[12];
$volJoursComp=$values[13];
$fraisInit=$values[14];
$fraisComp=$values[15];
$autresCouts=$values[16];
$isow=$values[17];
$sowid=$values[18];
$odm=$values[19];
$fop=$values[20];
$coverage=$values[21];
$finAnnee=$values[22];
$debutAnneeBU=$values[23];
$finAnneeBU=$values[24];

$codeProjet=$_POST['codeProjet'];
$idProject=getProjectIDbyCode($codeProjet); // Acces identifiant projet
$idProject=$idProject->fetch();


// Initialization of numbers of delete and update
$nbDeleteOK=0;
$nbDeleteKO=0;
$nbUpdateOK=0;
$nbUpdateKO=0;

// Delete Extra-Imputations
if ( $debutAnnee.str_pad($debutMois,2,'0',STR_PAD_LEFT) > $debutAnneeBU.str_pad($debutMoisBU,2,'0',STR_PAD_LEFT) ) {

    if (deleteListImputations($debutAnneeBU.str_pad($debutMoisBU,2,'0',STR_PAD_LEFT), $debutAnnee.str_pad($debutMois-1,2,'0',STR_PAD_LEFT),$idCollab,$idTask)) {
        $nbDeleteOK++; 
    }
    else {
        $nbDeleteKO++; 
    }
    

}

if ( $finAnnee.str_pad($finMois,2,'0',STR_PAD_LEFT) < $finAnneeBU.str_pad($finMoisBU,2,'0',STR_PAD_LEFT) ) {

    if (deleteListImputations($finAnnee.str_pad($finMois+1,2,'0',STR_PAD_LEFT), $finAnneeBU.str_pad($finMoisBU,2,'0',STR_PAD_LEFT),$idCollab,$idTask)) {
        $nbDeleteOK++; 
    }
    else {
        $nbDeleteKO++; 
    }
    

}

$nbInputOK=0;
$nbInputKO=0;
// Cas où des mois sont affectés en plus
if ( $debutAnnee.str_pad($debutMois,2,'0',STR_PAD_LEFT) < $debutAnneeBU.str_pad($debutMoisBU,2,'0',STR_PAD_LEFT) ) {

    $i=$debutAnnee;
    $j=$debutMois;
    

    while ($i.str_pad($j,2,'0',STR_PAD_LEFT)  < $debutAnneeBU.str_pad($debutMoisBU,2,'0',STR_PAD_LEFT) ) {

        if (insertImputation($i,$j,$idCollab,$idTask,0,0)) {
            $nbInputOK++;
        }
        else {
            $nbInputKO++;
        }
        
        $j++;

        if ($j==13) {
            $j=1;
            $i++;
        }
            
    }
}

if ( $finAnnee.str_pad($finMois,2,'0',STR_PAD_LEFT) > $finAnneeBU.str_pad($finMoisBU,2,'0',STR_PAD_LEFT) ) {
    
    
    if ($finMoisBU==12) {
        $j=1;
        $i=$finAnneeBU+1;
    }
    else {
        $i=$finAnneeBU;
        $j=$finMoisBU+1;
    }
    

    while ($i.str_pad($j,2,'0',STR_PAD_LEFT) <= $finAnnee.str_pad($finMois,2,'0',STR_PAD_LEFT)) {
        
        if (insertImputation($i,$j,$idCollab,$idTask,0,0)) {
            $nbInputOK++;
        }
        else {
            $nbInputKO++;
        }
        
        $j++;

        if ($j==13) {
            $j=1;
            $i++;
        }

    }

}
/* if ($debutMois > $debutMoisBU) {
    for ($i=$debutMoisBU; $i < $debutMois; $i++) { 
        if (deleteImputation($debutAnnee,$i,$idCollab,$idTask)) {
            $nbDeleteOK++; 
        }
        else {
            $nbDeleteKO++;
        }
    }
}

if ($finMois<$finMoisBU) {
    for ($i=$finMois+1; $i<=$finMoisBU ; $i++) { 
        if (deleteImputation($debutAnnee,$i,$idCollab,$idTask)) {
            $nbDeleteOK++; 
        }
        else {
            $nbDeleteKO++;
        }
    }
} */

// Update the Months modified
$fieldsArray = array('Mois_Debut' =>$debutMois,'Annee_Debut' =>$debutAnnee,'Mois_Fin' =>$finMois,'Annee_Fin' =>$finAnnee,'Valeur' =>$tjm,'BudgetInit' =>$budgetInit,'BudgetComp' =>$budgetComp,'VolJourInit' =>$volJoursInit,
'VolJourComp' =>$volJoursComp,'FraisInit' =>$fraisInit,'FraisComp' =>$fraisComp,'AutresCouts' =>$autresCouts,'ISOW' =>$isow,'SOW_ID' =>$sowid,'ODM' =>$odm,'FOP' =>$fop,'coverage'=>$coverage);


foreach ($fieldsArray as $key => $value) {
    if (checkTJMFieldUpdated($key,$value,$idTJM) and updateTJM($key,$value,$idTJM)) {
        $nbUpdateOK++;
    }
    elseif (checkTJMFieldUpdated($key,$value,$idTJM) and !updateTJM($key,$value,$idTJM)) {
        $nbUpdateKO++;
    }
}

$message="";
if ($nbDeleteOK==0 and $nbDeleteKO==0) {
    $message.='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="modal">&times;</button> Auncune suppression d\'imputation(s) effectuée(s) </div>';
}
else {
    if ($nbDeleteOK>0) {
        $message.='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="modal">&times;</button> succès de suppression d\'imputation(s) </div>';
     }
     if ($nbDeleteKO>0) {
         $message.='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="modal">&times;</button> echecs de suppression d\'imputation(s) </div>';
     }
}

if ($nbUpdateOK==0 and $nbUpdateKO==0) {
    $message.='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="modal">&times;</button> Auncune Mise(s) à Jours(s) effectuée(s) </div>';
}
else {
    if ($nbUpdateOK>0) {
        $message.='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="modal">&times;</button>'.$nbUpdateOK.' succès de MàJ </div>';
    }
    if ($nbUpdateKO>0) {
        $message.='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="modal">&times;</button>'.$nbUpdateKO.' succès de MàJ </div>';
    }
}


if ($nbInputOK==0 and $nbInputKO==0) {
    $message.='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="modal">&times;</button> Auncune Imputations effectuée(s) </div>';
}
else {
    if ($nbInputOK>0) {
        $message.='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="modal">&times;</button>'.$nbInputOK.' imputation(s) en succès </div>';
    }
    if ($nbInputKO>0) {
        $message.='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="modal">&times;</button>'.$nbInputKO.' Imputations en succès </div>';
    }
}

/* 
$message1='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="modal">&times;</button>'.$nbDeleteOK.' succès de suppression d\'imputation(s) </div>';
$message2='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="modal">&times;</button>'.$nbDeleteKO.' echecs de suppression d\'imputation(s) </div>';
$message3='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="modal">&times;</button>'.$nbUpdateOK.' succès de MàJ de mois d\'affectation </div>';
$message4='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="modal">&times;</button>'.$nbUpdateKO.' echecs de MàJ de mois d\'affectation </div>';

$message=$message1.$message2.$message3.$message4; 
*/
   
// Recharge de la page
$taskList=projectTaskList($idProject['ID']);
$listAffect=projTasksAffList($idProject['ID']); // Liste des Affectations
$collabs=getCollabs(); // liste de Collabs
$liste='';
if ($listAffect) {
    while ($data=$listAffect->fetch()) {
        $liste.='<tr>
        <td>'.$data['Nom'].' '.$data['Prénom'].'</td>
        <td>'.$data['RateCard'].'</td>
        <td>'.$data['Nom_Tache'].'</td>
        <td><input type="text" disabled id="tjm-'.$data['idTJM'].'" value="'.$data['Valeur'].'"></td>
        <td>'.$data['Nom_typeActivite'].'</td>

        <td>
            <select id="coverage-'.$data['idTJM'].'" name="coverage" disabled>
                <option value="firm" ';
        if ($data['coverage']=="firm") {
            $liste.='selected';
        }
        $liste.='>firm</option> 
        <option value="named" ';
        if ($data['coverage']=="named") {
            $liste.='selected';
        }
        $liste.='>named</option></select>
        </td>
        <td>'.$data['Impact_TACE'].'</td>
        <td><input type="checkbox" disabled ';
        if ($data['Facturable']==1) {
            $liste.='checked ';
        }
        $liste.='readonly> </td>
        <td><input type="text" disabled id="budgetInit-'.$data['idTJM'].'"  value="'.$data['BudgetInit'].'"> </td>
        <td><input type="text"  disabled id="budgetComp-'.$data['idTJM'].'"  value="'.$data['BudgetComp'].'"> </td>
        <td><input type="text" disabled id="volJourInit-'.$data['idTJM'].'"  value="'.$data['VolJourInit'].'"> </td>
        <td><input type="text" disabled id="volJourComp-'.$data['idTJM'].'"  value="'.$data['VolJourComp'].'"> </td>
        <td><input type="text" disabled id="fraisInit-'.$data['idTJM'].'"  value="'.$data['FraisInit'].'"> </td>
        <td><input type="text" disabled id="fraisComp-'.$data['idTJM'].'"  value="'.$data['FraisComp'].'"> </td>
        <td><input type="text" disabled id="autresCouts-'.$data['idTJM'].'"  value="'.$data['AutresCouts'].'"></td>
        <td>';
        if ($data['Valeur']==0) {
            $liste.='0';
        }
        else {
            $liste.=round(($data['Valeur']-$data['RateCard'])/$data['Valeur']*100,2);
        }
        $prevYear=date("Y")-1;
        $currentYear=date("Y");
        $nextYear=date("Y")+1;

        $liste.='</td>
        <td><select id="debutAnnee-'.$data['idTJM'].'" disabled>
            <option value="'.$prevYear.'" ';
        if ($data['Annee_Debut']==$prevYear) {
            $liste.='selected';
        }
        $liste.='>'.$prevYear.'</option>
            <option value="'.$currentYear.'" ';
        if ($data['Annee_Debut']==$currentYear) {
            $liste.='selected';
        }
        $liste.='>'.$currentYear.'</option>
            <option value="'.$nextYear.'" ';
        if ($data['Annee_Debut']==$nextYear) {
            $liste.='selected';
        }
        $liste.='>'.$nextYear.'</option>
        </td>
        <td><select id="debutMois-'.$data['idTJM'].'" disabled>
            <option value="1" ';
        if ($data['Mois_Debut']==1) {
            $liste.='selected';
        }
        $liste.='>Janvier</option>
        <option value="2" ';
        if ($data['Mois_Debut']==2) {
            $liste.='selected';
        }
        $liste.='>Fevrier</option>
        <option value="3" ';
        if ($data['Mois_Debut']==3) {
            $liste.='selected';
        }
        $liste.='>Mars</option>
        <option value="4" ';
        if ($data['Mois_Debut']==4) {
            $liste.='selected';
        }
        $liste.='>Avril</option>
        <option value="5" ';
        if ($data['Mois_Debut']==5) {
            $liste.='selected';
        }
        $liste.='>Mai</option>
        <option value="6" ';
        if ($data['Mois_Debut']==6) {
            $liste.='selected';
        }
        $liste.='>Juin</option>
        <option value="7" ';
        if ($data['Mois_Debut']==7) {
            $liste.='selected';
        }
        $liste.='>Juillet</option>
        <option value="8" ';
        if ($data['Mois_Debut']==8) {
            $liste.='selected';
        }
        $liste.='>Août</option>
        <option value="9" ';
        if ($data['Mois_Debut']==9) {
            $liste.='selected';
        }
        $liste.='>Septembre</option>
        <option value="10" ';
        if ($data['Mois_Debut']==10) {
            $liste.='selected';
        }
        $liste.='>Octobre</option>
        <option value="11" ';
        if ($data['Mois_Debut']==11) {
            $liste.='selected';
        }
        $liste.='>Novembre</option>
        <option value="12" ';
        if ($data['Mois_Debut']==12) {
            $liste.='selected';
        }
        $liste.='>Décembre</option></select></td>
        <td><select id="finAnnee-'.$data['idTJM'].'" disabled>
            <option value="'.$prevYear.'" ';
        if ($data['Annee_Fin']==$prevYear) {
            $liste.='selected';
        }
        $liste.='>'.$prevYear.'</option>
            <option value="'.$currentYear.'" ';
        if ($data['Annee_Fin']==$currentYear) {
            $liste.='selected';
        }
        $liste.='>'.$currentYear.'</option>
            <option value="'.$nextYear.'" ';
        if ($data['Annee_Fin']==$nextYear) {
            $liste.='selected';
        }
        $liste.='>'.$nextYear.'</option>
        </td>
        <td>
            <select id="finMois-'.$data['idTJM'].'" disabled>
            <option value="1" ';
            if ($data['Mois_Fin']==1) {
                $liste.='selected';
            }
            $liste.='>Janvier</option>
            <option value="2" ';
            if ($data['Mois_Fin']==2) {
                $liste.='selected';
            }
            $liste.='>Fevrier</option>
            <option value="3" ';
            if ($data['Mois_Fin']==3) {
                $liste.='selected';
            }
            $liste.='>Mars</option>
            <option value="4" ';
            if ($data['Mois_Fin']==4) {
                $liste.='selected';
            }
            $liste.='>Avril</option>
            <option value="5" ';
            if ($data['Mois_Fin']==5) {
                $liste.='selected';
            }
            $liste.='>Mai</option>
            <option value="6" ';
            if ($data['Mois_Fin']==6) {
                $liste.='selected';
            }
            $liste.='>Juin</option>
            <option value="7" ';
            if ($data['Mois_Fin']==7) {
                $liste.='selected';
            }
            $liste.='>Juillet</option>
            <option value="8" ';
            if ($data['Mois_Fin']==8) {
                $liste.='selected';
            }
            $liste.='>Août</option>
            <option value="9" ';
            if ($data['Mois_Fin']==9) {
                $liste.='selected';
            }
            $liste.='>Septembre</option>
            <option value="10" ';
            if ($data['Mois_Fin']==10) {
                $liste.='selected';
            }
            $liste.='>Octobre</option>
            <option value="11" ';
            if ($data['Mois_Fin']==11) {
                $liste.='selected';
            }
            $liste.='>Novembre</option>
            <option value="12" ';
            if ($data['Mois_Fin']==12) {
                $liste.='selected';
            }
            $liste.='>Décembre</option></select></td> 
            <td>
                <select id="isow-'.$data['idTJM'].'" name="isow" disabled>
                <option value="A faire" ';
            if ($data['ISOW']=="A faire") {
                $liste.='selected';
            }
            $liste.='>A faire</option> 
            <option value="En cours" ';
            if ($data['ISOW']=="En cours") {
                $liste.='selected';
            }
            $liste.='>En cours</option> 
            <option value="Sign Off" ';
            if ($data['ISOW']=="Sign Off") {
                $liste.='selected';
            }
            $liste.='>Sign Off</option> 
            </select>
        </td>
        <td>
        <input type="text" name="sowid" id="sowid-'.$data['idTJM'].'" value="'.$data['SOW_ID'].'" disabled>
    </td>
    <td>
        <select id="odm-'.$data['idTJM'].'" name="odm" disabled>
            <option value="A faire" ';
            if ($data['ISOW']=="A faire") {
                $liste.='selected';
            }
            $liste.='>A faire</option> 
            <option value="En cours" ';
            if ($data['ISOW']=="En cours") {
                $liste.='selected';
            }
            $liste.='>En cours</option> 
            <option value="Sign Off" ';
            if ($data['ISOW']=="Sign Off") {
                $liste.='selected';
            }
            $liste.='>Sign Off</option> 
            </select>
        </td>
                <td>
                    <input type="checkbox" class="form-control" title="fop" id="fop-'.$data['idTJM'].'" ';
                if($data['FOP']==1)
                {$liste.='checked';} 
                $liste.=' disabled>        
                </td>
                <td>
                <button type="button" id="edit-'.$data['idTJM'].'" onclick="allowAffModif(this.id);">
                <span class="glyphicon glyphicon-edit"></span> Editer</button>
                <button type="button" id="validation-'.$data['idTJM'].'" disabled
                onclick="affUpdateValidation(\'tjm-'.$data['idTJM'].'\',\'budgetInit-'.$data['idTJM'].'\',\'budgetComp-'.$data['idTJM'].'\',
                                            \'volJourInit-'.$data['idTJM'].'\',\'volJourComp-'.$data['idTJM'].'\',
                                            \'fraisInit-'.$data['idTJM'].'\',\'fraisComp-'.$data['idTJM'].'\',
                                            \'autresCouts-'.$data['idTJM'].'\',\'debutAnnee-'.$data['idTJM'].'\',
                                            \'debutMois-'.$data['idTJM'].'\',\'finAnnee-'.$data['idTJM'].'\',
                                            \'finMois-'.$data['idTJM'].'\',\'isow-'.$data['idTJM'].'\',\'sowid-'.$data['idTJM'].'\',
                                            \'odm-'.$data['idTJM'].'\',\'fop-'.$data['idTJM'].'\',this.id,\'coverage-'.$data['idTJM'].'\',
                                            \''.$data['idCollab'].'\',\''.$data['idTask'].'\');">
                <span class="glyphicon glyphicon-ok"></span>Valider</button>
                <button type="button" id="annulation-'.$data['idTJM'].'" disabled
                onclick="cancelAffUpdate(\'tjm-'.$data['idTJM'].'\',\'budgetInit-'.$data['idTJM'].'\',\'budgetComp-'.$data['idTJM'].'\',
                                            \'volJourInit-'.$data['idTJM'].'\',\'volJourComp-'.$data['idTJM'].'\',
                                            \'fraisInit-'.$data['idTJM'].'\',\'fraisComp-'.$data['idTJM'].'\',
                                            \'autresCouts-'.$data['idTJM'].'\',\'debutAnnee-'.$data['idTJM'].'\',
                                            \'debutMois-'.$data['idTJM'].'\',\'finAnnee-'.$data['idTJM'].'\',
                                            \'finMois-'.$data['idTJM'].'\',\'isow-'.$data['idTJM'].'\',\'sowid-'.$data['idTJM'].'\',
                                            \'odm-'.$data['idTJM'].'\',\'fop-'.$data['idTJM'].'\',this.id,\'validation-'.$data['idTJM'].'\',
                                            \'coverage-'.$data['idTJM'].'\');">
                <span class="glyphicon glyphicon-refresh"></span> Rafraichir/Annuler</button> 
                </td>
            </tr>';   
    }
}
$liste.='<tr><td>
    <select id="collabChoice" name="collab" onchange="getCollabRateCard(this.value,\'rateCard\',\'Contrib\');">
    <option value="" selected></option>';
    while ($data=$collabs->fetch()) {
        $liste.='<option value="'.$data['ID'].'" > '.$data['Nom'].' '.$data['Prénom'].'</option>';
    }
    $liste.='</select></td>
        <td>
            <input type="text" title="rateCard" id="rateCard">
        </td>
        <td>
            <select id="task" name="task" onchange="getTaskActivity(this.value,\'typeActivite\',\'tace\',\'facturable\');">
            <option value="" selected></option>';
            while ($data=$taskList->fetch()) {
                $liste.='<option value="'.$data['taskID'].'"> '.$data['Nom_Tache'].'</option>';
            }
            $liste.='</select>
            </td>
            <td>
                <input type="text" title="TJM" id="TJM" name="tjm" value="">
            </td>
            <td>
                <input type="text" title="typeActivite" id="typeActivite" value="">
            </td>
            <td>
                <select id="coverage" name="coverage">
                    <option value="firm" selected>firm</option> 
                    <option value="named">named</option>
                </select>
            </td>
            <td>
                <input type="text" title="TACE" id="tace" value="">  
            </td>
            <td>
                <input type="checkbox" title="facturable" id="facturable" value="" disabled>
            </td>
            <td>
                <input type="text" title="budgetInit" id="budgetInit" name="budgetInit" value="">
            </td>
            <td>
                <input type="text" title="budgetComp" id="budgetComp" name="budgetComp" value="">
            </td>
            <td>
                <input type="text" title="volJoursInit" id="volJoursInit" name="volJoursInit" value="">
            </td>
            <td>
                <input type="text" title="volJoursComp" id="volJoursComp" name="volJoursComp" value="">
            </td>
            <td>
                <input type="text" title="fraisInit" id="fraisInit" name="fraisInit" value="">
            </td>
            <td>
                <input type="text" title="fraisComp" id="fraisComp" name="fraisComp" value="">
            </td>
            <td>
                <input type="text" title="Autres Coûts" id="autresCouts" name="autresCouts" value="">
            </td>
            <td>
                <input type="text" title="Contrib" id="Contrib">
            </td>
            <td>';
            /* $prevYear=date("Y")-1;
            $currentYear=date("Y");
            $nextYear=date("Y")+1; */
            $liste.='
                <select id="debutAnnee" name="debutAnnee">
                    <option value="'.$prevYear.'">'.$prevYear.'</option>
                    <option value="'.$currentYear.'" selected>'.$currentYear.'</option>
                    <option value="'.$nextYear.'">'.$nextYear.'</option>
                </select>
            </td>
            <td>
                <select id="debutMois" name="debutMois">
                    <option value="Janvier">Janvier</option>
                    <option value="Fevrier">Fevrier</option>
                    <option value="Mars">Mars</option>
                    <option value="Avril">Avril</option>
                    <option value="Mai">Mai</option>
                    <option value="Juin">Juin</option>
                    <option value="Juillet">Juillet</option>
                    <option value="Août">Août</option>
                    <option value="Septembre">Septembre</option>
                    <option value="Octobre">Octobre</option>
                    <option value="Novembre">Novembre</option>
                    <option value="Décembre">Décembre</option>
                </select>      
            </td>
            <td>
                <select id="finAnnee" name="finAnnee">
                    <option value="'.$prevYear.'">'.$prevYear.'</option>
                    <option value="'.$currentYear.'" selected>'.$currentYear.'</option>
                    <option value="'.$nextYear.'">'.$nextYear.'</option>
                </select>
            </td>
            <td>
                <select id="finMois" name="finMois">
                    <option value="Janvier">Janvier</option>
                    <option value="Fevrier">Fevrier</option>
                    <option value="Mars">Mars</option>
                    <option value="Avril">Avril</option>
                    <option value="Mai">Mai</option>
                    <option value="Juin">Juin</option>
                    <option value="Juillet">Juillet</option>
                    <option value="Août">Août</option>
                    <option value="Septembre">Septembre</option>
                    <option value="Octobre">Octobre</option>
                    <option value="Novembre">Novembre</option>
                    <option value="Décembre">Décembre</option>
                </select>                         
            </td>
            <td>
                <select id="isow" name="isow">
                    <option value="A faire">A faire</option> 
                    <option value="En cours">En cours</option>
                    <option value="Sign Off">Sign Off</option>
                </select>
            </td>
            <td>
                <input type="text" name="sowid" id="sowid">
            </td>
            <td>
                <select id="odm" name="odm">
                    <option value="A faire">A faire</option> 
                    <option value="En cours">En cours</option>
                    <option value="Sign Off">Sign Off</option>
                </select>
            </td>
            <td>
                <input type="checkbox" class="form-control" id="fop" name="FOPCheck"/>        
            </td>
            <td>
                <button type="button" id="AffectValidation" 
                onclick="taskAffectValidation(\'collabChoice\',\'task\',\'TJM\',\'budgetInit\',\'budgetComp\',\'volJoursInit\',\'volJoursComp\',
                \'fraisInit\',\'fraisComp\',\'autresCouts\',\'debutAnnee\',\'debutMois\',\'finAnnee\',\'finMois\',\'isow\',\'odm\',\'fop\',\'coverage\',\'sowid\',\'codeProjet\');">
                <span class="glyphicon glyphicon-ok"></span>Valider</button>
            </td>
        </tr>';

echo $message.":".$liste;