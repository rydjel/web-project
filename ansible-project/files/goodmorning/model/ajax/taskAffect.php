<?php
require("../frontend.php");
//$db = dbConnect();
$idCollab=$_POST['collabChoice'];
$task=$_POST['task'];
$tjm=$_POST['tjm'];
$budgetInit=$_POST['budgetInit'];
$budgetComp=$_POST['budgetComp'];
$volJoursInit=$_POST['volJoursInit'];
$volJoursComp=$_POST['volJoursComp'];
$fraisInit=$_POST['fraisInit'];
$fraisComp=$_POST['fraisComp'];
$autresCouts=$_POST['autresCouts'];
$debutAnnee=$_POST['debutAnnee'];
$debutMois=$_POST['debutMois'];
$finAnnee=$_POST['finAnnee'];
$finMois=$_POST['finMois'];
$isow=$_POST['isow'];
$odm=$_POST['odm'];
if ($_POST['fop']=='true') {
    $fop=1;
}
else {
    $fop=0;
}
$coverage=$_POST['coverage'];
$sowid=$_POST['sowid'];
$codeProj=$_POST['codeProj'];
$idProject=getProjectIDbyCode($codeProj); // Acces identifiant projet
$idProject=$idProject->fetch();

// Array of numerical fields
$numFields=array('tjm'=>$tjm,'volJoursInit'=>$volJoursInit,'volJoursComp'=>$volJoursComp,'fraisInit'=>$fraisInit,'fraisComp'=>$fraisComp,'autresCouts'=>$autresCouts,'budgetInit'=>$budgetInit,'budgetComp'=>$budgetComp,'sowid'=>$sowid);
foreach ($numFields as $key => $value) {
    if ($value=="") {
        ${$key} =0;
    }
}

// Translate months in number
$mois=array('Janvier'=>'1','Fevrier'=>'2','Mars'=>'3','Avril'=>'4','Mai'=>'5','Juin'=>'6','Juillet'=>'7',
'Août'=>'8','Septembre'=>'9','Octobre'=>'10','Novembre'=>'11','Décembre'=>'12');

// Obtain the periods of affectations if exist
$listperiods=getTaskAffectationPeriods($idCollab,$task);
$recover=false;

// Determine if there is a recover in affectation period
if ($listperiods) {

    while ($data=$listperiods->fetch() and $recover==false) {
        
        if ( 
              !( ( $data['Annee_Debut'].str_pad($data['Mois_Debut'],2,'0',STR_PAD_LEFT) > $finAnnee.str_pad($mois[$finMois],2,'0',STR_PAD_LEFT) 
             and  $data['Annee_Debut'].str_pad($data['Mois_Debut'],2,'0',STR_PAD_LEFT) > $debutAnnee.str_pad($mois[$debutMois],2,'0',STR_PAD_LEFT) )
             or
             ( $data['Annee_Fin'].str_pad($data['Mois_Fin'],2,'0',STR_PAD_LEFT) < $finAnnee.str_pad($mois[$finMois],2,'0',STR_PAD_LEFT) 
             and  $data['Annee_Fin'].str_pad($data['Mois_Fin'],2,'0',STR_PAD_LEFT) < $debutAnnee.str_pad($mois[$debutMois],2,'0',STR_PAD_LEFT) ) )

            ) {
            $recover=true;
        }

    }
}

/* if ($listperiods) {
    while ($data=$listperiods->fetch() and $recover==false) {
        if (!($debutAnnee>$data['Annee_Fin'] or $finAnnee<$data['Annee_Debut'] or ($data['Annee_Debut']==$data['Annee_Fin'] and $debutAnnee==$finAnnee and $debutAnnee==$data['Annee_Debut'] 
                and ($mois[$debutMois]>$data['Mois_Fin'] or $mois[$finMois]<$data['Mois_Debut'])))) {
                $recover=true;
        }
    }
} */


//Création d'une Affectation à la tâche d'un projet
if ($idCollab=="" or $task=="" or $debutAnnee=="" or $debutMois=="" or $finAnnee=="" or $finMois=="") 
{
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    Les Champs Collab, Tâche, dates de début et de Fin sont obligatoires. </div>';
}
elseif (strpos($sowid,"\"")!==false or strpos($sowid,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits.</div>';
}
elseif ( $debutAnnee.str_pad($mois[$debutMois],2,'0',STR_PAD_LEFT) > $finAnnee.str_pad($mois[$finMois],2,'0',STR_PAD_LEFT) ) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    Les Mois et/ou Année de fin sont antérieures à celles de début!. </div>';
}
/* elseif ( $mois[$debutMois] > $mois[$finMois]) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    Les Mois et/ou Année de fin sont antérieures à celles de début!. </div>';
}
elseif ($debutAnnee!=$finAnnee ) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    Les Années de Début et de Fin doivent être identiques!. </div>';
} */
elseif ($recover==true) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    La Période d\'affectation choisie recouvre une déjà existante!. </div>';
}
else
{
    if (createTJM($idCollab,$task,$debutAnnee,$mois[$debutMois],$finAnnee,$mois[$finMois],$tjm,$volJoursInit,$volJoursComp,$fraisInit,$fraisComp,
    $autresCouts,$budgetInit,$budgetComp,$isow,$sowid,$odm,$fop,$coverage)) {
        $message1='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> succes de rajout de l\'affectation. </div>';
        // Rajout des Imputations (Affectations)
        $inputOK=0;
        $inputKO=0;
        if ($debutAnnee==$finAnnee) { // Même Année
            for ($i=$mois[$debutMois]; $i <= $mois[$finMois] ; $i++) { 
                if (insertImputation($debutAnnee,$i,$idCollab,$task,0,0)) {
                    $inputOK++;
                }
                else {
                    $inputKO++;
                }
            }
            $message2='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button>'.$inputOK.' succès d\'imputation(s) </div>';
            $message3='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button>'.$inputKO.' echecs d\'imputation(s) </div>';
        }
        else { // Années Différentes
            $i=$debutAnnee;
            $j=$mois[$debutMois];

            while ($i.str_pad($j,2,'0',STR_PAD_LEFT) <= $finAnnee.str_pad($mois[$finMois],2,'0',STR_PAD_LEFT)) {
                
                if (insertImputation($i,$j,$idCollab,$task,0,0)) {
                    $inputOK++;
                }
                else {
                    $inputKO++;
                }
                
                $j++;

                if ($j==13) {
                    $j=1;
                    $i++;
                }


            }

            /*for ($i=$mois[$debutMois]; $i <=12 ; $i++) { 
                if (insertImputation($debutAnnee,$i,$idCollab,$task,0,0)) {
                    $inputOK++;
                }
                else {
                    $inputKO++;
                }
            }
            for ($i=1; $i <=$mois[$finMois] ; $i++) { 
                if (insertImputation($finAnnee,$i,$idCollab,$task,0,0)) {
                    $inputOK++;
                }
                else {
                    $inputKO++;
                }
            }*/
            $message2='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button>'.$inputOK.' succès d\'imputation(s) nulles </div>';
            $message3='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button>'.$inputKO.' echecs d\'imputation(s) nulles </div>';
        }
        $message=$message1.$message2.$message3;
    }else {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Echec de rajout de l\'affectation. </div>';
    }
   
}
//$message.='<div class="alert  alert-info" >  <h3> <strong>Rechargement</strong> de la page dans 5 S ... </h3> </div>';

//echo $message;

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
            <option value="Sign Off" ';
            if ($data['ISOW']=="S.O") {
                $liste.='selected';
            }
            $liste.='>S.O</option> 
            </select>
        </td>
        <td>
        <input type="text" name="sowid" id="sowid-'.$data['idTJM'].'" value="'.$data['SOW_ID'].'" disabled>
    </td>
    <td>
        <select id="odm-'.$data['idTJM'].'" name="odm" disabled>
            <option value="A faire" ';
            if ($data['ODM']=="A faire") {
                $liste.='selected';
            }
            $liste.='>A faire</option> 
            <option value="En cours" ';
            if ($data['ODM']=="En cours") {
                $liste.='selected';
            }
            $liste.='>En cours</option> 
            <option value="Sign Off" ';
            if ($data['ODM']=="Sign Off") {
                $liste.='selected';
            }
            $liste.='>Sign Off</option>
            <option value="S.O" ';
            if ($data['ODM']=="S.O") {
                $liste.='selected';
            }
            $liste.='>S.O</option> 
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
            <input type="text" title="rateCard" id="rateCard" disabled>
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
                <input type="text" title="TJM" id="TJM" name="tjm" value="" onchange="getContrib(this.value,\'rateCard\',\'Contrib\');">
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
                    <option value="S.O">S.O</option>
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
                    <option value="S.O">S.O</option>
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

echo $message.':'.$liste;