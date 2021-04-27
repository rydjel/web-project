<?php
require("../frontend.php");
$db = dbConnect();
$year=$_POST["year"];
$initMonth=$_POST["initMonth"];
$lastMonth=$_POST["lastMonth"];
$lastYear=$_POST["lastYear"];

$fy=$year;
$ly=$lastYear;
$diffyear=$ly-$fy;
$diffyear;
if($ly-$fy==1){
$nbMonth=(12 - $initMonth+1)+$lastMonth ;  
} else if ($ly-$fy==0){
    $nbMonth=$lastMonth - $initMonth + 1 ;
}

$DarrayMonth=array();
$indexTab=array();
for ($i=0; $i < $nbMonth ; $i++) {
    $j=$initMonth+$i;
    if ($j<13)
    { $curyear=$year;
    $month_proc=$j;
    $DarrayMonth[$i]=array("$month_proc","$curyear");}
    else{$curyear=$year+1;
            $month_proc=$j-12;
            $DarrayMonth[$i]=array("$month_proc","$curyear");}
    
    $monthIndexTab[$month_proc.'-'.$curyear]=$i;
        
}



//$taskList=projectTaskList($_POST["project"]);
// Recup charges de la Tâche
$listCharges=getPRChargesCollabgivenYearMonth($_POST["collab"],$year,$_POST["task"],$initMonth,$lastMonth,$lastYear); // -------- MODIFY !!!!!!!!!
$arrayCharges=array();
for ($i=0; $i < $nbMonth ; $i++) { 
    $arrayCharges[$i]="disabled";
}

/* for ($i=$initMonth; $i <=$lastMonth ; $i++) { 
    $arrayCharges[$i]="disabled";
} */
if ($listCharges) {
    while ($data=$listCharges->fetch()) {
        $arrayCharges[$monthIndexTab[$data['mois'].'-'.$data['Annee']]]='0';
    }
}

$i=0;
$listValues=array();
foreach ($DarrayMonth as list($month_value, $year_value)) {
    
    if ($arrayCharges[$i]=="disabled") {
        array_push($listValues,'<td></td>','<td></td>');
        //$list.='<td></td><td></td>';
    }
    else {
        $list=''; // Initialisation
        $list.='<td><input type="number" step="any" min="0" name=taskNoneIntAffPlanMonth-'.$month_value.'-'.$year_value.' value=0'; 
        if($year_value<date("Y") or ($year_value==date("Y") and $month_value<=date("n"))){$list.=" disabled class=inputDisabled";}
        $list.='></td>';
        array_push($listValues,$list);
        $list=''; // Initialisation
        $list.='<td><input type="number" step="any" min="0" name=taskNoneIntAffRealMonth-'.$month_value.'-'.$year_value.' value=0';
        if($year_value>date("Y") or ($year_value==date("Y") and $month_value>date("n"))){$list.=" disabled class=inputDisabled";}
        $list.='></td>';
        array_push($listValues,$list);

    }

    $i++;
}







/* for ($i=$initMonth; $i <=$lastMonth ; $i++) {   // -------- MODIFY !!!!!!!!!!!!!!!!!!!! use count
    if ($arrayCharges[$i]=="disabled") {
        array_push($listValues,'<td></td>','<td></td>');
        //$list.='<td></td><td></td>';
    }
    else {
        $list=''; // Initialisation
        $list.='<td><input type="number" step="any" min="0" name=taskNoneIntAffPlanMonth-'.$i.' value=0'; 
        if($year<date("Y") or ($year==date("Y") and $i<=date("n"))){$list.=" disabled class=inputDisabled";}
        $list.='></td>';
        array_push($listValues,$list);
        $list=''; // Initialisation
        $list.='<td><input type="number" step="any" min="0" name=taskNoneIntAffRealMonth-'.$i.' value=0';
        if($year>date("Y") or ($year==date("Y") and $i>date("n"))){$list.=" disabled class=inputDisabled";}
        $list.='></td>';
        array_push($listValues,$list);

    }
} */
/* while ($data=$taskList->fetch()) {
    $list.='<option value="'.$data['taskID'].'">'.$data['Nom_Tache'].'</option>';
} */
echo json_encode($listValues);


