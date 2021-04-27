<?php
require("../frontend.php");
$db = dbConnect();
$idTJM=explode("-",$_POST['idExtend']);
$idCollab=$_POST['idCollab'];
$task=$_POST['idTask'];
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
$sowid=$_POST['sowid'];
$odm=$_POST['odm'];
if ($_POST['fop']=='true') {
    $fop=1;
}
else {
    $fop=0;
}
$coverage=$_POST['coverage'];

$codeProjet=$_POST['codeProjet'];
$idProject=getProjectIDbyCode($codeProjet); // Acces identifiant projet
$idProject=$idProject->fetch();

// Array of numerical fields
$numFields=array('tjm'=>$tjm,'volJoursInit'=>$volJoursInit,'volJoursComp'=>$volJoursComp,'fraisInit'=>$fraisInit,'fraisComp'=>$fraisComp,'autresCouts'=>$autresCouts,'budgetInit'=>$budgetInit,'budgetComp'=>$budgetComp,'sowid'=>$sowid);
foreach ($numFields as $key => $value) {
    if ($value=="") {
        ${$key} =0;
    }
}

// Translate months in number
/* $mois=array('Janvier'=>'1','Fevrier'=>'2','Mars'=>'3','Avril'=>'4','Mai'=>'5','Juin'=>'6','Juillet'=>'7',
'Août'=>'8','Septembre'=>'9','Octobre'=>'10','Novembre'=>'11','Décembre'=>'12'); */

// Accès aux Années et mois initiaux (avant mise à jour)
$MonthsBeforUpdate=getAffectationYearsMonths($idTJM[1]);
$data=$MonthsBeforUpdate->fetch();
$debutAnneeBU=$data['Annee_Debut'];
$finAnneeBU=$data['Annee_Fin'];
$debutMoisBU=$data['Mois_Debut'];
$finMoisBU=$data['Mois_Fin'];


// Acces aux mois initiaux et finaux avant modif
/* $MonthsBeforUpdate=getAffectationMonths($idTJM[1]);
$data=$MonthsBeforUpdate->fetch();
$debutMoisBU=$data['Mois_Debut'];
$finMoisBU=$data['Mois_Fin']; */

//Obtain the other periods of affectations if exist
$listperiods=getOtherAffPeriods($idCollab,$task,$idTJM[1]);
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
                and ($debutMois>$data['Mois_Fin'] or $finMois<$data['Mois_Debut'])))) {
                $recover=true;
        }
    }
} */


if ($debutMois==""  or $finMois=="" or $debutAnnee=="" or $finAnnee=="") 
{
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    Les Champs Collab, Tâche, Année début, Mois de début, Année Fin et Mois de Fin sont obligatoires. </div>';
}
elseif (strpos($sowid,"\"")!==false or strpos($sowid,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits.</div>';
}
/* elseif (!is_numeric($tjm) or !is_numeric($budgetInit) or !is_numeric($budgetComp) or !is_numeric($volJoursInit) or !is_numeric($volJoursComp) or !is_numeric($fraisInit) or !is_numeric($fraisComp) 
        or !is_numeric($autresCouts) or $tjm<0 or $budgetInit<0 or $budgetComp<0 or $volJoursInit<0 or $volJoursComp<0 or $fraisInit<0 or $fraisComp<0 or $autresCouts<0  ) {
            $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
            Les éléments suivants doivent être des nombres positifs ou nuls : TJM, Budget(s), Volume Jour(s), Frais, Autres Cout(s) . </div>';
} */
elseif ( (checkTJMFieldUpdated('Mois_Debut',$debutMois,$idTJM[1]) or checkTJMFieldUpdated('Mois_Fin',$finMois,$idTJM[1]) or checkTJMFieldUpdated('Annee_Debut',$debutAnnee,$idTJM[1]) or checkTJMFieldUpdated('Annee_Fin',$finAnnee,$idTJM[1]))
        and ($recover==true or $debutAnnee.str_pad($debutMois,2,'0',STR_PAD_LEFT) > $debutAnneeBU.str_pad($debutMoisBU,2,'0',STR_PAD_LEFT) or $finAnnee.str_pad($finMois,2,'0',STR_PAD_LEFT) < $finAnneeBU.str_pad($finMoisBU,2,'0',STR_PAD_LEFT) )) {
        
        if ($recover==true) { // Check if new affectation periods covers other periods
            $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
            La Période d\'affectation choisie recouvre une déjà existante!. </div>';
        }
        elseif (  $debutAnnee.str_pad($debutMois,2,'0',STR_PAD_LEFT) > $finAnnee.str_pad($finMois,2,'0',STR_PAD_LEFT)) { // Check if new months are in good order
            $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
            Les Années et/ou Mois de fin sont antérieur au début!. </div>';
        }
        else {
            if ($debutAnnee.str_pad($debutMois,2,'0',STR_PAD_LEFT) > $debutAnneeBU.str_pad($debutMoisBU,2,'0',STR_PAD_LEFT) or $finAnnee.str_pad($finMois,2,'0',STR_PAD_LEFT) < $finAnneeBU.str_pad($finMoisBU,2,'0',STR_PAD_LEFT) ) { 
                $message="caution".":".$idCollab.":".$task.":".$debutMois.":".$debutMoisBU.":".$finMois.":".$finMoisBU.":".$idTJM[1].":".$debutAnnee
                        .":".$tjm.":".$budgetInit.":".$budgetComp.":".$volJoursInit.":".$volJoursComp.":".$fraisInit.":".$fraisComp.":".$autresCouts.":".$isow.":".$sowid.":".$odm.":".$fop.":".$coverage.":".$finAnnee.":".$debutAnneeBU.":".$finAnneeBU;
            }

        }

}
else {
        $nbInputOK=0;
        $nbInputKO=0;
       // Cas où les mois sont affectés en plus
       if ( $debutAnnee.str_pad($debutMois,2,'0',STR_PAD_LEFT) < $debutAnneeBU.str_pad($debutMoisBU,2,'0',STR_PAD_LEFT) ) {

            $i=$debutAnnee;
            $j=$debutMois;
            

            while ($i.str_pad($j,2,'0',STR_PAD_LEFT)  < $debutAnneeBU.str_pad($debutMoisBU,2,'0',STR_PAD_LEFT) ) {

                if (insertImputation($i,$j,$idCollab,$task,0,0)) {
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
                
                if (insertImputation($i,$j,$idCollab,$task,0,0)) {
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


       $fieldsArray = array('Valeur' =>$tjm,'BudgetInit' =>$budgetInit,'BudgetComp' =>$budgetComp,'VolJourInit' =>$volJoursInit,
       'VolJourComp' =>$volJoursComp,'FraisInit' =>$fraisInit,'FraisComp' =>$fraisComp,'AutresCouts' =>$autresCouts,'Annee_Debut' =>$debutAnnee,'Mois_Debut' =>$debutMois
       ,'Annee_Fin' =>$finAnnee,'Mois_Fin' =>$finMois,'ISOW' =>$isow,'SOW_ID' =>$sowid,'ODM' =>$odm,'FOP' =>$fop,'coverage'=>$coverage);
       $nbSuccess=0;
       $nbFailure=0;
       

        foreach ($fieldsArray as $key => $value) {
            if (checkTJMFieldUpdated($key,$value,$idTJM[1]) and updateTJM($key,$value,$idTJM[1])) {
                $nbSuccess+=1;
                /* if ($key=='Mois_Debut' and $debutMois < $debutMoisBU) {
                    for ($i=$debutMois; $i<$debutMoisBU ; $i++) { 
                        if (insertImputation($debutAnnee,$i,$idCollab,$task,0,0)) {
                            $nbInputOK++;
                        }
                        else {
                            $nbInputKO++;
                        }
                    }
                }
                elseif ($key=='Mois_Fin' and $finMois > $finMoisBU) {
                    for ($i=$finMoisBU+1; $i<=$finMois ; $i++) { 
                        if (insertImputation($debutAnnee,$i,$idCollab,$task,0,0)) {
                            $nbInputOK++;
                        }
                        else {
                            $nbInputKO++;
                        }
                    }
                } */
            }
            elseif (checkTJMFieldUpdated($key,$value,$idTJM[1]) and !updateTJM($key,$value,$idTJM[1])) {
                $nbFailure+=1;
            }
        }

        if ($nbFailure==0 and $nbSuccess!=0 ) {
            $message1='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Mise(s) à jour effectuée(s) avec <strong>Success!</strong> .</div>';
        }
        elseif ($nbFailure!=0 ) {
            $message1='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button>'.$nbFailure.' Erreur(s) de Mise à jour !</div>';
        }elseif ($nbFailure==0 and $nbSuccess==0) {
            $message1='<div class="alert   alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Aucune Mise à jour effectuée .</div>';
        }
        $message2="";
        $message3="";
        if ($nbInputOK==0 and $nbInputKO==0) {
            $message2.='<div class="alert   alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Aucune Imputation effectuée .</div>';
        }
        else {
            if ($nbInputOK>0) {
                $message2.='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button>'.$nbInputOK.' succès d\'imputation(s) </div>';
            }
            if ($nbInputKO>0) {
                $message2='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button>'.$nbInputKO.' echecs d\'imputation(s) </div>';
            }
        }
        
        $message=$message1.$message2;
} 


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