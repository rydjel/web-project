<?php
require("../frontend.php");
//$db = dbConnect();
$Nom=$_POST['Nom'];
$Prenom=$_POST['Prenom'];
$ggid=$_POST['ggid'];
$pu=$_POST['pu'];
$Site=$_POST['Site'];
$dateEntree=$_POST['dateEntree'];
$dateSortie=$_POST['dateSortie'];
if ($dateSortie=="") {
    $dateSortie="0000-00-00";
}

$idMoisIn=getMonthID(date("n",strtotime($dateEntree)));
$idMoisIn=$idMoisIn->fetch();
$idMoisOut=getMonthID(date("n",strtotime($dateSortie)));
$idMoisOut=$idMoisOut->fetch();

$statut=$_POST['statut'];
$role=$_POST['role'];
$Grade=$_POST['Grade'];
$RateCard=$_POST['RateCard'];
$pourcentageActivite=$_POST['pourcentageActivite'];
$support=$_POST['support'];
$manager=$_POST['manager'];
$CM=$_POST['CM'];
$commentaire=$_POST['commentaire'];
$id=$_POST['id'];

$inOut=getInOut($id);
$inOut=$inOut->fetch();

$siteRegion=getSiteRegion($Site); // Access to the region
$siteRegion=$siteRegion->fetch();
if ($_POST['cvBook']=='true') {
    $cvBook=1;
}else {
    $cvBook=0;
}
$tjmCible=$_POST['tjmCible'];

//Modification collaborateur
if (strpos($Nom,"\"")!==false or strpos($Prenom,"\"")!==false or strpos($ggid,"\"")!==false or strpos($Grade,"\"")!==false or strpos($commentaire,"\"")!==false
or strpos($Nom,":")!==false or strpos($Prenom,":")!==false or strpos($ggid,":")!==false or strpos($Grade,":")!==false or strpos($commentaire,":")!==false) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    Les caractères double-quote et deux-points sont interdits. </div>';
    $successCreate="KO";
    $newCollabID="";
}
elseif (!is_numeric($pourcentageActivite) or $pourcentageActivite<0 or $pourcentageActivite>100 ) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    Valeur de pourcentage invalide. </div>';
}
elseif (!is_numeric($RateCard) or $RateCard<0) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    Valeur de rateCard invalide. </div>';
}
elseif ($Nom=="" or $Prenom=="" or $ggid=="" or $dateEntree=="" or $Grade=="" or $RateCard=="" or $pourcentageActivite=="" or $role=="") {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    les champs "Nom", "Prenom", "GGID", "Date Entrée", "Grade", "Rate Card" et "Pourcentage Activité" sont <strong>obligatoires<strong>. </div>';
}
elseif ($dateSortie !="0000-00-00" and strtotime($dateEntree) > strtotime($dateSortie)) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    La date d\'entrée est supérieure à la date de sortie. </div>';
    $successCreate="KO";
    $newCollabID="";
}
else {
    // get PU_ID
    $idPU=getPUID($pu);
    $idPU=$idPU->fetch();
    // get ID_rateCard
    $year=date("Y",strtotime($dateEntree));
    //$idRateCard=collabRateCardId($id);
    $idRateCard=rateCardID($RateCard,$role,$Grade,$siteRegion["Region"],date("Y")); // Calculate rateCard ID
    $idRateCard=$idRateCard->fetch();
    if (checkCollabFieldUpdated('GGID',$ggid,$id) and existCollab($ggid)) {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> GGID déjà existant. </div>';
    }
    elseif ($idRateCard['ID']=="") {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> RateCard incorrect. </div>';
    }
    else {

            $fieldsArray = array('ID_PU' =>$idPU['ID'],'GGID' =>$ggid,'Nom' =>$Nom,'Prénom' =>$Prenom,'ID_Site' =>$Site,'Date_Entree' =>$dateEntree
            ,'Date_Sortie' =>$dateSortie,'ID_rateCard' =>$idRateCard['ID'],'Pourcentage_Activity' =>$pourcentageActivite,
            'ID_Support' =>$support,'ID_Manager' =>$manager,'ID_CM' =>$CM,'cvBook' =>$cvBook,'TJMCible' =>$tjmCible,'Commentaire' =>$commentaire );
            $nbSuccess=0;
            $nbFailure=0;
            $nbInOutOK=0;
            $nbInOutKO=0;
                foreach ($fieldsArray as $key => $value) {
                    if (checkCollabFieldUpdated($key,$value,$id) and updateCollab($key,$value,$id)) {
                        $nbSuccess+=1;
                        // Cas où la MàJ s'est faite sur la date d'entrée
                        if ($key=='Date_Entree') {
                            if (updateInOut('date_in',$value,$id)) {
                                $nbSuccess+=1;
                            }
                            elseif (!updateInOut('date_in',$value,$id)) {
                                $nbFailure+=1;
                            }
                            if ($inOut['id_mois_in']!=$idMoisIn['ID'] and updateInOut('id_mois_in',$idMoisIn['ID'],$id) ) {
                                $nbSuccess+=1;
                            }
                            elseif ($inOut['id_mois_in']!=$idMoisIn['ID'] and !updateInOut('id_mois_in',$idMoisIn['ID'],$id)) {
                                $nbFailure+=1;
                            }
                        }
                        // Cas où la MàJ s'est faite sur la date de Sortie
                        if ($key=='Date_Sortie') {
                            if (updateInOut('date_out',$value,$id)) {
                                $nbSuccess+=1;
                            }
                            elseif (!updateInOut('date_out',$value,$id)) {
                                $nbFailure+=1;
                            }
                            if ($inOut['id_mois_out']!=$idMoisOut['ID'] and updateInOut('id_mois_out',$idMoisOut['ID'],$id) ) {
                                $nbSuccess+=1;
                            }
                            elseif ($inOut['id_mois_out']!=$idMoisOut['ID'] and !updateInOut('id_mois_out',$idMoisOut['ID'],$id)) {
                                $nbFailure+=1;
                            }
                        }

                        
                    }
                    elseif (checkCollabFieldUpdated($key,$value,$id) and !updateCollab($key,$value,$id)) {
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
}
echo $message;