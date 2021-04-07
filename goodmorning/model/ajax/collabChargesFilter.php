<?php
require("../frontend.php");
$details=''; // Collab Charges details
$message='';
$nbInputNeg=0;
if ($_POST['idCollab'] !=="Sélectionner un Collaborateur ...") {
    $year=$_POST['year'];
    $initMonth=$_POST['initMonth'];
    $lastMonth=$_POST['lastMonth'];
    $lastYear=$_POST['lastYear'];
    $idCollab=$_POST['idCollab'];

    // Access to the collab PU name
    $collabPU=getACollabPU($idCollab);
    $collabPU=$collabPU->fetch();


    $listMois = array('1' => 'Janvier' ,'2' => 'Février','3' => 'Mars','4' => 'Avril','5' => 'Mai','6' => 'Juin',
    '7' => 'Juillet','8' => 'Août','9' => 'Septembre','10' => 'Octobre','11' => 'Novembre','12' => 'Décembre' );
    $totalPlannedCharges=array(); // Array des charges planifiées totales
    $totalRealCharges=array(); // Array des charges réelles totales
    
    # Algo pour alimenter les tableaux

    $fy=$year;
    $ly=$lastYear;
    $diffyear=$fy-$ly;
    $diffyear;
    if($ly-$fy==1){
    $nbMonth=(12 - $initMonth + 1)+$lastMonth ;  
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
    $noneInterntaskList=listNoneInternProjTasksCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth,$lastYear); //liste des activités de type non internes pour les années sélectionnées
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
    for ($i=1; $i<=$nbNoneInternTasks ; $i++) { # To check
        ${"noneInternTaskArrayCharges".$i}=array(); // array charges for the specified Task for filtered year and months
        /* for ($j=$initMonth; $j <=$lastMonth ; $j++) { // Initialization of the array  -------------- CHECK !!!!!!!!!!!!!!!!!!!!!!
            ${"noneInternTaskArrayCharges".$i}[$j]="disabled";
        } */

        for ($j=0; $j < $nbMonth ; $j++) { 
            ${"noneInternTaskArrayCharges".$i}[$j]="disabled";
        }
        
        //-----
        while ($data=${"noneInternTaskCharges".$i}->fetch()) {
            ${"noneInternTaskArrayCharges".$i}[$monthIndexTab[$data['mois'].'-'.$data['Annee']]]=$data['ID']."-".$data['NbJoursPlan'].'-'.$data['NbJoursReal'];  // -------------------- CHECK !!!!!!!!!!!!!!!!!!!!!!!!!!!!
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
        for ($j=0; $j < $nbMonth ; $j++) {
            ${"internTaskArrayCharges".$i}[$j]="disabled";
        }
        //-----
        while ($data=${"internTaskCharges".$i}->fetch()) {
            ${"internTaskArrayCharges".$i}[$monthIndexTab[$data['mois'].'-'.$data['Annee']]]=$data['ID']."-".$data['NbJoursPlan'].'-'.$data['NbJoursReal'];
        }
    }

    
    $details.='
    <thead>
    <tr>
        <th scope="col">Mois</th>
        <th scope="col"></th>
        <th scope="col">Commentaires</th>';

        $fy=$year;
        $ly=$lastYear;
        if($ly-$fy==1) {
        $nbMonth=(12 - $initMonth+1)+$lastMonth ;  
        } else if ($ly-$fy==0){
            $nbMonth=$lastMonth - $initMonth+1  ;
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
/* for ($i=$initMonth; $i<=$lastMonth ; $i++) { # Be Careful with index
$details.='<th colspan="2" scope="col" class="colPrincipale">'.$listMois[$i].'</th>';
}
$details.='</tr>
</thead>
<tbody>
<tr>
    <th scope="row">Forecast(F) - Réalisé(R)</th>
    <th rowspan="3"></th>
    <th rowspan="3"></th>';*/
foreach($DarrayMonth as list($month_value, $year_value)){ # Be Careful with index
$details.='<td class="bordGauche">F</td>
        <td class="bordDroit">R</td>';
}
$details.='</tr>                   
<tr>
<th scope="row">Jours Ouvrables Collaborateur</td>';
if (!empty($wdCollab)) {
$i=0;
foreach($DarrayMonth as list($month_value, $year_value)){ # Be Careful with index   --- Use for i=0; i<count(wdCollab); i++
   
    $details.='<td class="bordGauche">'.$wdCollab[$i].'</td>
    <td class="bordDroit">'.$wdCollab[$i].'</td>';
    $i++;
}
}
$details.='</tr>
<tr>
<th scope="row">'.$collabPU['Nom'].'-Intercontrats</th>';
if (!empty($wdCollab) and !empty($totalPlannedCharges) and !empty($totalRealCharges)) {
$i=0;
foreach($DarrayMonth as list($month_value, $year_value)){# Be Careful with index --- Use count(wdCollab)
    
    $ecartPlan=$wdCollab[$i]-$totalPlannedCharges[$i];
    $ecartReal=$wdCollab[$i]-$totalRealCharges[$i];
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
/* selectInityear SelectFinalYear*/ // -------- MODIFY getPRChargesCollabgivenYearMonth  !!!!!!!!!!!!!!!!!!!!!!!!!!!
$details.='</select>
<select id="listTaskProjNoneInternNullCharges" name="listTaskProjNoneInternNullCharges" 
onchange="getNoneInternTaskChargesList(this.value,\''.$idCollab.'\',\'selectInitYear\',\'selectInitMonth\',\'selectLastMonth\',\'selectFinalYear\');

getTaskInputComment(this.value,\''.$idCollab.'\',\'NITaskNullChargesComment\')">
    <option value=""></option>
</select>
</th>
<td></td>
<td><input type="text" class="comment" pattern=\'[^:"]+\' oninvalid="this.setCustomValidity(\'Les doubles quotes et deux-points sont interdits\')" id="NITaskNullChargesComment"></td>';
$j=0;
$k=1;
foreach($DarrayMonth as list($month_value, $year_value)) {   // ---------------- count or nbMonths !!!!!!!!!
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
        </tbody>';  
}
if ($nbInputNeg>0) {
    $message.='<div class="alert   alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;
    </button> <strong>Warning!</strong> Une ou plusieurs imputations mensuelles sont supérieures au nombre de jours ouvrés disponibles dans leur(s) mois. </div>';
}
echo $message.":_:_:".$details;