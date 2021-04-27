<?php
require("../frontend.php");
//$db = dbConnect();
$Nom=$_POST['Nom'];
$Prenom=$_POST['Prenom'];
$ggid=$_POST['ggid'];
$pu=$_POST['pu'];
$siteID=$_POST['siteID'];
$siteRegion=getSiteRegion($siteID);
$siteRegion=$siteRegion->fetch();
$dateEntree=$_POST['dateEntree'];
$dateSortie=$_POST['dateSortie'];
//$statut=$_POST['statut'];
$role=$_POST['role'];
$Grade=$_POST['Grade'];
$RateCard=$_POST['RateCard'];
$pourcentageActivite=$_POST['pourcentageActivite'];
$support=$_POST['support'];
$manager=$_POST['manager'];
$CM=$_POST['CM'];
if ($_POST['cvBook']=='true') {
    $cvBook=1;
}else {
    $cvBook=0;
}
$commentaire=$_POST['commentaire'];
$tjmCible=$_POST['tjmCible'];
/* //$profil=$_POST['profil'];
if ($Site=="IDF") {
    $region="0";
}else {
    $region="1";
} */

//Création Nouveau collaborateur
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
    $successCreate="KO";
    $newCollabID="";
}
elseif (!is_numeric($RateCard) or $RateCard<0) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    Valeur de rateCard invalide. </div>';
    $successCreate="KO";
    $newCollabID="";
}
elseif ($Nom=="" or $Prenom=="" or $ggid=="" or $dateEntree=="" or $dateSortie=="" or $Grade=="" or $RateCard=="" or $pourcentageActivite=="" or $role=="" or $tjmCible=="" or $CM=="") {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    les champs "Nom", "Prenom", "GGID", "Date Entrée", "Date Sortie","Grade", "Rate Card", "Pourcentage Activité", "Carriere Manager" et "TJM Cible" sont <strong>obligatoires<strong>. </div>';
    $successCreate="KO";
    $newCollabID="";
}
elseif (strtotime($dateEntree) > strtotime($dateSortie)) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    La date d\'entrée est supérieure à la date de sortie. </div>';
    $successCreate="KO";
    $newCollabID="";
}
else {
    // get PU_ID
    $idPU=getPUID($pu);
    $idPU=$idPU->fetch();
    $id_PU=$idPU['ID'];
    // get ID_rateCard
    $year=date("Y",strtotime($dateEntree));
    $idRateCard=rateCardID($RateCard,$role,$Grade,$siteRegion["Region"],$year); // Calculate rateCard ID
    $idRateCard=$idRateCard->fetch();
    if (existCollab($ggid)) {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> GGID déjà existant. </div>';
        $successCreate="KO";
        $newCollabID="";
    }
    elseif ($idRateCard['ID']=="") {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> RateCard incorrect. </div>';
        $successCreate="KO";
        $newCollabID="";
    }
    else {
            // Acces nouvel ID du collaborateur créé
            $newCollabID=insertCollab($id_PU,$ggid,$Nom,$Prenom,$siteID,$dateEntree,$dateSortie,$idRateCard['ID'],$pourcentageActivite,$support,$manager,$commentaire,$CM,0,0,$cvBook,$tjmCible);
            $message1='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Nouveau collaborateur créé avec succès. </div>';
            // Enregistrment des Informations de dates d'entree et de sortie du candidat
            $idMoisIn=getMonthID(date("n",strtotime($dateEntree)));
            $idMoisIn=$idMoisIn->fetch();
            $idMoisOut=getMonthID(date("n",strtotime($dateSortie)));
            $idMoisOut=$idMoisOut->fetch();
            if (createInOut($newCollabID,$dateEntree,$dateSortie,$idMoisIn['ID'],$idMoisOut['ID'])) {
                $message1.='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> 
                Enregistrement des dates d\'entrée et sortie effectué avec succès. </div>';
            }
            else {
                $message1.='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> 
                Erreur d\'enregistrement des dates d\'entrée et sortie. </div>';
            }

            // Affectations mensuelles taches RH -- Imputations (Année en cours, pour la PU du collab et toutes les PU de type MU)
            $initTasks=getPUINternProjectsTasks($id_PU);
            //$initTasks=initializedTasks();
            //$months=array('01'=>'31','02'=>'28','03'=>'31','04'=>'30','05'=>'31','06'=>'30','07'=>'31','08'=>'31','09'=>'30','10'=>'31','11'=>'30','12'=>'31');
            //$monthsbissec=array('01'=>'31','02'=>'29','03'=>'31','04'=>'30','05'=>'31','06'=>'30','07'=>'31','08'=>'31','09'=>'30','10'=>'31','11'=>'30','12'=>'31');
            $erreuraffect=false;
            $message2='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button>Imputations + Affectations en erreur. </div>'; 
            $db = dbConnect(); // Connexion to database --> Speed Calculation needs
            while ($data=$initTasks->fetch()) {
                $year=date('Y');
                // Imputations
                for ($i=1; $i <=12 ; $i++) { 
                    insertMonthlyAffectation($db,$year,$i,$newCollabID,$data['ID'],0,0);
                }
                $year=date('Y')+1;
                // Imputations
                for ($i=1; $i <=12 ; $i++) { 
                    insertMonthlyAffectation($db,$year,$i,$newCollabID,$data['ID'],0,0);
                }

                // Affectations
                $facturable=getTaskBillStatus($data['ID']);
                $facturable=$facturable->fetch();
                if ($facturable['Facturable']==0) {
                    $tjmValue=0;
                }
                else {
                    $RCVal=getCollabRCValue($newCollabID);
                    $RCVal=$RCVal->fetch();
                    $tjmValue=$RCVal['RateCard']/((100-40)/100);
                    $tjmValue=number_format((float)$tjmValue, 2, '.', '');

                }
                insertTJM($newCollabID,$data['ID'],$year,1,$year,12,$tjmValue,0,0,0,0,0,0,0,'SO',0,'SO',1,'named');
                insertTJM($newCollabID,$data['ID'],$year+1,1,$year+1,12,$tjmValue,0,0,0,0,0,0,0,'SO',0,'SO',1,'named');
            

             }


            $message2='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Imputations + Affectations taches projets internes créées avec succès. </div>';
            // Affectations Jours ouvrables
            $jo=workingDays();
            $erreurjo=false;
            $message3='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> erreur création jour ouvrable. </div>';
                    
            while ($datajo=$jo->fetch()) {
                $nbjoursMensuel=round($pourcentageActivite*$datajo['NbJours']/100);
                //insertCollabWorkingDays($db,$newCollabID,$datajo['Annee'],$datajo['Mois'],$datajo['NbJours']); 
                insertCollabWorkingDays($db,$newCollabID,$datajo['Annee'],$datajo['Mois'],$nbjoursMensuel);
            }
            $message3='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Succes création jours ouvrables. </div>';
            $successCreate="OK";   
            // Insertion nouveau profil
            //$message4='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" data-dismiss="alert">&times;</button> erreur de rajout du profil. </div>';
            /* if ($profil=="") {
                $message4='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" data-dismiss="alert">&times;</button> champ "profil" est vide ! </div>';
            }
            elseif (!createProfil($newCollabID,$profil)) {
                $message4='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" data-dismiss="alert">&times;</button> Erreur de rajout du profil </div>';
            }
            elseif (createProfil($newCollabID,$profil)) {
                $message4='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" data-dismiss="alert">&times;</button> Succès de rajout du profil </div>';
            } */
            $message=$message1.$message2.$message3/* .$message4 */;
    }
}
echo $message.':'.$successCreate.':'.$newCollabID;