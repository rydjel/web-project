<?php
require("../frontend.php");
$db = dbConnect();
$region=$_POST['region'];
$role=$_POST['role'];
$code=$_POST['code'];
$grade=$_POST['grade'];
$rateCard=$_POST['rateCard'];
$year=$_POST['year'];

//$dateDebut=$_POST['dateDebut'];
$idExtend=explode("-",$_POST['idExtend']);
$id=$idExtend[1];
if (strpos($code,"\"")!==false or strpos($code,":")!==false or strpos($role,"\"")!==false or strpos($role,":")!==false ) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits.</div>';
}
elseif ($code=="" or $role=="" or $rateCard=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champs Role, Code et ADRC ne doivent pas être vide.</div>';
}
elseif (checkRCFieldUpdated_('Code',$code,$id) and existRateCard($code,$role,$grade,$region,$year)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Code déjà existant. </div>';
}
else {
       $fieldsArray = array('Region' =>$region,'Role' =>$role,'Code' =>$code,'Grade' =>$grade,'RateCard' =>$rateCard);
       $nbSuccess=0;
       $nbFailure=0;
        foreach ($fieldsArray as $key => $value) {
            if (checkRCFieldUpdated_($key,$value,$id) and updateRateCard($key,$value,$id)) {
                $nbSuccess+=1;
            }
            elseif (checkRCFieldUpdated_($key,$value,$id) and !updateRateCard($key,$value,$id)) {
                $nbFailure+=1;
            }
        } 
        if ($nbFailure==0 and $nbSuccess!=0 ) {
            $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Mise(s) à jour effectuée(s) avec <strong>Success!</strong> .</div>';
        }
        elseif ($nbFailure!=0 ) {
            $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button>'.$nbFailure.' Erreur(s) de Mise à jour !</div>';
        }elseif ($nbFailure==0 and $nbSuccess==0) {
            $message='<div class="alert   alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Aucune Mise à jour effectuée .</div>';
        }
}   
echo $message;