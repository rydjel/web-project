<?php
require("../frontend.php");
$details=''; // Collab Charges details
$nbInputNeg=0;


// -------------------------------------------------------------- CALCUL EVENTUELLES MISES A JOURS-----------------------------------------------------------------------------------
$initMonth=$_POST['InitMonthChargesCollab'];
$lastMonth=$_POST['LastMonthChargesCollab'];
$year=$_POST['yearChargesCollab'];
$lastYear=$_POST['LastyearChargesCollab'];
$idCollab=$_POST['collab'];

// Access to the collab PU name
$collabPU=getACollabPU($idCollab);
$collabPU=$collabPU->fetch();
//---------------------------------

/*******************************************************************************************************************************************/
//---- List of monthly total charges - in database
/* $totalPlannedChargesDB=array();
$totalRealChargesDB=array();
for ($i=$initMonth; $i <= $lastMonth ; $i++) {
    $monthTotalInDB=sumMonthChargesFilteredYear($i,$idCollab,$year); 
    $monthTotalInDB=$monthTotalInDB->fetch();
    $totalPlannedChargesDB[$i]=$monthTotalInDB['sommePlan'];
    $totalRealChargesDB[$i]=$monthTotalInDB['sommeReal'];
} */

//---- List of number of working days and monthly total charges (in database)

$fy=$year;
$ly=$lastYear;
$diffyear=$ly-$fy;
$diffyear;
if($ly-$fy==1) {
$nbMonth=(12 - $initMonth + 1)+$lastMonth ;  
} else if ($ly-$fy==0){
   $nbMonth=$lastMonth - $initMonth + 1;
}

$monthIndexTab=array();
$wdCollabFiltered=array();
$totalPlannedChargesDB=array();
$totalRealChargesDB=array();
for ($i=0; $i < $nbMonth ; $i++) {
    $j=$initMonth+$i;
    if ($j<13)
    { $curyear=$year;
    $month_proc=$j;}
    else{$curyear=$year+1;
         $month_proc=$j-12;}
    $workingDaysCollabF=workingDaysCollabGivenYearMonth($curyear,$month_proc,$idCollab); // Jours ouvrables 
    $data=$workingDaysCollabF->fetch();
    $wdCollabFiltered[$i]=$data['NbJours'];

    $monthTotalInDB=sumMonthChargesFilteredYear($month_proc,$idCollab,$curyear); 
    $monthTotalInDB=$monthTotalInDB->fetch();
    $totalPlannedChargesDB[$i]=$monthTotalInDB['sommePlan'];
    $totalRealChargesDB[$i]=$monthTotalInDB['sommeReal'];

    $monthIndexTab[$month_proc.'-'.$curyear]=$i;
}

//----- List of months in excess of 
$monthsInputAno=array();
// $monthsInputAnoPlan=array();
// $monthsInputAnoReal=array();

//----- Months detailed
$monthsDetailed=array('1' => 'Janvier','2' => 'Fevrier','3' => 'Mars','4' => 'Avril','5' => 'Mai','6' => 'Juin','7' => 'Juillet',
'8' => 'Aout','9' => 'Septembre','10' => 'Octobre','11' => 'Novembre','12' => 'Decembre' );

/********************************************************************************************************************************************/

$listDbImp=getPRChargesCollabAllTasksgivenYearMonth($idCollab,$year,$initMonth,$lastMonth,$lastYear); // Corrigé !!
$nbSuccess=0;
$nbFailure=0;
// Cas des taches imputées initialement avec charges non nulles
while ($data=$listDbImp->fetch()) {

    if (isset($_POST["Plan-ID-".$data['ID']]) and $_POST["Plan-ID-".$data['ID']]=="") {
        $_POST["Plan-ID-".$data['ID']]=0;
    }

    if (isset($_POST["Real-ID-".$data['ID']]) and $_POST["Real-ID-".$data['ID']]=="") {
        $_POST["Real-ID-".$data['ID']]=0;
    }

    if (isset($_POST["Plan-ID-".$data['ID']]) and $_POST["Plan-ID-".$data['ID']]!=$data['NbJoursPlan']) {

        if ($_POST["Plan-ID-".$data['ID']] > $data['NbJoursPlan'] and
           ($_POST["Plan-ID-".$data['ID']] - $data['NbJoursPlan'] + $totalPlannedChargesDB[$monthIndexTab[$data['mois'].'-'.$data['Annee']]])>$wdCollabFiltered[$monthIndexTab[$data['mois'].'-'.$data['Annee']]]
            and !in_array($data['mois'].'-'.$data['Annee'] ,$monthsInputAno)) { // imputations dépassent le nb de jours ouvrables

               array_push($monthsInputAno,$data['mois'].'-'.$data['Annee']);
               
            } 
        else 
            {

                if (updateAffectation('NbJoursPlan',$_POST["Plan-ID-".$data['ID']],$data['ID']) and updateAffectation('NbJoursReal',$_POST["Plan-ID-".$data['ID']],$data['ID']) ) {
                    $nbSuccess+=1;
                    $totalPlannedChargesDB[$monthIndexTab[$data['mois'].'-'.$data['Annee']]]+=$_POST["Plan-ID-".$data['ID']]-$data['NbJoursPlan'];
                    $totalRealChargesDB[$monthIndexTab[$data['mois'].'-'.$data['Annee']]] += $_POST["Plan-ID-".$data['ID']]-$data['NbJoursPlan'];
                }
                else{
                    $nbFailure+=1;
                }

            }        
    }

    if (isset($_POST["Real-ID-".$data['ID']]) and $_POST["Real-ID-".$data['ID']]!=$data['NbJoursReal']) {

        if ($_POST["Real-ID-".$data['ID']] > $data['NbJoursReal'] and 
            ($_POST["Real-ID-".$data['ID']] - $data['NbJoursReal'] + $totalRealChargesDB[$monthIndexTab[$data['mois'].'-'.$data['Annee']]]) >$wdCollabFiltered[$monthIndexTab[$data['mois'].'-'.$data['Annee']]]
            and !in_array($data['mois'].'-'.$data['Annee'],$monthsInputAno)) { // imputations dépassent le nb de jours ouvrables

               array_push($monthsInputAno,$data['mois'].'-'.$data['Annee']);
               
            } 
        else 
            {

                if (updateAffectation('NbJoursReal',$_POST["Real-ID-".$data['ID']],$data['ID'])) {
                    $nbSuccess+=1;
                    $totalRealChargesDB[$monthIndexTab[$data['mois'].'-'.$data['Annee']]] +=$_POST["Real-ID-".$data['ID']]-$data['NbJoursReal'];
                }
                else{
                    $nbFailure+=1;
                }

            }

    }
    
}

//Tache non interne sélectionnée avec charge nulle
$idTaskNINull=$_POST['listTaskProjNoneInternNullCharges'];
if ($idTaskNINull != "") {
    $listChargesNINull=getPRChargesCollabgivenYearMonth($idCollab,$year,$idTaskNINull,$initMonth,$lastMonth,$lastYear);
    while ($data=$listChargesNINull->fetch()) {

        if (isset($_POST["taskNoneIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']] ) and $_POST["taskNoneIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']]=="") {
            $_POST["taskNoneIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']]=0;
        }

        if (isset($_POST["taskNoneIntAffRealMonth-".$data['mois'].'-'.$data['Annee']] ) and $_POST["taskNoneIntAffRealMonth-".$data['mois'].'-'.$data['Annee']]=="") {
            $_POST["taskNoneIntAffRealMonth-".$data['mois'].'-'.$data['Annee']]=0;
        }

        if (isset($_POST["taskNoneIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']]) and ($_POST["taskNoneIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']]!=$data['NbJoursPlan'])) {
            
            if ( ($_POST["taskNoneIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']] + $totalPlannedChargesDB[$monthIndexTab[$data['mois'].'-'.$data['Annee']]] ) > $wdCollabFiltered[$monthIndexTab[$data['mois'].'-'.$data['Annee']]]
                and !in_array($data['mois'].'-'.$data['Annee'],$monthsInputAno) ) {

                    array_push($monthsInputAno,$data['mois'].'-'.$data['Annee']);

            }
            elseif(updateAffectation('NbJoursPlan',$_POST["taskNoneIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']],$data['ID']) 
            and updateAffectation('NbJoursReal',$_POST["taskNoneIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']],$data['ID'])) {
                $nbSuccess+=1;
                $totalPlannedChargesDB[$monthIndexTab[$data['mois'].'-'.$data['Annee']]] +=$_POST["taskNoneIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']];
                $totalRealChargesDB[$monthIndexTab[$data['mois'].'-'.$data['Annee']]] +=$_POST["taskNoneIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']];
            }
            elseif (!updateAffectation('NbJoursPlan',$_POST["taskNoneIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']],$data['ID'])) {
                $nbFailure+=1;
            }

        }


        if (isset($_POST["taskNoneIntAffRealMonth-".$data['mois'].'-'.$data['Annee']]) and ($_POST["taskNoneIntAffRealMonth-".$data['mois'].'-'.$data['Annee']]!=$data['NbJoursReal'])) {
            
            if ( ($_POST["taskNoneIntAffRealMonth-".$data['mois'].'-'.$data['Annee']] + $totalRealChargesDB[$monthIndexTab[$data['mois'].'-'.$data['Annee']]] ) > $wdCollabFiltered[$monthIndexTab[$data['mois'].'-'.$data['Annee']]]
                and !in_array($data['mois'].'-'.$data['Annee'],$monthsInputAno)) {

                    array_push($monthsInputAno,$data['mois'].'-'.$data['Annee']);

            }
            elseif(updateAffectation('NbJoursReal',$_POST["taskNoneIntAffRealMonth-".$data['mois'].'-'.$data['Annee']],$data['ID'])) {
                $nbSuccess+=1;
                $totalRealChargesDB[$monthIndexTab[$data['mois'].'-'.$data['Annee']]] +=$_POST["taskNoneIntAffRealMonth-".$data['mois'].'-'.$data['Annee']];
            }
            elseif (!updateAffectation('NbJoursReal',$_POST["taskNoneIntAffRealMonth-".$data['mois'].'-'.$data['Annee']],$data['ID'])) {
                $nbFailure+=1;
            }

        }



/*         if (isset($_POST["taskNoneIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']]) and $_POST["taskNoneIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']]!=$data['NbJoursPlan'] 
        and updateAffectation('NbJoursPlan',$_POST["taskNoneIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']],$data['ID']) and updateAffectation('NbJoursReal',$_POST["taskNoneIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']],$data['ID']) ) {
            $nbSuccess+=1;
        }
        elseif (isset($_POST["taskNoneIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']]) and $_POST["taskNoneIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']]!=$data['NbJoursPlan'] and !updateAffectation('NbJoursPlan',$_POST["taskNoneIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']],$data['ID'])) {
            $nbFailure+=1;
        }
        if (isset($_POST["taskNoneIntAffRealMonth-".$data['mois'].'-'.$data['Annee']]) and $_POST["taskNoneIntAffRealMonth-".$data['mois'].'-'.$data['Annee']]!=$data['NbJoursReal'] and updateAffectation('NbJoursReal',$_POST["taskNoneIntAffRealMonth-".$data['mois'].'-'.$data['Annee']],$data['ID'])) {
            $nbSuccess+=1;
        }
        elseif (isset($_POST["taskNoneIntAffRealMonth-".$data['mois'].'-'.$data['Annee']])  and $_POST["taskNoneIntAffRealMonth-".$data['mois'].'-'.$data['Annee']]!=$data['NbJoursReal'] and !updateAffectation('NbJoursReal',$_POST["taskNoneIntAffRealMonth-".$data['mois'].'-'.$data['Annee']],$data['ID'])){
            $nbFailure+=1;
        } */

    }
}

//Tache Interne imputée initialement avec charge nulle
$idTaskINull=$_POST['listTaskProjInternNullCharges'];
if ($idTaskINull != "") {
    $listChargesINull=getPRChargesCollabgivenYearMonth($idCollab,$year,$idTaskINull,$initMonth,$lastMonth,$lastYear);
    while ($data=$listChargesINull->fetch()) {

        if (isset($_POST["taskIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']]) and $_POST["taskIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']]=="") {
            $_POST["taskIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']]=0;
        }

        if (isset($_POST["taskIntAffRealMonth-".$data['mois'].'-'.$data['Annee']]) and $_POST["taskIntAffRealMonth-".$data['mois'].'-'.$data['Annee']]=="") {
            $_POST["taskIntAffRealMonth-".$data['mois'].'-'.$data['Annee']]=0;
        }

        if (isset($_POST["taskIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']]) and ($_POST["taskIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']]!=$data['NbJoursPlan'])) {
            
            if ( ($_POST["taskIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']] + $totalPlannedChargesDB[$monthIndexTab[$data['mois'].'-'.$data['Annee']]] ) > $wdCollabFiltered[$monthIndexTab[$data['mois'].'-'.$data['Annee']]]
                and !in_array($data['mois'].'-'.$data['Annee'],$monthsInputAno)) {

                    array_push($monthsInputAno,$data['mois'].'-'.$data['Annee']);

            }
            elseif(updateAffectation('NbJoursPlan',$_POST["taskIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']],$data['ID']) 
            and updateAffectation('NbJoursReal',$_POST["taskIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']],$data['ID'])) {
                $nbSuccess+=1;
                $totalPlannedChargesDB[$monthIndexTab[$data['mois'].'-'.$data['Annee']]] +=$_POST["taskIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']];
                $totalRealChargesDB[$monthIndexTab[$data['mois'].'-'.$data['Annee']]] +=$_POST["taskIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']];
            }
            elseif (!updateAffectation('NbJoursPlan',$_POST["taskIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']],$data['ID'])) {
                $nbFailure+=1;
            }

        }


        if (isset($_POST["taskIntAffRealMonth-".$data['mois'].'-'.$data['Annee']]) and ($_POST["taskIntAffRealMonth-".$data['mois'].'-'.$data['Annee']]!=$data['NbJoursReal'])) {
            
            if ( ($_POST["taskIntAffRealMonth-".$data['mois'].'-'.$data['Annee']] + $totalRealChargesDB[$monthIndexTab[$data['mois'].'-'.$data['Annee']]] ) > $wdCollabFiltered[$monthIndexTab[$data['mois'].'-'.$data['Annee']]]
                and !in_array($data['mois'].'-'.$data['Annee'],$monthsInputAno)) {

                    array_push($monthsInputAno,$data['mois'].'-'.$data['Annee']);

            }
            elseif(updateAffectation('NbJoursReal',$_POST["taskIntAffRealMonth-".$data['mois'].'-'.$data['Annee']],$data['ID'])) {
                $nbSuccess+=1;
                $totalRealChargesDB[$monthIndexTab[$data['mois'].'-'.$data['Annee']]] +=$_POST["taskIntAffRealMonth-".$data['mois'].'-'.$data['Annee']];
            }
            elseif (!updateAffectation('NbJoursReal',$_POST["taskIntAffRealMonth-".$data['mois'].'-'.$data['Annee']],$data['ID'])) {
                $nbFailure+=1;
            }

        }



       /*  if (isset($_POST["taskIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']])  and $_POST["taskIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']]!=$data['NbJoursPlan'] 
        and updateAffectation('NbJoursPlan',$_POST["taskIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']],$data['ID']) and updateAffectation('NbJoursReal',$_POST["taskIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']],$data['ID']) ) {
            $nbSuccess+=1;
        }
        elseif (isset($_POST["taskIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']])  and $_POST["taskIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']]!=$data['NbJoursPlan'] and !updateAffectation('NbJoursPlan',$_POST["taskIntAffPlanMonth-".$data['mois'].'-'.$data['Annee']],$data['ID'])){
            $nbFailure+=1;
        }
        if (isset($_POST["taskIntAffRealMonth-".$data['mois'].'-'.$data['Annee']])  and $_POST["taskIntAffRealMonth-".$data['mois'].'-'.$data['Annee']]!=$data['NbJoursReal'] and updateAffectation('NbJoursReal',$_POST["taskIntAffRealMonth-".$data['mois'].'-'.$data['Annee']],$data['ID'])) {
            $nbSuccess+=1;
        }
        elseif (isset($_POST["taskIntAffRealMonth-".$data['mois'].'-'.$data['Annee']])  and $_POST["taskIntAffRealMonth-".$data['mois'].'-'.$data['Annee']]!=$data['NbJoursReal'] and !updateAffectation('NbJoursReal',$_POST["taskIntAffRealMonth-".$data['mois'].'-'.$data['Annee']],$data['ID'])) {
            $nbFailure+=1;
        } */
    }
}



// Message selon résultat de la mise à jour
if ($nbFailure==0 and $nbSuccess!=0 ) {
    $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Mise(s) à jour d\'imputation(s) effectuée(s) avec <strong>Success!</strong> .</div>';
}
elseif ($nbFailure!=0 ) {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button>'.$nbFailure.' Erreur(s) de Mise à jour !</div>';
}elseif ($nbFailure==0 and $nbSuccess==0) {
    $message='<div class="alert   alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Aucune Mise à jour effectuée .</div>';
}

$nbNewCommentOK=0;
$nbNewCommentKO=0;
$nbUpdateCommentOK=0;
$nbUpdateCommentKO=0;
// Traitement des commentaires des Imputations
foreach ($_POST as $key => $value) {
    $keyDetails=explode("-",$key);

    if ($keyDetails[0]=="comment") {
        if (!existsCollabImputComment($keyDetails[2],$keyDetails[1]) and $value!="") {
            if (createCollabImputComment($value,$keyDetails[2],$keyDetails[1])) {
                $nbNewCommentOK+=1;
            }
            else {
                $nbNewCommentKO+=1;
            }
        }
        elseif (existsCollabImputComment($keyDetails[2],$keyDetails[1])) {
            if (checkCollabImputCommentFieldUpdated($value,$keyDetails[1],$keyDetails[2]) and updateCollabImputComment($value,$keyDetails[1],$keyDetails[2])) {
                $nbUpdateCommentOK+=1;
            }
            elseif(checkCollabImputCommentFieldUpdated($value,$keyDetails[1],$keyDetails[2]) and !updateCollabImputComment($value,$keyDetails[1],$keyDetails[2])) {
                $nbUpdateCommentKO+=1;
            }
        }
    }

}

// Messages d'informations concernant les commentaires
if ($nbNewCommentOK>0) {
    $message.='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    '.$nbNewCommentOK.' commentaire(s) ajouté(s) avec <strong>Success!</strong> .</div>';
}
if ($nbNewCommentKO>0) {
    $message.='<div class="alert   alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    '.$nbNewCommentKO.' échec(s) de rajout(s) de commentaire(s).</div>';
}
if ($nbUpdateCommentOK>0) {
    $message.='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    '.$nbUpdateCommentOK.' commentaire(s) mis à jour avec <strong>Success!</strong> .</div>';
}
if ($nbUpdateCommentKO>0) {
    $message.='<div class="alert   alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    '.$nbUpdateCommentKO.'échec(s) de mis à jour(s) de commentaire(s).</div>';
}



// ----------------------------------------------------------------- PREPARATION ET AFFICHAGE -----------------------------------------------------------------------------------------

// Choix Année et Mois initiaux
/*$year=date('Y');
$initMonth=date("n")-1;
$lastMonth="12";
$lastYear=date('Y');*/

/* $year=date('Y');
$initMonth=date("n")-1;
$lastMonth=date('n',strtotime('+2 month'));
$lastYear=date('Y',strtotime('+2 month')); */


$listMois = array('1' => 'Janvier' ,'2' => 'Février','3' => 'Mars','4' => 'Avril','5' => 'Mai','6' => 'Juin',
'7' => 'Juillet','8' => 'Août','9' => 'Septembre','10' => 'Octobre','11' => 'Novembre','12' => 'Décembre' );
$totalPlannedCharges=array(); // Array des charges planifiées totales
$totalRealCharges=array(); // Array des charges réelles totales


$fy=$year;
$ly=$lastYear;
$diffyear=$fy-$ly;
$diffyear;
if($ly-$fy==1){
$nbMonth=(12 - $initMonth+1)+$lastMonth ;  
} else if ($ly-$fy==0){
    $nbMonth=$lastMonth - $initMonth + 1 ;
}
if (($diffyear==0) and ($lastMonth<$initMonth)){ 
    throw new Exception("Le mois de début doit être inférieur au mois final");
}
for ($i=0; $i < $nbMonth ; $i++) {
    $j=$initMonth+$i;
    if ($j<13)
    { $curyear=$year;
    $month_proc=$j;}
    else{$curyear=$year+1;
            $month_proc=$j-12;}
    $monthTotal=sumMonthChargesCurrentYear($month_proc,$idCollab,$curyear); 
    $monthTotal=$monthTotal->fetch();
    $totalPlannedCharges[$i]=$monthTotal['sommePlan'];
    $totalRealCharges[$i]=$monthTotal['sommeReal'];
}

$DarrayMonth=array();
for ($i=0; $i<$nbMonth; $i++) {
    $j=$initMonth+$i;
    if ($j<13)
    { $curyear=$year;
    $month_proc=$j;
    $DarrayMonth[$i]=array("$month_proc","$curyear");}
    else{$curyear=$year+1;
            $month_proc=$j-12;
            $DarrayMonth[$i]=array("$month_proc","$curyear");}
        }

$monthIndexTab=array();
$wdCollab=array();

for ($i=0; $i < $nbMonth ; $i++) {
    $j=$initMonth+$i;
    if ($j<13) {
            $curyear=$year;
    $month_proc=$j;}
    else{$curyear=$year+1;
            $month_proc=$j-12;}
    $workingDaysCollab=workingDaysCollabGivenYearMonth($curyear,$month_proc,$idCollab); // Jours ouvrables collaborateurs
    $data=$workingDaysCollab->fetch();
    $wdCollab[$i]=$data['NbJours'];
    $monthIndexTab[$month_proc.'-'.$curyear]=$i;
}

//--------------------- INTERCONTRATS --------------------------------
$planInterco=array(); // Tableau des durées planifiées d'intercontrat
$PI=getPlanInterContract($idCollab,$year,$initMonth,$lastMonth,$lastYear);
if ($PI) {
    while ($data=$PI->fetch()) {
        $planInterco[$monthIndexTab[$data['mois'].'-'.$data['Annee']]]=$data['NbJoursPlan'].'_'.$data['ID'];
    }
}

//--------------------

$realInterco=array(); // Tableau des durées réelles d'intercontrat
$RI=getRealInterContract($idCollab,$year,$initMonth,$lastMonth,$lastYear);
if ($RI) {
    while ($data=$RI->fetch()) {
        $realInterco[$monthIndexTab[$data['mois'].'-'.$data['Annee']]]=$data['NbJoursReal'].'_'.$data['ID'];
    }
}

//----------------------------------------------------------------------


$noneInterntaskList=listNoneInternProjTasksCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth,$lastYear); //liste des activités de type non internes pour l'année sélectionnée
$internTaskList=listInternProjTasksCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth,$lastYear); //Liste des activités de type interne
$yearCollabNoneInternTasks=array();
$yearCollabInternTasks=array();
$projListNoneInternNullCharges=listNoneInternProjNullChargeCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth,$lastYear); // Liste projets non internes avec Charges Totales nulles
$projListInternNullCharges=listInternProjNullChargeCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth,$lastYear); // Liste projets internes avec Charges Totales nulles

// Parsing des tâches pour avoir les charges correspondantes
//------ Cas Activités non internes
if ($noneInterntaskList) {
    $i=1; // début incrément
    while ($data=$noneInterntaskList->fetch()) {
        $yearCollabNoneInternTasks[$i]=$data['Titre']."-".$data['Nom_Tache'].":".$data['idTache'].":".$data['commentaire'].":".$data['TJM'].":".$data['Code'];
        ${"noneInternTaskCharges".$i}=getPRChargesCollabgivenYearMonth($idCollab,$year,$data['idTache'],$initMonth,$lastMonth,$lastYear); // List charges ppour la tâche
        $i++;
    } 
    $nbNoneInternTasks=$i-1; // Nb of none Intern tasks founds
}
for ($i=1; $i<=$nbNoneInternTasks ; $i++) {
    ${"noneInternTaskArrayCharges".$i}=array(); // array charges for the specified Task for filtered year and months
    for ($j=0; $j <$nbMonth ; $j++) { // Initialization of the array
        ${"noneInternTaskArrayCharges".$i}[$j]="disabled";
    }
    //-----
    while ($data=${"noneInternTaskCharges".$i}->fetch()) {
        ${"noneInternTaskArrayCharges".$i}[$monthIndexTab[$data['mois'].'-'.$data['Annee']]] =$data['ID']."-".$data['NbJoursPlan'].'-'.$data['NbJoursReal'];
    }
}

//------ Cas Activités internes
if ($internTaskList) {
    $i=1; // début incrément
    while ($data=$internTaskList->fetch()) {
        $yearCollabInternTasks[$i]=$data['Titre']."-".$data['Nom_Tache'].":".$data['idTache'].":".$data['commentaire'].":".$data['Code'];
        ${"internTaskCharges".$i}=getPRChargesCollabgivenYearMonth($idCollab,$year,$data['idTache'],$initMonth,$lastMonth,$lastYear); // List charges ppour la tâche
        $i++;
    }
    $nbInternTasks=$i-1; // Nb of Intern tasks founds  
}
for ($i=1; $i<=$nbInternTasks ; $i++) {
    ${"internTaskArrayCharges".$i}=array(); // array charges for the specified Task for filtered year and months
    for ($j=0; $j <$nbMonth ; $j++) { // Initialization of the array
        ${"internTaskArrayCharges".$i}[$j]="disabled";
    }
    //-----
    while ($data=${"internTaskCharges".$i}->fetch()) {
        ${"internTaskArrayCharges".$i}[$monthIndexTab[$data['mois'].'-'.$data['Annee']]]=$data['ID']."-".$data['NbJoursPlan'].'-'.$data['NbJoursReal'];
    }
}

$details.='<div class="row">
<div class="col-sm-2">
<label for="selectInitYear">Année</label>
<select id="selectInitYear" class="form-control" name="yearChargesCollab">
    <option value='.(date("Y")-1).'>'.(date("Y")-1).'</option>
    <option value='.date("Y").' selected>'.(date("Y")).'</option>
    <option value='.(date("Y")+1).'>'.(date("Y")+1).'</option>
</select>
</div>
<div class="col-sm-3">
<label for="selectInitMonth">Mois Initial</label>
<select id="selectInitMonth" class="form-control" name="InitMonthChargesCollab">';
foreach ($listMois as $key => $value) {
$details.='<option value="'.$key.'"';
if ($key==$initMonth) {
    $details.=' selected';
}
$details.='>'.$value.'</option>';
}
$details.='</select>
</div>
<div class="col-sm-3">
<label for="selectLastMonth">Mois Final</label>
<select id="selectLastMonth" class="form-control" name="LastMonthChargesCollab">';
foreach ($listMois as $key => $value) {
    $details.='<option value="'.$key.'"';
    if ($key==$lastMonth) {
        $details.=' selected';
    }
    $details.='>'.$value.'</option>';
}
$details.='</select>
</div>
    <div class="col-sm-2">
    <label for="selectFinalYear">Année Finale</label>
    <select id="selectFinalYear" class="form-control" name="LastyearChargesCollab">
        <option value='.($year-1).'>'.($year-1).'</option>
        <option value="'.$year.'"';
        if ($lastYear==$year) {
            $details.=' selected';
        }
        $details.='>'.$year.'</option>
        <option value="'.($year+1).'"';
        if ($lastYear==($year+1)) {
            $details.=' selected';
        }
        $details.='>'.($year+1).'</option>
    </select>
</div>
<br>
    <div class="col-xs-1">
        <button type="button"  id="filter" class="btn btn-primary btn-block filterButton" onclick="collabChargesFilter(\'selectInitYear\',\'selectInitMonth\',\'selectLastMonth\',\'selectFinalYear\',\'collab\');">Filtrer</button>
    </div>
</div>';
$details.='<section class="table-responsive">
<table id="chargesTable">
    <thead>
        <tr>
            <th scope="col">Mois</th>
            <th scope="col"></th>
            <th scope="col">Commentaires</th>';

            $fy=$year;
            $ly=$lastYear;
            if($ly-$fy==1) {
            $nbMonth=(12 - $initMonth + 1)+$lastMonth ;  
            } else if ($ly-$fy==0){
                $nbMonth=$lastMonth - $initMonth + 1 ;
            }
            $DarrayMonth=array();
            for ($i=0; $i < $nbMonth ; $i++) {
                $j=$initMonth+$i;
                if ($j<13)
                { $curyear=$year;
                $month_proc=$j;
                $DarrayMonth[$i]=array("$month_proc","$curyear");}
                else{$curyear=$year+1;
                     $month_proc=$j-12;
                     $DarrayMonth[$i]=array("$month_proc","$curyear");}
                    }

foreach($DarrayMonth as list($month_value, $year_value)){ 
    $details.='<th colspan="2" scope="col" class="colPrincipale">'.$listMois[$month_value].'</th>';
}
$details.='</tr>
</thead>
<tbody>
    <tr>
        <th scope="row">Forecast(F) - Réalisé(R)</th>
        <th rowspan="3"></th>
        <th rowspan="3"></th>';
foreach($DarrayMonth as list($month_value, $year_value)) { 
    $details.='<td class="bordGauche">F</td>
            <td class="bordDroit">R</td>';
}
$details.='</tr>                   
    <tr>
    <th scope="row">Jours Ouvrables Collaborateur</td>';

    $fy=$year;
    $ly=$lastYear;
    if($ly-$fy==1) {
    $nbMonth=(12 - $initMonth + 1)+$lastMonth ;  
    } else if ($ly-$fy==0){
        $nbMonth=$lastMonth - $initMonth + 1 ;
    }
    $DarrayMonth=array();
    for ($i=0; $i < $nbMonth; $i++) {
        $j=$initMonth+$i;
        if ($j<13)
        { $curyear=$year;
        $month_proc=$j;
        $DarrayMonth[$i]=array("$month_proc","$curyear");}
        else{$curyear=$year+1;
             $month_proc=$j-12;
             $DarrayMonth[$i]=array("$month_proc","$curyear");}
            }

   if (!empty($wdCollab)) {
       $i=0;
       foreach($DarrayMonth as list($month_value, $year_value)){ 
        $details.='<td class="bordGauche">'.$wdCollab[$i].'</td>
        <td class="bordDroit">'.$wdCollab[$i].'</td>';
        $i++;
    }
}
$details.='</tr>
<tr>
<th scope="row">'.$collabPU['Nom'].'-Intercontrats</th>';
if (!empty($wdCollab) and !empty($totalPlannedCharges) and !empty($totalRealCharges)) {

    $nbUpdatePIOK=0; // nb Maj Interco Planifiées OK
    $nbUpdatePIKO=0;
    $nbUpdateRIOK=0; // nb Maj Interco Réels OK
    $nbUpdateRIKO=0;

    $i=0;
    foreach($DarrayMonth as list($month_value, $year_value)){
        $ecartPlan=$wdCollab[$i]-$totalPlannedCharges[$i];
        $ecartReal=$wdCollab[$i]-$totalRealCharges[$i];

        if (array_key_exists($i,$planInterco)) {

            $detailPI=explode("_",$planInterco[$i]);

            if (strval($ecartPlan)!=$detailPI[0] and updateAffectation('NbJoursPlan',$ecartPlan,$detailPI[1])) {
                $nbUpdatePIOK+=1;
            }
            elseif (strval($ecartPlan)!=$detailPI[0] and !updateAffectation('NbJoursPlan',$ecartPlan,$detailPI[1])) {
                $nbUpdatePIKO+=1;
            }

        }

        if (array_key_exists($i,$realInterco)) {

            $detailRI=explode("_",$realInterco[$i]);
        
            if (strval($ecartReal)!=$detailRI[0] and updateAffectation('NbJoursReal',$ecartReal,$detailRI[1])) {
                $nbUpdateRIOK+=1;
            }
            elseif (strval($ecartReal)!=$detailRI[0] and !updateAffectation('NbJoursReal',$ecartReal,$detailRI[1])) {
                $nbUpdateRIKO+=1;
            }

        }
        
        $details.='<td class="bordGauche';
        if ($ecartPlan<0) {
            $details.=' ecartNegatif';
            $nbInputNeg=$nbInputNeg+1;
        }
        $details.='">'.$ecartPlan.'</td>
        <td class="bordDroit';
        if ($ecartReal<0) {
            $details.=' ecartNegatif';
            $nbInputNeg=$nbInputNeg+1;
        }
        $details.='">'.$ecartReal.'</td>';
        $i++;
    }

    // Message selon résultat de la mise à jour
    if ($nbUpdatePIKO==0 and $nbUpdateRIKO==0 and ($nbUpdateRIOK!=0 or $nbUpdatePIOK!=0)) {
        $message.='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;
        </button> Mise(s) à jour d\'Intercontrat(s) effectuée(s) avec <strong>Success!</strong> .</div>';
    }
    elseif ($nbUpdatePIOK==0 and $nbUpdateRIOK==0 and ($nbUpdateRIKO!=0 or $nbUpdatePIKO!=0)) {
        $totalError=$nbUpdateRIKO+$nbUpdatePIKO;
        $message.='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;
        </button>'.$totalError.' Erreur(s) de Mise à jour pour les Intercontrats !</div>';
    }elseif ($nbUpdatePIOK==0 and $nbUpdateRIOK==0 and $nbUpdateRIKO==0 or $nbUpdatePIKO==0) {
        $message.='<div class="alert   alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;
        </button> Aucune Mise à jour d\'intercontrat effectuée .</div>';
    }

}

$details.='</tr>
<tr>
    <th scope="row" class="withInput">Activités Client</th> 
</tr>';

if (!empty($yearCollabNoneInternTasks)) {
    foreach ($yearCollabNoneInternTasks as $key => $value) {
        $values=explode(":",$value);
        $details.='<tr>
        <th scope="row">'.$values[0].'-'.$values[3].'-'.$values[4].'</td>
        <td>
        <button name="accessProjModif" type="submit" class="buttonMP" title="Modification Projet" value="'.$values[4].'">MP</button>
        <button name="accessAffModif" type="submit" class="buttonMA" title="Modification Affectations" value="'.$values[4].'">MA</button>
        </td>
        <td><input type="text" class="comment" pattern=\'[^:"]+\' oninvalid="this.setCustomValidity(\'Les doubles quotes et deux-points sont interdits\')"
        name="comment-'.$values[1].'-'.$idCollab.'" value="'.$values[2].'"></td>';
        
        $j=0;
        foreach($DarrayMonth as list($month_value, $year_value)) {  // -------- CHECK !!!!!!!!!!!!!!!!!!!!!
            
            if (${"noneInternTaskArrayCharges".$key}[$j]=="disabled") {
                $details.='<td class="bordGauche"></td><td class="bordDroit"></td>';
            }   
            else {
                $data=explode("-",${"noneInternTaskArrayCharges".$key}[$j]);
                $details.='<td class="bordGauche"><input type="number" step="any" min="0" name="Plan-ID-'.$data[0].'" value="'.$data[1].'"';
                if ($year_value < date("Y") or ($year_value==date("Y") and $month_value<=date("n"))) { // ---------- CHECK !!!!!!!!!!!!!!!!!!!!!!!!!!!!
                    $details.=' disabled class="inputDisabled"';
                }
                $details.='></td>
                <td class="bordDroit"><input type="number" step="any" min="0" name="Real-ID-'.$data[0].'" value="'.$data[2].'"';
                if ($year_value>date("Y") or ($year_value==date("Y") and $month_value>date("n"))) { // ----------- CHECK  !!!!!!!!!!!!!!!!!!!!!!!!!!!
                    $details.=' disabled class="inputDisabled"';
                }
                $details.='></td>';
            }
          $j++;  
        }
    }
}
$details.='<tr>
<th scope="row">
<select id="listProjNoneInternNullCharges" name="listProjNoneInternNullCharges"
onchange="getNIProjectTaskList(this.value,\'listTaskProjNoneInternNullCharges\',\''.$idCollab.'\',\'selectInitYear\',\'selectInitMonth\',\'selectLastMonth\',\'selectFinalYear\');">
    <option value=""></option>';

if ($projListNoneInternNullCharges) {
    while ($data=$projListNoneInternNullCharges->fetch()) {
        $details.='<option value='.$data['idProj'].'>'.$data['Code'].'-'.$data['Titre'].'</option>';
    }
}
$details.='</select>
<select id="listTaskProjNoneInternNullCharges" name="listTaskProjNoneInternNullCharges"
onchange="getNoneInternTaskChargesList(this.value,\''.$idCollab.'\',\'select\',\'selectInitMonth\',\'selectLastMonth\');
getTaskInputComment(this.value,\''.$idCollab.'\',\'NITaskNullChargesComment\')">
        <option value=""></option>
    </select>
</th>
<td></td>
<td><input type="text" class="comment" pattern=\'[^:"]+\' oninvalid="this.setCustomValidity(\'Les doubles quotes et deux-points sont interdits\')" id="NITaskNullChargesComment"></td>';

$j=0;
$k=1;
foreach($DarrayMonth as list($month_value, $year_value)) { 
    $details.='<td id="taskNoneIntAffMonth-'.$j.'" class="bordGauche"></td>
    <td id="taskNoneIntAffMonth-'.$k.'" class="bordDroit"></td>';
    $j=$j+2;
    $k=$k+2;
}
$details.='</tr> 
<tr>
    <th scope="row" class="withInput">Activités Internes</th> 
</tr>';


if (!empty($yearCollabInternTasks)) {
    $j=0;
    foreach ($yearCollabInternTasks as $key => $value) {
        
        $values=explode(":",$value);
        $details.='<tr>
        <th scope="row">'.$values[0].'-'.$values[3].'</td>
        <td><button name="accessProjModif" title="Modification Projet" type="submit" value="'.$values[3].'">MP</button></td>
        <td><input type="text" class="comment" pattern=\'[^:"]+\' oninvalid="this.setCustomValidity(\'Les doubles quotes et deux-points sont interdits\')"
        name="comment-'.$values[1].'-'.$idCollab.'" value="'.$values[2].'"></td>';
        $j=0;
        foreach($DarrayMonth as list($month_value, $year_value)) {  // -------- CHECK !!!!!!!!!!!!!!!!!!!!!
            if (${"internTaskArrayCharges".$key}[$j]=="disabled") {
                $details.='<td class="bordGauche"></td><td class="bordDroit"></td>';
            }   
            else {
                $data=explode("-",${"internTaskArrayCharges".$key}[$j]);
                $details.='<td class="bordGauche"><input type="number" step="any" min="0" name="Plan-ID-'.$data[0].'" value="'.$data[1].'"';
                if ($year_value < date("Y") or ($year_value==date("Y") and $month_value<=date("n"))) { // ---------- CHECK !!!!!!!!!!!!!!!!!!!!!!!!!!!!
                    $details.=' disabled class="inputDisabled"';
                }
                $details.='></td>
                <td class="bordDroit"><input type="number" step="any" min="0" name="Real-ID-'.$data[0].'" value="'.$data[2].'"';
                if ($year_value>date("Y") or ($year_value==date("Y") and $month_value>date("n"))) { // ----------- CHECK  !!!!!!!!!!!!!!!!!!!!!!!!!!!
                    $details.=' disabled class="inputDisabled"';
                }
                $details.='></td>';
            }
          
            $j++;
        }
         
    }

    
}
$details.='<tr>
<th scope="row">
        <select id="listProjInternNullCharges" name="listProjInternNullCharges"
        onchange="getProjectTaskList(this.value,\'listTaskProjInternNullCharges\',\''.$idCollab.'\',
        \'selectInitYear\',\'selectInitMonth\',\'selectLastMonth\',\'selectFinalYear\');">
            <option value=""></option>';
    if ($projListInternNullCharges) {
        while ($data=$projListInternNullCharges->fetch()) {
            $details.='<option value='.$data['idProj'].'>'.$data['Titre'].'</option>';
        }
    }
$details.='</select>
<select id="listTaskProjInternNullCharges" name="listTaskProjInternNullCharges"
    onchange="getInternTaskChargesList(this.value,\''.$idCollab.'\',\'selectInitYear\',\'selectInitMonth\',\'selectLastMonth\',\'selectFinalYear\');
    getTaskInputComment(this.value,\''.$idCollab.'\',\'ITaskNullChargesComment\')">
            <option value=""></option>
    </select>
</th>
<td></td>
<td><input type="text" class="comment" pattern=\'[^:"]+\' oninvalid="this.setCustomValidity(\'Les doubles quotes et deux-points sont interdits\')" id="ITaskNullChargesComment"></td>';
$j=0;
$k=1;
foreach($DarrayMonth as list($month_value, $year_value)) { 
    $details.='<td id="taskIntAffMonth-'.$j.'" class="bordGauche"></td>
    <td id="taskIntAffMonth-'.$k.'" class="bordDroit"></td>';
    $j=$j+2;
    $k=$k+2;
}
$details.='</tr>
            </tbody>
            </table>
            </section>';  

if ($nbInputNeg>0) {
    $message.='<div class="alert   alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;
    </button> <strong>Warning!</strong> Une ou plusieurs imputations mensuelles sont supérieures au nombre de jours ouvrés disponibles dans leur(s) mois. </div>';
}

// Modif message en fonction de Mois en anomalies (Imputations en exces)
if (count($monthsInputAno) > 0) {
    $message='<div class="alert   alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;
    </button> <strong>Erreur!</strong> Le/Les mois suivant(s) présente(nt) un total d\'imputations supérieur au nombre de jours ouvrables mensuel : ';
    foreach ($monthsInputAno as $value) {
        $valueDetails=explode("-",$value);
        $monthAno=$valueDetails[0];
        $yearAno=$valueDetails[1];
        $message.="$monthsDetailed[$monthAno]"."-".$yearAno;
        $message.=" ";
    }
    $message.='</div>';
    $details="";
}

echo $message.":_:_:".$details;