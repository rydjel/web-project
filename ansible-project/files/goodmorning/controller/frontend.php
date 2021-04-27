<?php
require("model/frontend.php");

/***************************************************************************************************************/
/* --------------------------------------------- WELCOME PAGE ------------------------------------------------ */
/***************************************************************************************************************/

// Fonction d'accès à la page d'accueil
function welcome()
{
    require('view/frontend/welcomeView.php');
}


/**************************************************************************************************************/
/*--------------------------------------------- RATE CARDS -------------------------------------------------- */
/**************************************************************************************************************/

// Fonction de chargement des rate Cards valables du jour
function loadRateCards()
{
    $message="";
    $year=date('Y');
    $region=2;
    //$db = dbConnect();
    $rateCards=getRateCards($year);
    require('view/frontend/rateCardsLoadView.php');
}

// Fonction de chargement des rate Cards par rapport à une date donnée
function loadRateCardsGivenYearRegion($filteredYear,$filteredRegion)
{
    $traductionRegion= array('IDF' =>'0','Région'=>'1','Tous'=>'2');
    $year=$filteredYear;
    $region=$traductionRegion[$filteredRegion];
    $rateCards=getRateCardsGivenYearRegion($year,$region);
    $message="";
    require('view/frontend/rateCardsLoadView.php');
}

//fonction chargement des rateCards en écriture
function loadRateCardCreation()
{
    require('view/frontend/rateCardViewCreation.php');  
}

// fonction chargement page après création Rate Card
function loadRCAfterCreation($code,$role,$grade,$region,$rateCard,$year)
{
    if (!ctype_alnum($role) or !ctype_alnum($code) ) {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champs Role et/ou Code doivent être remplis avec des caractères alphanumériques.</div>';
    }
    elseif ($rateCard<0) {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> la valeur de la RateCard (ADRC) est négative.</div>';
    }
    elseif (!($year>1900 and $year<2100)) {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> l\'année saisie est invalide.</div>';
    }
    elseif (existRateCard($code,$role,$grade,$region,$year)) {
        $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" id="closeMessage" onclick="closeAlert();" class="close" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Code Rate Card déjà existant. </div>';
    }
    elseif ($code=="" or $role=="" or $rateCard=="" or $year=="" ) {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champs Role, code, ADRC et Année sont obligatoires.</div>';
    }
    else {
        if(createRateCard($code,$role,$grade,$region,$rateCard,$year)) {
            $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;
            </button> La Rate Card de code "'.$code.'" a été rajoutée avec <strong>Success!</strong> .</div>';
        }else {
            $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Erreur de création de la nouvelle Rate Card.</div>';
        }
    }
    $year=date('Y');
    $region=2;
    $rateCards=getRateCards($year);
    require('view/frontend/rateCardsLoadView.php');
}



/************************************************************************************************************/
/*-------------------------------------------- CLIENTS -----------------------------------------------------*/
/************************************************************************************************************/

// Fonction de chargement des clients 
function loadClients($outCome)
{   
    $message=$outCome;
    $marketUnits=getMarketUnits(); //get all market units in case of creation
    $listMU=getMarketUnits(); // List Market Units for creation modal
    $MUnits=array();
    while ($data=$marketUnits->fetch()) {
        $MUnits[]=array('Nom'=>$data['Nom']);
    }
    $clientsRows=getClientRowsFields(); //get all clients Rows
    require('view/frontend/clientsView.php');
}

//fonction chargement des clients en écriture
function loadClientsCreation()
{
    $marketUnits=getMarketUnits(); //get all market units in case of creation
    require('view/frontend/clientsViewCreation.php');  
}

//fonction chargement des clients en Modification
function loadClientsModif($customerName,$marketUnitName)
{
    $messagefield1="";
    $messagefield2="";
    if ($customerName=="") {
        $messagefield1='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ "Client" vide.</div>';
    }
    if ($marketUnitName=="") {
        $messagefield2='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ "Market Unit" vide.</div>';
    }

    $idClient=getClientID($customerName); // Get CLient ID
    $marketUnits=getMarketUnits(); //get all market units in case of creation
    require('view/frontend/clientsViewModif.php'); 
}

// fonction chargement page après création client
function loadClientsAfterCreation($customerName,$marketUnitName)
{
    if (!ctype_alnum($customerName)) {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ "Client" doit être alphanumérique.</div>';
    }
    elseif (existClient($customerName)) {
        $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Client déjà existant. </div>';
    }elseif ($customerName=="" or $marketUnitName=="") {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ "Client" et "Market Unit" sont obligatoires.</div>';
    }
    elseif (!createClient($customerName,$marketUnitName)) {
        $message='<div class="alert   alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur</strong> de rajout du client.</div>';
    }
    else{
        $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Client rajouté avec <strong>Success!</strong> .</div>';
    }
    loadClients($message);
    // $marketUnits=getMarketUnits(); //get all market units in case of creation
    // require('view/frontend/clientsViewCreationAfter.php'); 

}

// fonction chargement page après Mise à jour client
function loadClientsAfterModif($fieldMU,$fieldClient,$customerName,$marketUnitName,$id)
{
    $message="";
    $message1="";
    $message2="";
    if ($customerName=="" or $marketUnitName=="") {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Aucun champ ne doit être vide.</div>';
    }
    else {
            $idMarketUnit=getIDMarketUnit($marketUnitName);
            if (!checkFieldUpdated($fieldMU,$idMarketUnit,$id) and !checkFieldUpdated($fieldClient,$customerName,$id)) {
                $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Aucune Mise à jour Effectuée. </div>';
            }
            elseif (checkFieldUpdated($fieldClient,$customerName,$id) and existClient($customerName)) {
                $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Client déjà existant. </div>';
            }
            else {
                    if (checkFieldUpdated($fieldMU,$idMarketUnit,$id) and updateClient($fieldMU,$idMarketUnit,$id)) {
                        $message1='<div class="alert   alert-success alert-dismissable" > <button type="button" id="closeMessage" onclick="closeAlert();" class="close" data-dismiss="alert" aria-label="close">&times;</button> Market Unit mise à jour avec <strong>Success!</strong> .</div>';
                    }
                    elseif (checkFieldUpdated($fieldMU,$idMarketUnit,$id) and updateClient($fieldMU,$idMarketUnit,$id)==false) {
                        $message1='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Erreur de Mise à jour de la Market Unit.</div>';
                    }
                    if (checkFieldUpdated($fieldClient,$customerName,$id) and updateClient($fieldClient,$customerName,$id)) {
                        $message2='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Nom cLient mise à jour avec <strong>Success!</strong> .</div>';
                    }
                    elseif (checkFieldUpdated($fieldClient,$customerName,$id) and updateClient($fieldClient,$customerName,$id)==false) {
                        $message2='<div class="alert   alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Erreur de Mise à jour du nom du client.</div>';
                    }
            }  
        }
        $marketUnits=getMarketUnits(); //get all market units in case of creation
        require('view/frontend/clientsViewModifAfter.php');
    
}


/************************************************************************************************************/
/*-------------------------------------------- Taches par défaut -------------------------------------------*/
/************************************************************************************************************/

// Fonction de chargement des Taches par défaut 
function loadDT()
{   
    $message="";
    $listeDT=getDefaultTasks();
    $listeAT=getActivityTypes();
    $AT=array();
    if ($listeAT) {
        while ($data=$listeAT->fetch()) {
            $AT[]=array('Details'=>$data['ID'].'-'.$data['Nom_typeActivite']);
        }
    }
    require('view/frontend/DTView.php');
    // require('view/frontend/clientsView.php');
}


/***************************************************************************************************************/
/* --------------------------------------- PRODUCTION UNIT ----------------------------------------------------*/
/***************************************************************************************************************/
// Function to load list of PU page
function loadProductionUnit()
{
    //$message="";
    $message="";
    $puRows=getPU();
    $entities=getEntities();
    $entList=array();
    if ($entities) {
        while ($data=$entities->fetch()) {
            $entList[]=array('Details'=>$data['ID_entite'].'-'.$data['nom']);
        }
    }
    require('view/frontend/productionUnitView.php');
}

//fonction chargement des PU en écriture
function loadPUCreation()
{
    require('view/frontend/productionUnitViewCreation.php');  
}

//fonction chargement des PU en Modification
function loadPUModif($puName)
{
    if ($puName=="") {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ "Nom PU" vide.</div>';
        require('view/frontend/productionUnitView.php');
    }
    else {
        $idPU=getPUID($puName); // Get PU ID
        require('view/frontend/productionUnitViewModification.php'); 
    }

}

// fonction chargement page après création PU
/* function loadPUAfterCreation($puName,$region,$MU)
{   
    if (strpos($puName,"\"")!==false or strpos($puName,":")!==false) {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Les caractères double-quote et ":" sont interdits.</div>';
    }
    elseif (existPU($puName)) {
        $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> PU déjà existant. </div>';
    }
    elseif ($puName=="") {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ "Nom PU" vide.</div>';
    }
    else {

        if(createPU($puName,$region,$MU)) {
            $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> PU rajoutée avec <strong>Success!</strong> .</div>';
        }else {
            $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Erreur de création du nouveau PU.</div>';
        }
    }

    $puRows=getPU();
    require('view/frontend/productionUnitView.php'); 

} */

// fonction chargement page après Mise à jour PU
/* function loadPUAfterModif($fieldPU,$fieldRegion,$fieldDateDebut,$fieldDateFin,$puName,$region,$dateDebut,$dateFin,$id)
{
    if ($puName=="") {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ PU ne doit être vide.</div>';
    }
    elseif (checkPUFieldUpdated($fieldPU,$puName,$id) and existPU($puName)) {
        $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> PU déjà existant. </div>';
    }
    else {

            if(empty($dateFin)){
             $dateFin="0000-00-00";
            }
           $fieldsArray = array($fieldPU =>$puName,$fieldRegion =>$region,$fieldDateDebut =>$dateDebut,$fieldDateFin =>$dateFin );
            foreach ($fieldsArray as $key => $value) {
                if (checkPUFieldUpdated($key,$value,$id) and updatePU($key,$value,$id)) {
                    $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Mise(s) à jour effectuée(s) avec <strong>Success!</strong> .</div>';
                }
                elseif (checkPUFieldUpdated($key,$value,$id) and !updatePU($key,$value,$id)) {
                    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Erreur de Mise à jour !</div>';
                }
        }

    }
    require('view/frontend/productionUnitView.php');   
} */


/***************************************************************************************************************/
/* -------------------------------------------------- Site ----------------------------------------------------*/
/***************************************************************************************************************/
// function to load list of Sites page
function loadSites()
{
    //$message="";
    $message="";
    $sitesRows=getSites();
    require('view/frontend/sitesView.php');
}


//fonction chargement page de création d'un site
function loadSiteCreation()
{
    require('view/frontend/sitesViewCreation.php');  
}


// fonction chargement page après création site
function loadSiteAfterCreation($siteName,$region)
{   
    if (strpos($siteName,"\"")!==false or strpos($siteName,":")!==false) {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Les caractères double-quote et ":" sont interdits.</div>';
    }
    elseif (existSite($siteName)) {
        $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> site déjà existant. </div>';
    }
    elseif ($siteName=="") {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ "site" vide.</div>';
    }
    else {

        if(createSite($siteName,$region)) {
            $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> site rajouté avec <strong>Success!</strong> .</div>';
        }else {
            $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Erreur de création du nouveau site.</div>';
        }
    }

    $sitesRows=getSites();
    require('view/frontend/sitesView.php'); 

}



/********************************************************************************************************************/
/* --------------------------------------- MARKET UNIT ------------------------------------------------------------- */
/*********************************************************************************************************************/

function loadMarketUnit()
{
    $message="";
    $result="";
    $muRows=getMarketUnits();
    require('view/frontend/marketUnitView.php');
}

//fonction chargement des MU en écriture
function loadMUCreation()
{
    require('view/frontend/marketUnitViewCreation.php');  
}

//fonction chargement des MU en Modification
function loadMUModif($muName)
{
    if ($muName=="") {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ "Nom MU" vide.</div>';
        require('view/frontend/marketUnitView.php');
    }
    else {
        $idMU=getPUID($puName); // Get PU ID
        require('view/frontend/marketUnitViewModification.php'); 
    }

}

// fonction chargement page après création MU
function loadMUAfterCreation($muName)
{
    if (!ctype_alnum($muName)) {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ "Market Unit" doit être alphanumérique.</div>';

    }
    elseif (existMU($muName)) {
        $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> 
        <strong>Warning!</strong> MU déjà existant. </div>';
    }
    elseif ($muName=="") {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
        <strong>Erreur !<strong> Champ "Nom MU" vide.</div>';
    }
    else {
        if(createMU($muName)) {
            $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> MU rajoutée avec <strong>Success!</strong> .</div>';
        }else {
            $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Erreur de création du nouveau MU.</div>';
        }
    }
    $muRows=getMarketUnits();
    require('view/frontend/marketUnitView.php'); 

}

// fonction chargement page après Mise à jour MU
function loadMUAfterModif($fieldPU,$muName,$id)
{
    if ($muName=="") {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ MU ne doit être vide.</div>';
    }
    elseif (checkMUFieldUpdated($fieldPU,$muName,$id) and existMU($muName)) {
        $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> MU déjà existant. </div>';
    }
    else {
           $fieldsArray = array($fieldPU =>$muName);
            foreach ($fieldsArray as $key => $value) {
                if (checkPUFieldUpdated($key,$value,$id) and updatePU($key,$value,$id)) {
                    $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Mise(s) à jour effectuée(s) avec <strong>Success!</strong> .</div>';
                }
                elseif (checkPUFieldUpdated($key,$value,$id) and !updatePU($key,$value,$id)) {
                    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Erreur de Mise à jour !</div>';
                }
        }

    }
    require('view/frontend/marketUnitView.php');   
}


/********************************************************************************************************************/
/* --------------------------------------- PROFIL TITLE ------------------------------------------------------------- */
/*********************************************************************************************************************/


// Function to load the profil Title View
function loadPT()
{
    $message="";
    $result="";
    $PTRows=getProfilTitles();
    require('view/frontend/profilTitleView.php');
}



/********************************************************************************************************************/
/* --------------------------------------- PNL KPI TYPE ------------------------------------------------------------*/
/*********************************************************************************************************************/

// Function to load the PNL KPI Type View
function loadKpiType()
{
    $message="";
    $result="";
    $kpiTypesList=getPnlKPIType();
    require('view/frontend/pnlkpitypeView.php');
}


/*********************************************************************************************************************/
/* -------------------------------------------- PNL KPI  ------------------------------------------------------------*/
/*********************************************************************************************************************/

// Function to load the PNL KPI View
function loadPnlKpi()
{
    $message="";
    $result="";
    $kpiList=getPnlKPI();
    $kpiTypesList=getPnlKPIType();
    $kpiTypesListFC=getPnlKPIType(); // FC : For Creation of a kpi
    $kpiTypes=array();
    while ($data=$kpiTypesList->fetch()) {
        $kpiTypes[$data['id_pnlkpitype']]=$data['type'];
    }
    $monthList=getMonths();
    $monthListFC=getMonths();
    $months=array();
    while ($data=$monthList->fetch()) {
        $months[$data['ID']]=$data['nom_mois'];
    }
    require('view/frontend/pnlkpiView.php');
}



/********************************************************************************************************************/
/* --------------------------------------------- TYPE ACTIVITE ----------------------------------------------------- */
/********************************************************************************************************************/
function loadActivityType()
{
    $message="";
    $ATRows=getActivityTypes();
    require('view/frontend/activityTypeView.php');
}

//fonction chargement des type d'activité en écriture
function loadATCreation()
{
    require('view/frontend/activityTypeViewCreation.php');  
}

// fonction chargement page après création AT
function loadATAfterCreation($activityName,$impactTACE,$facturable)
{
    if (!ctype_alnum($activityName)) {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ "Type d\'activité" doit être alphanumérique.</div>';
    }
    elseif (existActivityType($activityName)) {
        $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Type Activité déjà existant. </div>';
    }
    elseif ($activityName=="" or $impactTACE=="") {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ "Type Activité" et "Impact TACE" sont obligatoires.</div>';
    }
    else {
        if(createActivityType($activityName,$impactTACE,$facturable)) {
            $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Type Activité rajoutée avec <strong>Success!</strong> .</div>';
        }else {
            $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Erreur de création du nouveau Type Activité.</div>';
        }
    }
    $ATRows=getActivityTypes();
    require('view/frontend/activityTypeView.php'); 
}



/********************************************************************************************************************/
/* --------------------------------------------- JOURS OUVRABLES -------------------------------------------------- */
/********************************************************************************************************************/
function loadcurrentYearWorkingDays()
{
    $year=date('Y');
    $workingDays=workingDaysCurrentYear();
    require('view/frontend/workingDaysView.php');
}

function loadGivenYearWorkingDays($filteredYear)
{
    $year=$filteredYear;
    $workingDays=workingDaysGivenYear($year);
    require('view/frontend/workingDaysView.php');
}



/********************************************************************************************************************/
/* -------------------------------------------- JOURS OUVRABLES COLLABORATEURS ------------------------------------ */
/********************************************************************************************************************/
function loadCollabcurrentYearWorkingDays($idCollab)
{
    $year=date('Y');
    $workingDays=workingDaysCollabCurrentYear($idCollab);
    require('view/frontend/workingDaysView.php');
}

function loadCollabGivenYearWorkingDays($filteredYear,$idCollab)
{
    $year=$filteredYear;
    $workingDays=workingDaysCollabGivenYear($year,$idCollab);
    require('view/frontend/workingDaysView.php');
}



/********************************************************************************************************************/
/* ------------------------------------------- COLLABORATEURS ----------------------------------------------------- */
/********************************************************************************************************************/
function loadGestionCollabMainMenu() // Access to collab Management main menu
{
    $message="";
    //$puList=getPU();
    $puList=getCollabsPU();
    $collabs=getCollabs();
    require('view/frontend/collabsGestionMainMenuView.php');
}

function loadCollabConsultation($idCollab) // Access to a collab consultation page
{
    $message="";
    $year=date('Y');
    $collab=getACollab($idCollab);
    $collab=$collab->fetch();
    $role=getACollabRole($idCollab);
    $role=$role->fetch();
    $puname=getACollabPU($idCollab);
    $puname=$puname->fetch();
    $siteName=getSiteName($collab['ID_Site']);
    $siteName=$siteName->fetch();
    $grade=getACollabGrade($idCollab);
    $grade=$grade->fetch();
    /* $rateCard=getACollabRC($idCollab);
    $rateCard=$rateCard->fetch(); */
    $dbRC=getACollabRC($idCollab); // RC in database
    $dbRC=$dbRC->fetch();
    $rateCard=$dbRC['RateCard'];
    $lastRC=getCollabCurrentYearRCIdVal($idCollab); // Last Ratecard
    $lastRC=$lastRC->fetch();
    if($lastRC and checkCollabFieldUpdated('ID_rateCard',$lastRC['rcID'],$idCollab) and updateCollab('ID_rateCard',$lastRC['rcID'],$idCollab)){
        $message.='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> Succes de mise à jour vers la dernière valeur de rateCard .</div>';
        $rateCard=$lastRC['rcVal'];
    }
    elseif($lastRC and checkCollabFieldUpdated('ID_rateCard',$lastRC['rcID'],$idCollab) and !updateCollab('ID_rateCard',$lastRC['rcID'],$idCollab)){
        $message.='<div class="alert   alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> Erreur de mise à jour vers la dernière valeur de rateCard .</div>';
    }
    $support=getSupportDetails($collab['ID_Support']);
    $support=$support->fetch();
    $manager=getManagerDetails($collab['ID_Manager']);
    $manager=$manager->fetch();
    $CM=getCMDetails($collab['ID_CM']);
    $CM=$CM->fetch();
    $profil=consultCollabProfil($idCollab);
    $profil=$profil->fetch();
    /* $profil=$profil->fetch();
    $collabProfil=$profil['détails']; */
    $collabComp=getCollabCompetences($idCollab);
    $collabCertif=getCollabCertifications($idCollab);
    $collabExp=getCollabExperiences($idCollab); 
    $workingDays=workingDaysCurrentYear();
    $workingDaysCollab=workingDaysCollabCurrentYear($idCollab);

/*     $puList=getPU();
    $collabs=getCollabs(); */

    // If collab is empty!
    if ($idCollab=="") {
        $message='<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" id="closeMessage" onclick="closeAlert();" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button><strong>Erreur !</strong> Champ Collaborateur est vide.</div>';
        require('view/frontend/collabsGestionMainMenuView.php');
    }
    else {
        require('view/frontend/collabConsultationView.php');
    }
    //require('view/frontend/collabConsultationView.php');
}

// filter working days for a collab
function loadfilteredYearCollabConsultation($idCollab,$filteredYear) // Access to a collab consultation page - filtered by year
{
    $message="";
    $year=$filteredYear;
    $collab=getACollab($idCollab);
    $collab=$collab->fetch();
    $role=getACollabRole($idCollab);
    $role=$role->fetch();
    $puname=getACollabPU($idCollab);
    $puname=$puname->fetch();
    $siteName=getSiteName($collab['ID_Site']);
    $siteName=$siteName->fetch();
    $grade=getACollabGrade($idCollab);
    $grade=$grade->fetch();
    /* $rateCard=getACollabRC($idCollab);
    $rateCard=$rateCard->fetch(); */
    $dbRC=getACollabRC($idCollab); // RC in database
    $dbRC=$dbRC->fetch();
    $rateCard=$dbRC['RateCard'];
    $lastRC=getCollabCurrentYearRCIdVal($idCollab); // Last Ratecard
    $lastRC=$lastRC->fetch();
    if($lastRC and checkCollabFieldUpdated('ID_rateCard',$lastRC['rcID'],$idCollab) and updateCollab('ID_rateCard',$lastRC['rcID'],$idCollab)){
        $message.='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> Succes de mise à jour vers la dernière valeur de rateCard .</div>';
        $rateCard=$lastRC['rcVal'];
    }
    elseif($lastRC and checkCollabFieldUpdated('ID_rateCard',$lastRC['rcID'],$idCollab) and !updateCollab('ID_rateCard',$lastRC['rcID'],$idCollab)){
        $message.='<div class="alert   alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> Erreur de mise à jour vers la dernière valeur de rateCard .</div>';
    }
    $support=getSupportDetails($collab['ID_Support']);
    $support=$support->fetch();
    $manager=getManagerDetails($collab['ID_Manager']);
    $manager=$manager->fetch();
    $CM=getCMDetails($collab['ID_CM']);
    $CM=$CM->fetch();
    $profil=consultCollabProfil($idCollab);
    $profil=$profil->fetch();
    /* $profil=$profil->fetch();
    $collabProfil=$profil['détails']; */
    $collabComp=getCollabCompetences($idCollab);
    $collabCertif=getCollabCertifications($idCollab);
    $collabExp=getCollabExperiences($idCollab);
    $workingDays=workingDaysGivenYear($year);
    $workingDaysCollab=workingDaysCollabGivenYear($year,$idCollab);
    require('view/frontend/collabConsultationView.php');
}

// Access to a collab creation page
function loadCollabCreation()
{
    $message="";
    $year=date('Y');
    //$sites=getSitesList(); 
    $sites=getSites();
    //$puList=getPU();
    $puList=getCollabsPU();
    $supportList=getSupports();
    $managingList=getManagers();
    $CMList=getCarrierManagers();
    //$rolesList=getRoles();
    $workingDays=workingDaysCurrentYear();
    require('view/frontend/collabCreationView.php');
}

//filter year for collab Creation  ----Obsolete !!!
function loadFilteredYearCollabCreation($filteredYear)
{
    $message="";
    $year=$filteredYear;
    $sites=getSitesList(); 
    //$puList=getPU();
    $puList=getCollabsPU();
    $supportList=getSupports();
    $managingList=getManagers();
    $rolesList=getRoles();
    $workingDays=workingDaysGivenYear($year);
    require('view/frontend/collabCreationView.php');
}

// Access to a collab modification page
function loadCollabModification($idCollab)
{
    $message="";
    $year=date('Y');
    $collab=getACollab($idCollab);
    $collab=$collab->fetch();
    $role=getACollabRole($idCollab);
    $role=$role->fetch();
    $puname=getACollabPU($idCollab);
    $puname=$puname->fetch();
    $grade=getACollabGrade($idCollab);
    $grade=$grade->fetch();
    //$rateCard=getACollabRC($idCollab);
    /* $rateCard=getCollabCurrentYearRC($idCollab);
    $rateCard=$rateCard->fetch(); */
    $dbRC=getACollabRC($idCollab); // RC in database
    $dbRC=$dbRC->fetch();
    $rateCard=$dbRC['RateCard'];
    $lastRC=getCollabCurrentYearRCIdVal($idCollab); // Last Ratecard
    $lastRC=$lastRC->fetch();
    if($lastRC and checkCollabFieldUpdated('ID_rateCard',$lastRC['rcID'],$idCollab) and updateCollab('ID_rateCard',$lastRC['rcID'],$idCollab)){
        $message.='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> Succes de mise à jour vers la dernière valeur de rateCard .</div>';
        $rateCard=$lastRC['rcVal'];
    }
    elseif($lastRC and checkCollabFieldUpdated('ID_rateCard',$lastRC['rcID'],$idCollab) and !updateCollab('ID_rateCard',$lastRC['rcID'],$idCollab)){
        $message.='<div class="alert   alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> Erreur de mise à jour vers la dernière valeur de rateCard .</div>';
    }
    //$sites=getSitesList(); 
    $sites=getSites();
    //$puList=getPU();
    $puList=getCollabsPU();
    $supportList=getSupports();
    $managingList=getAvailableManagers($idCollab);
    $CMList=getAvailableCM($idCollab);
    $collabRegion=getCollabSiteRegion($idCollab);
    $collabRegion=$collabRegion->fetch();
    $rolesList=siteRoles($collabRegion['Region']);
    $profil=getprofil($idCollab);
    $PTList=getProfilTitles();
    $collabComp=getCollabCompetences($idCollab);
    $collabCertif=getCollabCertifications($idCollab);
    $collabExp=getCollabExperiences($idCollab); 
    $workingDays=workingDaysCurrentYear();
    $workingDaysCollab=workingDaysCollabCurrentYear($idCollab);
    //$puList=getPU();
    $collabs=getCollabs();
    // If collab is empty!
    if ($idCollab=="") {
        $message='<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" id="closeMessage" onclick="closeAlert();" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button><strong>Erreur !</strong> Champ Collaborateur est vide.</div>';
        require('view/frontend/collabsGestionMainMenuView.php');
    }
    else {
        require('view/frontend/collabModificationView.php');
    }
    //require('view/frontend/collabModificationView.php');
}

// Add a Collab Profil before reload page  -- Not Used !!!
function collabProfilValidation()
{
    $idCollab=$_POST['collab'];
    $details=$_POST['profilDetails'];
    $idPT=$_POST['PTChoice'];

    //Vérification que le champ Tâche n'est pas vide
    if ($details=="") {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
        le champs "Profil" est <strong>obligatoire<strong>. </div>';
    }
    elseif (strpos($details,"\"")!==false) {
        $message='<div class="alert   alert-danger alert-dismissable"> 
        <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Caractère double-quote interdit.</div>';
    }
    elseif (!createProfil($idCollab,$details,$idPT)) {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Echec</strong> 
        lors du rajout du profil. </div>';
    }
    else{
        $message='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Succes</strong> 
        de rajout du nouveau profil. </div>';
    }

    $year=date('Y');
    $collab=getACollab($idCollab);
    $collab=$collab->fetch();
    $role=getACollabRole($idCollab);
    $role=$role->fetch();
    $puname=getACollabPU($idCollab);
    $puname=$puname->fetch();
    $grade=getACollabGrade($idCollab);
    $grade=$grade->fetch();
    $rateCard=getACollabRC($idCollab);
    $rateCard=$rateCard->fetch();
    $sites=getSitesList(); 
    $puList=getPU();
    $rolesList=siteRoles($collab['Site']);
    $profil=getprofil($idCollab);
    $collabComp=getCollabCompetences($idCollab);
    $collabCertif=getCollabCertifications($idCollab);
    $collabExp=getCollabExperiences($idCollab); 
    $workingDays=workingDaysCurrentYear();
    $workingDaysCollab=workingDaysCollabCurrentYear($idCollab);

    $puList=getPU();
    $collabs=getCollabs();

    require('view/frontend/collabModificationView.php');

}

// Add a Collab Competence before reload page -- Not Used !!!
function collabCompetenceValidation()
{
    $title=$_POST['title'];
    $level=$_POST['level'];
    $idCollab=$_POST['collab'];
    $pos=strpos($title,"\"");

    //Vérification que le champ Tâche n'est pas vide
    if ($title=="") {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
        le champs "Titre" est <strong>obligatoire<strong>. </div>';

    }
    elseif (strpos($title,"\"") !==false ) {
        $message='<div class="alert   alert-danger alert-dismissable"> 
        <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Caractère double-quote interdit.</div>';
    
    }
    elseif (existsCollabCompetence($idCollab,$title)) {
        $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> 
        La compétence est déjà existante pour le Collaborateur. </div>';
      
    }
    else {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Echec de création de la compétence. </div>';
        // Création de la tâche
        $idNewComp=insertCollabCompetence($idCollab,$title,$level);
        $message='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> succes de création de la compétence. </div>';
    }

    $year=date('Y');
    $collab=getACollab($idCollab);
    $collab=$collab->fetch();
    $role=getACollabRole($idCollab);
    $role=$role->fetch();
    $puname=getACollabPU($idCollab);
    $puname=$puname->fetch();
    $grade=getACollabGrade($idCollab);
    $grade=$grade->fetch();
    $rateCard=getACollabRC($idCollab);
    $rateCard=$rateCard->fetch();
    $sites=getSitesList(); 
    $puList=getPU();
    $rolesList=siteRoles($collab['Site']);
    $profil=getprofil($idCollab);
    $collabComp=getCollabCompetences($idCollab);
    $collabCertif=getCollabCertifications($idCollab);
    $collabExp=getCollabExperiences($idCollab); 
    $workingDays=workingDaysCurrentYear();
    $workingDaysCollab=workingDaysCollabCurrentYear($idCollab);

    $puList=getPU();
    $collabs=getCollabs();

    require('view/frontend/collabModificationView.php');

}

// Add a Collab Certification before reload page -- Not Used !!!
function collabCertificationValidation()
{
    $title=$_POST['certifTitle'];
    $idCollab=$_POST['collab'];
    $pos=strpos($title,"\"");

    //Vérification que le champ Tâche n'est pas vide
    if ($title=="") {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
        le champs "Titre" est <strong>obligatoire<strong>. </div>';
       
    }
    elseif (strpos($title,"\"")!==false) {
        $message='<div class="alert   alert-danger alert-dismissable"> 
        <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Caractère double-quote interdit.</div>';
        
    }
    elseif (existsCollabCertification($idCollab,$title)) {
        $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> 
        La certification est déjà existante pour le Collaborateur. </div>';
        
    }
    else {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Echec de création de la certification. </div>';
        // Création de la tâche
        $idNewCertif=insertCollabCertif($idCollab,$title);
        $message='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> succes de création de la certification. </div>';
    }

    $year=date('Y');
    $collab=getACollab($idCollab);
    $collab=$collab->fetch();
    $role=getACollabRole($idCollab);
    $role=$role->fetch();
    $puname=getACollabPU($idCollab);
    $puname=$puname->fetch();
    $grade=getACollabGrade($idCollab);
    $grade=$grade->fetch();
    $rateCard=getACollabRC($idCollab);
    $rateCard=$rateCard->fetch();
    $sites=getSitesList(); 
    $puList=getPU();
    $rolesList=siteRoles($collab['Site']);
    $profil=getprofil($idCollab);
    $collabComp=getCollabCompetences($idCollab);
    $collabCertif=getCollabCertifications($idCollab);
    $collabExp=getCollabExperiences($idCollab); 
    $workingDays=workingDaysCurrentYear();
    $workingDaysCollab=workingDaysCollabCurrentYear($idCollab);

    $puList=getPU();
    $collabs=getCollabs();

    require('view/frontend/collabModificationView.php');

}

// Add a Collab Experience before reload page  -- Not Used !!!
function collabExperienceValidation()
{
    $debutExp=$_POST['collabExpDebut'];
    $finExp=$_POST['collabExpEnd'];
    $expDetails=$_POST['collabExpDetails'];
    $idCollab=$_POST['collab'];
    $quote=strpos($expDetails,"\"");

    //Vérification que le champ Tâche n'est pas vide
    if ($expDetails=="" or $debutExp=="") {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
        le champs "Détails" et "Date d\'entrée" sont <strong>obligatoires</strong>. </div>';
        
    }
    elseif ($finExp!="" and strtotime($finExp)<strtotime($debutExp)) {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
        la date de début est postérieure à la date de fin! </div>';
        
    }
    elseif (strtotime("now")<strtotime($debutExp)) {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
        la date de début est postérieure à la date du jour. </div>';
        
    }
    elseif (strpos($expDetails,"\"")!==false) {
        $message='<div class="alert   alert-danger alert-dismissable"> 
        <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Caractère double-quote interdit. 
        Merci de choisir des simple-quote</div>';
        
    }
    elseif (existsCollabExperience($idCollab,$debutExp,$finExp,$expDetails)) {
        $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> 
        L\'expérience est déjà existante pour le Collaborateur. </div>';
        
    }
    else {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Echec d\'insertion de l\'expérience. </div>';
        // Création de la tâche
        $idNewExp=insertCollabExperience($idCollab,$debutExp,$finExp,$expDetails);
        $message='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> succes d\'insertion de la nouvelle expérience. </div>';
        
    }

    $year=date('Y');
    $collab=getACollab($idCollab);
    $collab=$collab->fetch();
    $role=getACollabRole($idCollab);
    $role=$role->fetch();
    $puname=getACollabPU($idCollab);
    $puname=$puname->fetch();
    $grade=getACollabGrade($idCollab);
    $grade=$grade->fetch();
    $rateCard=getACollabRC($idCollab);
    $rateCard=$rateCard->fetch();
    $sites=getSitesList(); 
    $puList=getPU();
    $rolesList=siteRoles($collab['Site']);
    $profil=getprofil($idCollab);
    $collabComp=getCollabCompetences($idCollab);
    $collabCertif=getCollabCertifications($idCollab);
    $collabExp=getCollabExperiences($idCollab); 
    $workingDays=workingDaysCurrentYear();
    $workingDaysCollab=workingDaysCollabCurrentYear($idCollab);

    $puList=getPU();
    $collabs=getCollabs();

    require('view/frontend/collabModificationView.php');

}

//filter year for collab Modification
function loadFilteredYearCollabModification($filteredYear,$idCollab)
{
    $message="";
    $year=$filteredYear;
    $collab=getACollab($idCollab);
    $collab=$collab->fetch();
    $role=getACollabRole($idCollab);
    $role=$role->fetch();
    $puname=getACollabPU($idCollab);
    $puname=$puname->fetch();
    $grade=getACollabGrade($idCollab);
    $grade=$grade->fetch();
    /* $rateCard=getACollabRC($idCollab);
    $rateCard=$rateCard->fetch(); */
    //$sites=getSitesList();
    $dbRC=getACollabRC($idCollab); // RC in database
    $dbRC=$dbRC->fetch();
    $rateCard=$dbRC['RateCard'];
    $lastRC=getCollabCurrentYearRCIdVal($idCollab); // Last Ratecard
    $lastRC=$lastRC->fetch();
    if($lastRC and checkCollabFieldUpdated('ID_rateCard',$lastRC['rcID'],$idCollab) and updateCollab('ID_rateCard',$lastRC['rcID'],$idCollab)){
        $message.='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> Succes de mise à jour vers la dernière valeur de rateCard .</div>';
        $rateCard=$lastRC['rcVal'];
    }
    elseif($lastRC and checkCollabFieldUpdated('ID_rateCard',$lastRC['rcID'],$idCollab) and !updateCollab('ID_rateCard',$lastRC['rcID'],$idCollab)){
        $message.='<div class="alert   alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> Erreur de mise à jour vers la dernière valeur de rateCard .</div>';
    }
    $sites=getSites();
    //$puList=getPU();
    $puList=getCollabsPU();
    $supportList=getSupports();
    $managingList=getAvailableManagers($idCollab);
    $CMList=getAvailableCM($idCollab);
    $collabRegion=getCollabSiteRegion($idCollab);
    $collabRegion=$collabRegion->fetch();
    $rolesList=siteRoles($collabRegion['Region']);
    $profil=getprofil($idCollab);
    $PTList=getProfilTitles();
    $collabComp=getCollabCompetences($idCollab);
    $collabCertif=getCollabCertifications($idCollab);
    $collabExp=getCollabExperiences($idCollab);
    $workingDays=workingDaysGivenYear($year);
    $workingDaysCollab=workingDaysCollabGivenYear($year,$idCollab);
    require('view/frontend/collabModificationView.php');
}

//Access to collab charging Plan Main Menu
function loadChargingPlanCollabMainMenu() // Access to collab Management main menu
{
    $message="";
    //$puList=getPU();
   /*  $puList=getCollabsPU();
    $collabs=getCollabs(); */
    $managers=getManagers();
    require('view/frontend/collabsChargingPlanMainMenuView.php');
}

/* function loadCollabChargingPlanConsultation($idCollab) // Access to a collab Charging Plan consultation page --> Obsolète!!!
{
    $year=date('Y');
    $collab=getACollab($idCollab);
    $collab=$collab->fetch();
    $role=getACollabRole($idCollab);
    $role=$role->fetch();
    $puname=getACollabPU($idCollab);
    $puname=$puname->fetch();
    $grade=getACollabGrade($idCollab);
    $grade=$grade->fetch();
    $rateCard=getACollabRC($idCollab);
    $rateCard=$rateCard->fetch();
    $totalPlannedCharges=array(); // Array des charges planifiées totales
    $totalRealCharges=array(); // Array des charges réelles totales
    for ($i=1; $i <= 12 ; $i++) {
        $monthTotal=sumMonthChargesCurrentYear($i,$idCollab);
        $monthTotal=$monthTotal->fetch();
        $totalPlannedCharges[$i]=$monthTotal['sommePlan'];
        $totalRealCharges[$i]=$monthTotal['sommeReal'];
    }
    $workingDaysCollab=workingDaysCollabGivenYear($year,$idCollab); // Jours ouvrables collaborateurs
    $wdCollab=array();
    $i=1;
    while ($data=$workingDaysCollab ->fetch()) {
        $wdCollab[$i]=$data['NbJours'];
        $i++;
    }
    $taskList=listProjTasksCollabCurrentYear($idCollab); //liste des projets et taches du collab pour l'année en cours
    $yearCollabTasks=array();
$taskFirstMonth=array();
    $taskLastMonth=array();
    $i=1;
    while ($data=$taskList->fetch()) {
        $yearCollabTasks[$i]=$data['Code'].$data['Nom_Tache'];
        /* $firstMonth=firstMonthAffectationCurrentYear($idCollab,$data['idTache']);
        $val=$firstMonth->fetch();
        $taskFirstMonth[$i]=$val['minMois'];
        $lastMonth=lastMonthAffectationCurrentYear($idCollab,$data['idTache']);
        $val=$lastMonth->fetch();
        $taskLastMonth[$i]=$val['maxMois'];
        ${"taskCharges".$i}=getPRChargesCollabCurrentYearDefMonth($idCollab,$data['idTache']); // List charges ppour la tâche
        $i++;
    }
    require('view/frontend/collabChargingPlanConsultationView.php');
} */

function loadFilteredYearCollabChargingPlanConsultation($filteredYear,$idCollab) // Access to a collab Charging Plan consultation page --> Obsolète!!!
{
    $year=$filteredYear;
    $collab=getACollab($idCollab);
    $collab=$collab->fetch();
    $role=getACollabRole($idCollab);
    $role=$role->fetch();
    $puname=getACollabPU($idCollab);
    $puname=$puname->fetch();
    $grade=getACollabGrade($idCollab);
    $grade=$grade->fetch();
    $rateCard=getACollabRC($idCollab);
    $rateCard=$rateCard->fetch();
    $totalPlannedCharges=array(); // Array des charges planifiées totales
    $totalRealCharges=array(); // Array des charges réelles totales
    for ($i=1; $i <=12 ; $i++) {
        $monthTotal=sumMonthChargesFilteredYear($i,$idCollab,$year);
        $monthTotal=$monthTotal->fetch();
        $totalPlannedCharges[$i]=$monthTotal['sommePlan'];
        $totalRealCharges[$i]=$monthTotal['sommeReal'];
    }
    $workingDaysCollab=workingDaysCollabGivenYear($year,$idCollab); // Jours ouvrables collaborateurs
    $wdCollab=array();
    $i=1;
    while ($data=$workingDaysCollab ->fetch()) {
        $wdCollab[$i]=$data['NbJours'];
        $i++;
    }

    $taskList=listProjTasksCollabfilteredYear($idCollab,$year); //liste des projets et taches du collab pour l'année en cours
    $yearCollabTasks=array();
    $taskFirstMonth=array();
    $taskLastMonth=array();
    $i=1;
    while ($data=$taskList->fetch()) {
        $yearCollabTasks[$i]=$data['Code'].$data['Nom_Tache'];
        ${"taskCharges".$i}=getPRChargesCollabfilteredYearDefMonth($idCollab,$year,$data['idTache']); // List charges ppour la tâche
        $i++;
    }
    require('view/frontend/collabChargingPlanConsultationView.php');
}

/* function loadCollabChargingPlanModif($idCollab) // Access to a collab Charging Plan consultation page --> Obsolète!!!
{
    $year=date('Y');
    $collab=getACollab($idCollab);
    $collab=$collab->fetch();
    $role=getACollabRole($idCollab);
    $role=$role->fetch();
    $puname=getACollabPU($idCollab);
    $puname=$puname->fetch();
    $grade=getACollabGrade($idCollab);
    $grade=$grade->fetch();
    $rateCard=getACollabRC($idCollab);
    $rateCard=$rateCard->fetch();
    $totalPlannedCharges=array(); // Array des charges planifiées totales
    $totalRealCharges=array(); // Array des charges réelles totales
    for ($i=1; $i <=12 ; $i++) {
        $monthTotal=sumMonthChargesCurrentYear($i,$idCollab);
        $monthTotal=$monthTotal->fetch();
        $totalPlannedCharges[$i]=$monthTotal['sommePlan'];
        $totalRealCharges[$i]=$monthTotal['sommeReal'];
    }
    $workingDaysCollab=workingDaysCollabGivenYear($year,$idCollab); // Jours ouvrables collaborateurs
    $wdCollab=array();
    $i=1;
    while ($data=$workingDaysCollab ->fetch()) {
        $wdCollab[$i]=$data['NbJours'];
        $i++;
    }
    $taskList=listProjTasksCollabCurrentYear($idCollab); //liste des projets et taches du collab pour l'année en cours
    $yearCollabTasks=array();
    $i=1;
    while ($data=$taskList->fetch()) {
        $yearCollabTasks[$i]=$data['Code'].$data['Nom_Tache'];
        ${"taskCharges".$i}=getPRChargesCollabCurrentYearDefMonth($idCollab,$data['idTache']); // List charges ppour la tâche
        $i++;
    }
    require('view/frontend/collabChargingPlanModifView.php');
} */

function loadFilteredYearCollabChargingPlanModif($filteredYear,$idCollab) // Access to a collab Charging Plan consultation page --> Obsolète!!!
{
    $year=$filteredYear;
    $collab=getACollab($idCollab);
    $collab=$collab->fetch();
    $role=getACollabRole($idCollab);
    $role=$role->fetch();
    $puname=getACollabPU($idCollab);
    $puname=$puname->fetch();
    $grade=getACollabGrade($idCollab);
    $grade=$grade->fetch();
    $rateCard=getACollabRC($idCollab);
    $rateCard=$rateCard->fetch();
    $totalPlannedCharges=array(); // Array des charges planifiées totales
    $totalRealCharges=array(); // Array des charges réelles totales
    for ($i=1; $i <=12 ; $i++) {
        $monthTotal=sumMonthChargesFilteredYear($i,$idCollab,$year);
        $monthTotal=$monthTotal->fetch();
        $totalPlannedCharges[$i]=$monthTotal['sommePlan'];
        $totalRealCharges[$i]=$monthTotal['sommeReal'];
    }
    $workingDaysCollab=workingDaysCollabGivenYear($year,$idCollab); // Jours ouvrables collaborateurs
    $wdCollab=array();
    $i=1;
    while ($data=$workingDaysCollab ->fetch()) {
        $wdCollab[$i]=$data['NbJours'];
        $i++;
    }

    $taskList=listProjTasksCollabfilteredYear($idCollab,$year); //liste des projets et taches du collab pour l'année en cours
    $yearCollabTasks=array();
    $taskFirstMonth=array();
    $taskLastMonth=array();
    $i=1;
    while ($data=$taskList->fetch()) {
        $yearCollabTasks[$i]=$data['Code'].$data['Nom_Tache'];
        ${"taskCharges".$i}=getPRChargesCollabfilteredYearDefMonth($idCollab,$year,$data['idTache']); // List charges ppour la tâche
        $i++;
    }
    require('view/frontend/collabChargingPlanModifView.php');
}

// --------- New Version of Charging Plan
function loadManagerCollabsChargingPlan($manager)
{
    $message="";
    $managerDetails=getManagerDetails($manager);
    $data=$managerDetails->fetch();
    $selectedManager=$data['Nom'].' '.$data['Prénom'];
    $idManager=$manager;
    $collabs=getManagerCollabListIN($manager);
    require('view/frontend/managerCollabsChargingPlanView.php');
}

/* function loadCollabChargingPlan($idCollab) // Access to a collab Charging Plan page
{
    if ($_POST['collab'] == "" ) {
        $message='<div class="alert  alert-danger alert-dismissable" > 
        <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> Champ Collab est vide. </div>';
        $puList=getPU();
        $collabs=getCollabs();
        require('view/frontend/collabsChargingPlanMainMenuView.php');
    }
    else {
        $message="";
        $year=date('Y');
        //$month=date("n");
        //$initMonth=$month;
        //$lastMonth=$month;
        $initMonth="1";
        $lastMonth="12";
        $collab=getACollab($idCollab);
        $collab=$collab->fetch();
        $role=getACollabRole($idCollab);
        $role=$role->fetch();
        $puname=getACollabPU($idCollab);
        $puname=$puname->fetch();
        $siteName=getSiteName($collab['ID_Site']);
        $siteName=$siteName->fetch();
        $grade=getACollabGrade($idCollab);
        $grade=$grade->fetch();
        $dbRC=getACollabRC($idCollab); // RC in database
        $dbRC=$dbRC->fetch();
        $rateCard=$dbRC['RateCard'];
        $lastRC=getCollabCurrentYearRCIdVal($idCollab); // Last Ratecard
        $lastRC=$lastRC->fetch();
        if($lastRC and checkCollabFieldUpdated('ID_rateCard',$lastRC['rcID'],$idCollab) and updateCollab('ID_rateCard',$lastRC['rcID'],$idCollab)){
            $message.='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
            data-dismiss="alert" aria-label="close">&times;</button> Succes de mise à jour vers la dernière valeur de rateCard .</div>';
            $rateCard=$lastRC['rcVal'];
        }
        elseif($lastRC and checkCollabFieldUpdated('ID_rateCard',$lastRC['rcID'],$idCollab) and !updateCollab('ID_rateCard',$lastRC['rcID'],$idCollab)){
            $message.='<div class="alert   alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
            data-dismiss="alert" aria-label="close">&times;</button> Erreur de mise à jour vers la dernière valeur de rateCard .</div>';
        }
        $support=getSupportDetails($collab['ID_Support']);
        $support=$support->fetch();
        $manager=getManagerDetails($collab['ID_Manager']);
        $manager=$manager->fetch();
        $CM=getCMDetails($collab['ID_CM']);
        $CM=$CM->fetch();
        $listMois = array('1' => 'Janvier' ,'2' => 'Février','3' => 'Mars','4' => 'Avril','5' => 'Mai','6' => 'Juin',
        '7' => 'Juillet','8' => 'Août','9' => 'Septembre','10' => 'Octobre','11' => 'Novembre','12' => 'Décembre' );
        $totalPlannedCharges=array(); // Array des charges planifiées totales
        $totalRealCharges=array(); // Array des charges réelles totales
        
        for ($i=$initMonth; $i <= $lastMonth ; $i++) {
            $monthTotal=sumMonthChargesCurrentYear($i,$idCollab); 
            $monthTotal=$monthTotal->fetch();
            $totalPlannedCharges[$i]=$monthTotal['sommePlan'];
            $totalRealCharges[$i]=$monthTotal['sommeReal'];
        }

        $wdCollab=array();
        for ($j=$initMonth; $j<=$lastMonth; $j++) { 
            $workingDaysCollab=workingDaysCollabGivenYearMonth($year,$j,$idCollab); // Jours ouvrables collaborateurs
            $data=$workingDaysCollab->fetch();
            $wdCollab[$j]=$data['NbJours'];
        }

        /* $noneInterntaskList=listNoneInternProjTasksCollabCurrentYear($idCollab); //liste des activités de type non internes pour l'année en cours
        $internTaskList=listInternProjTasksCollabCurrentYear($idCollab); //Liste des activités de type interne
        $yearCollabNoneInternTasks=array();
        $yearCollabInternTasks=array();

        $projListNoneInternNullCharges=listNoneInternProjNullChargeCollabCurrentYear($idCollab); // Liste projets non internes avec Charges Totales nulles
        $projListInternNullCharges=listInternProjNullChargeCollabCurrentYear($idCollab); // Liste projets internes avec Charges Totales nulles

        $noneInterntaskList=listNoneInternProjTasksCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth); //liste des activités de type non internes pour l'année sélectionnée
        $internTaskList=listInternProjTasksCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth); //Liste des activités de type interne
        $yearCollabNoneInternTasks=array();
        $yearCollabInternTasks=array();

        $projListNoneInternNullCharges=listNoneInternProjNullChargeCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth); // Liste projets non internes avec Charges Totales nulles
        $projListInternNullCharges=listInternProjNullChargeCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth); // Liste projets internes avec Charges Totales nulles

        // Parsing des tâches pour avoir les charges correspondantes
        //------ Cas Activités non internes
        if ($noneInterntaskList) {
            $i=1; // début incrément
            while ($data=$noneInterntaskList->fetch()) {
                $yearCollabNoneInternTasks[$i]=$data['Titre']."-".$data['Nom_Tache'].":".$data['idTache'].":".$data['commentaire'];
                ${"noneInternTaskCharges".$i}=getPRChargesCollabgivenYearMonth($idCollab,$year,$data['idTache'],$initMonth,$lastMonth); // List charges ppour la tâche
                $i++;
            } 
            $nbNoneInternTasks=$i-1; // Nb of none Intern tasks founds
        }
        for ($i=1; $i<=$nbNoneInternTasks ; $i++) {
            ${"noneInternTaskArrayCharges".$i}=array(); // array charges for the specified Task for filtered year and months
            for ($j=$initMonth; $j <=$lastMonth ; $j++) { // Initialization of the array
                ${"noneInternTaskArrayCharges".$i}[$j]="disabled";
            }
            //-----
            while ($data=${"noneInternTaskCharges".$i}->fetch()) {
                ${"noneInternTaskArrayCharges".$i}[$data['mois']]=$data['ID']."-".$data['NbJoursPlan'].'-'.$data['NbJoursReal'];
            }
        }
        
        //------ Cas Activités internes
        if ($internTaskList) {
            $i=1; // début incrément
            while ($data=$internTaskList->fetch()) {
                $yearCollabInternTasks[$i]=$data['Titre']."-".$data['Nom_Tache'].":".$data['idTache'].":".$data['commentaire'];
                ${"internTaskCharges".$i}=getPRChargesCollabgivenYearMonth($idCollab,$year,$data['idTache'],$initMonth,$lastMonth); // List charges ppour la tâche
                $i++;
            }
            $nbInternTasks=$i-1; // Nb of Intern tasks founds  
        }
        for ($i=1; $i<=$nbInternTasks ; $i++) {
            ${"internTaskArrayCharges".$i}=array(); // array charges for the specified Task for filtered year and months
            for ($j=$initMonth; $j <=$lastMonth ; $j++) { // Initialization of the array
                ${"internTaskArrayCharges".$i}[$j]="disabled";
            }
            //-----
            while ($data=${"internTaskCharges".$i}->fetch()) {
                ${"internTaskArrayCharges".$i}[$data['mois']]=$data['ID']."-".$data['NbJoursPlan'].'-'.$data['NbJoursReal'];
            }
        }


        require('view/frontend/collabChargingPlanView.php');
    }
    
} */

/* function loadCollabChargingPlanFilteredYearMonth($idCollab,$year,$initMonth,$lastMonth) // Access to a collab Charging Plan page from filtered year and month
{
    if ($initMonth>$lastMonth) {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Mois final inférieur au mois initial !</div>';
        $year=date('Y');
        //$month=date("n");
        //$initMonth=$month;
        //$lastMonth=$month;
        $initMonth="1";
        $lastMonth="12";
    }else {
        $message="";
    }
    $collab=getACollab($idCollab);
    $collab=$collab->fetch();
    $role=getACollabRole($idCollab);
    $role=$role->fetch();
    $puname=getACollabPU($idCollab);
    $puname=$puname->fetch();
    $siteName=getSiteName($collab['ID_Site']);
    $siteName=$siteName->fetch();
    $grade=getACollabGrade($idCollab);
    $grade=$grade->fetch();
    $dbRC=getACollabRC($idCollab); // RC in database
    $dbRC=$dbRC->fetch();
    $rateCard=$dbRC['RateCard'];
    $lastRC=getCollabCurrentYearRCIdVal($idCollab); // Last Ratecard
    $lastRC=$lastRC->fetch();
    if($lastRC and checkCollabFieldUpdated('ID_rateCard',$lastRC['rcID'],$idCollab) and updateCollab('ID_rateCard',$lastRC['rcID'],$idCollab)){
        $message.='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> Succes de mise à jour vers la dernière valeur de rateCard .</div>';
        $rateCard=$lastRC['rcVal'];
    }
    elseif($lastRC and checkCollabFieldUpdated('ID_rateCard',$lastRC['rcID'],$idCollab) and !updateCollab('ID_rateCard',$lastRC['rcID'],$idCollab)){
        $message.='<div class="alert   alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> Erreur de mise à jour vers la dernière valeur de rateCard .</div>';
    }
    $support=getSupportDetails($collab['ID_Support']);
    $support=$support->fetch();
    $manager=getManagerDetails($collab['ID_Manager']);
    $manager=$manager->fetch();
    $CM=getCMDetails($collab['ID_CM']);
    $CM=$CM->fetch();
    $listMois = array('1' => 'Janvier' ,'2' => 'Février','3' => 'Mars','4' => 'Avril','5' => 'Mai','6' => 'Juin',
    '7' => 'Juillet','8' => 'Août','9' => 'Septembre','10' => 'Octobre','11' => 'Novembre','12' => 'Décembre' );
    $totalPlannedCharges=array(); // Array des charges planifiées totales
    $totalRealCharges=array(); // Array des charges réelles totales
    
    for ($i=$initMonth; $i <= $lastMonth ; $i++) {
        $monthTotal=sumMonthChargesFilteredYear($i,$idCollab,$year);
        $monthTotal=$monthTotal->fetch();
        $totalPlannedCharges[$i]=$monthTotal['sommePlan'];
        $totalRealCharges[$i]=$monthTotal['sommeReal'];
    }

    $wdCollab=array();
    for ($j=$initMonth; $j<=$lastMonth; $j++) { 
        $workingDaysCollab=workingDaysCollabGivenYearMonth($year,$j,$idCollab); // Jours ouvrables collaborateurs
        $data=$workingDaysCollab->fetch();
        $wdCollab[$j]=$data['NbJours'];
    }

    $noneInterntaskList=listNoneInternProjTasksCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth); //liste des activités de type non internes pour l'année sélectionnée
    $internTaskList=listInternProjTasksCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth); //Liste des activités de type interne
    $yearCollabNoneInternTasks=array();
    $yearCollabInternTasks=array();

    $projListNoneInternNullCharges=listNoneInternProjNullChargeCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth); // Liste projets non internes avec Charges Totales nulles
    $projListInternNullCharges=listInternProjNullChargeCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth); // Liste projets internes avec Charges Totales nulles

    // Parsing des tâches pour avoir les charges correspondantes
    //------------------------ Cas Activités non internes
    if ($noneInterntaskList) {
        $i=1; // début incrément
        while ($data=$noneInterntaskList->fetch()) {
            $yearCollabNoneInternTasks[$i]=$data['Titre']."-".$data['Nom_Tache'].":".$data['idTache'].":".$data['commentaire'];
            ${"noneInternTaskCharges".$i}=getPRChargesCollabgivenYearMonth($idCollab,$year,$data['idTache'],$initMonth,$lastMonth); // List charges ppour la tâche
            $i++;
        }
        $nbNoneInternTasks=$i-1; // Nb of none Intern tasks founds
    }

    for ($i=1; $i<=$nbNoneInternTasks ; $i++) {
        ${"noneInternTaskArrayCharges".$i}=array(); // array charges for the specified Task for filtered year and months
        for ($j=$initMonth; $j <=$lastMonth ; $j++) { // Initialization of the array
            ${"noneInternTaskArrayCharges".$i}[$j]="disabled";
        }
        //-----
        while ($data=${"noneInternTaskCharges".$i}->fetch()) {
            ${"noneInternTaskArrayCharges".$i}[$data['mois']]=$data['ID']."-".$data['NbJoursPlan'].'-'.$data['NbJoursReal'];
        }
    }
    
    //----------------------- Cas Activités internes
    if ($internTaskList) {
        $i=1; // début incrément
        while ($data=$internTaskList->fetch()) {
            $yearCollabInternTasks[$i]=$data['Titre']."-".$data['Nom_Tache'].":".$data['idTache'].":".$data['commentaire'];
            ${"internTaskCharges".$i}=getPRChargesCollabgivenYearMonth($idCollab,$year,$data['idTache'],$initMonth,$lastMonth); // List charges ppour la tâche
            $i++;
        }
        $nbInternTasks=$i-1; // Nb of Intern tasks founds 
    }

    for ($i=1; $i<=$nbInternTasks ; $i++) {
        ${"internTaskArrayCharges".$i}=array(); // array charges for the specified Task for filtered year and months
        for ($j=$initMonth; $j <=$lastMonth ; $j++) { // Initialization of the array
            ${"internTaskArrayCharges".$i}[$j]="disabled";
        }
        //-----
        while ($data=${"internTaskCharges".$i}->fetch()) {
            ${"internTaskArrayCharges".$i}[$data['mois']]=$data['ID']."-".$data['NbJoursPlan'].'-'.$data['NbJoursReal'];
        }
    }

    
    require('view/frontend/collabChargingPlanView.php');
} */

function loadCollabImputationCreation($idCollab) // Access to a collab Imputations creation page --> Obsolète!!!
{
    $year=date('Y');
    $month=date("n");
    $initMonth=$month;
    $lastMonth=$month;
    $collab=getACollab($idCollab);
    $collab=$collab->fetch();
    $role=getACollabRole($idCollab);
    $role=$role->fetch();
    $puname=getACollabPU($idCollab);
    $puname=$puname->fetch();
    $grade=getACollabGrade($idCollab);
    $grade=$grade->fetch();
    $rateCard=getACollabRC($idCollab);
    $rateCard=$rateCard->fetch();
    $listMois = array('1' => 'Janvier' ,'2' => 'Février','3' => 'Mars','4' => 'Avril','5' => 'Mai','6' => 'Juin',
    '7' => 'Juillet','8' => 'Août','9' => 'Septembre','10' => 'Octobre','11' => 'Novembre','12' => 'Décembre' );

    $wdCollab=array();
    for ($j=$initMonth; $j<=$lastMonth; $j++) { 
        $workingDaysCollab=workingDaysCollabGivenYearMonth($year,$month,$idCollab); // Jours ouvrables collaborateurs
        $data=$workingDaysCollab->fetch();
        $wdCollab[$j]=$data['NbJours'];
    }

    $noneInternTaskToImputList=listNoneInternProjTasksWithoutImpCollabCurrentYearMonth($idCollab); // Tâches non internes à imputer
    $internTaskToImputList=listInternProjTasksWithoutImpCollabCurrentYearMonth($idCollab); // Tâches internes à imputer
   
    require('view/frontend/collabImputationCreationView.php');
}

function loadCollabImputationCreationFilteredYearMonth($idCollab,$year,$initMonth,$lastMonth) // Access to a collab Imputations creation page for given year and months --> Obsolète!!!
{
    $collab=getACollab($idCollab);
    $collab=$collab->fetch();
    $role=getACollabRole($idCollab);
    $role=$role->fetch();
    $puname=getACollabPU($idCollab);
    $puname=$puname->fetch();
    $grade=getACollabGrade($idCollab);
    $grade=$grade->fetch();
    $rateCard=getACollabRC($idCollab);
    $rateCard=$rateCard->fetch();
    $listMois = array('1' => 'Janvier' ,'2' => 'Février','3' => 'Mars','4' => 'Avril','5' => 'Mai','6' => 'Juin',
    '7' => 'Juillet','8' => 'Août','9' => 'Septembre','10' => 'Octobre','11' => 'Novembre','12' => 'Décembre' );

    $wdCollab=array();
    for ($j=$initMonth; $j<=$lastMonth; $j++) { 
        $workingDaysCollab=workingDaysCollabGivenYearMonth($year,$j,$idCollab); // Jours ouvrables collaborateurs
        $data=$workingDaysCollab->fetch();
        $wdCollab[$j]=$data['NbJours'];
    }

    $noneInternTaskToImputList=listNoneInternProjTasksWithoutImpCollabfilteredYearMonth($idCollab,$year,$initMonth,$lastMonth);
    $internTaskToImputList=listInternProjTasksWithoutImpCollabfilteredYearMonth($idCollab,$year,$initMonth,$lastMonth);

    
    require('view/frontend/collabImputationCreationView.php');
}

// Fonction de validation des Imputations
/* function validateCollabImputationUpdate()
{
    $initMonth=$_POST['InitMonthChargesCollab'];
    $lastMonth=$_POST['LastMonthChargesCollab'];
    $year=$_POST['yearChargesCollab'];
    $idCollab=$_POST['collab'];
    $listDbImp=getPRChargesCollabAllTasksgivenYearMonth($idCollab,$year,$initMonth,$lastMonth);
    $nbSuccess=0;
    $nbFailure=0;
    // Cas des taches imputées initialement avec charges non nulles
    while ($data=$listDbImp->fetch()) {
        if (isset($_POST["Plan-ID-".$data['ID']]) and $_POST["Plan-ID-".$data['ID']]!=$data['NbJoursPlan']) {
            if (updateAffectation('NbJoursPlan',$_POST["Plan-ID-".$data['ID']],$data['ID']) and updateAffectation('NbJoursReal',$_POST["Plan-ID-".$data['ID']],$data['ID']) ) {
                $nbSuccess+=1;
            }
            else{
                $nbFailure+=1;
            }
        }
        if (isset($_POST["Real-ID-".$data['ID']]) and $_POST["Real-ID-".$data['ID']]!=$data['NbJoursReal']) {
            if (updateAffectation('NbJoursReal',$_POST["Real-ID-".$data['ID']],$data['ID'])) {
                $nbSuccess+=1;
            }
            else{
                $nbFailure+=1;
            }
        }
        
    }
    //Tache non interne sélectionée avec charge nulle
    $idTaskNINull=$_POST['listTaskProjNoneInternNullCharges'];
    if ($idTaskNINull != "") {
        $listChargesNINull=getPRChargesCollabgivenYearMonth($idCollab,$year,$idTaskNINull,$initMonth,$lastMonth);
        while ($data=$listChargesNINull->fetch()) {
            /* $valueMod=$_POST["taskNoneIntAffPlanMonth-".$data['mois']];
            $valuedb=$data['NbJoursPlan'];
            if (isset($_POST["taskNoneIntAffPlanMonth-".$data['mois']]) and $_POST["taskNoneIntAffPlanMonth-".$data['mois']]!=$data['NbJoursPlan'] 
            and updateAffectation('NbJoursPlan',$_POST["taskNoneIntAffPlanMonth-".$data['mois']],$data['ID']) and updateAffectation('NbJoursReal',$_POST["taskNoneIntAffPlanMonth-".$data['mois']],$data['ID']) ) {
                $nbSuccess+=1;
            }
            elseif (isset($_POST["taskNoneIntAffPlanMonth-".$data['mois']]) and $_POST["taskNoneIntAffPlanMonth-".$data['mois']]!=$data['NbJoursPlan'] and !updateAffectation('NbJoursPlan',$_POST["taskNoneIntAffPlanMonth-".$data['mois']],$data['ID'])) {
                $nbFailure+=1;
            }
            if (isset($_POST["taskNoneIntAffRealMonth-".$data['mois']]) and $_POST["taskNoneIntAffRealMonth-".$data['mois']]!=$data['NbJoursReal'] and updateAffectation('NbJoursReal',$_POST["taskNoneIntAffRealMonth-".$data['mois']],$data['ID'])) {
                $nbSuccess+=1;
            }
            elseif (isset($_POST["taskNoneIntAffRealMonth-".$data['mois']]) and $_POST["taskNoneIntAffRealMonth-".$data['mois']]!=$data['NbJoursReal'] and !updateAffectation('NbJoursReal',$_POST["taskNoneIntAffRealMonth-".$data['mois']],$data['ID'])){
                $nbFailure+=1;
            }

        }
    }
    
    //Tache Interne imputée initialement avec charge nulle
    $idTaskINull=$_POST['listTaskProjInternNullCharges'];
    if ($idTaskINull != "") {
        $listChargesINull=getPRChargesCollabgivenYearMonth($idCollab,$year,$idTaskINull,$initMonth,$lastMonth);
        while ($data=$listChargesINull->fetch()) {
            if (isset($_POST["taskIntAffPlanMonth-".$data['mois']]) and $_POST["taskIntAffPlanMonth-".$data['mois']]!=$data['NbJoursPlan'] 
            and updateAffectation('NbJoursPlan',$_POST["taskIntAffPlanMonth-".$data['mois']],$data['ID']) and updateAffectation('NbJoursReal',$_POST["taskIntAffPlanMonth-".$data['mois']],$data['ID']) ) {
                $nbSuccess+=1;
            }
            elseif (isset($_POST["taskIntAffPlanMonth-".$data['mois']]) and $_POST["taskIntAffPlanMonth-".$data['mois']]!=$data['NbJoursPlan'] and !updateAffectation('NbJoursPlan',$_POST["taskIntAffPlanMonth-".$data['mois']],$data['ID'])){
                $nbFailure+=1;
            }
            if (isset($_POST["taskIntAffRealMonth-".$data['mois']]) and $_POST["taskIntAffRealMonth-".$data['mois']]!=$data['NbJoursReal'] and updateAffectation('NbJoursReal',$_POST["taskIntAffRealMonth-".$data['mois']],$data['ID'])) {
                $nbSuccess+=1;
            }
            elseif (isset($_POST["taskIntAffRealMonth-".$data['mois']]) and $_POST["taskIntAffRealMonth-".$data['mois']]!=$data['NbJoursReal'] and !updateAffectation('NbJoursReal',$_POST["taskIntAffRealMonth-".$data['mois']],$data['ID'])) {
                $nbFailure+=1;
            }
        }
    }

    

    // Message selon résultat de la mise à jour
    if ($nbFailure==0 and $nbSuccess!=0 ) {
        $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Mise(s) à jour effectuée(s) avec <strong>Success!</strong> .</div>';
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


    // $successCreate=0;
    // $failCreate=0;
    // Créations de nouvelles Imputations
    foreach ($_POST as $key => $value) {
        $val=explode("-",$key);
        if(($val[0]=="newImputPlan" or $val[0]=="newImputReal") and $value!="")
        {
            if(insertImputation($val[3],$val[4],$val[2],$val[1],$value,$value))
            {
                $successCreate+=1;
            }
            else{
                $failCreate+=1;
            }
        }
    }
    
     if ($failCreate==0 and $successCreate!=0 ) {
        $message.='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Créations effectuée(s) avec <strong>Success!</strong> .</div>';
    }
    elseif ($failCreate!=0 ) {
        $message.='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button>'.$nbFailure.' Erreur(s) de Création !</div>';
    }
    elseif ($failCreate==0 and $successCreate==0 ) {
        $message.='<div class="alert   alert-warning alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button>Aucune Création effectuée !</div>';
    } 


    $year=date('Y');
    $month=date("n");
    $initMonth=$month;
    $lastMonth=$month; 
    $initMonth="1";
    $lastMonth="12";
    $collab=getACollab($idCollab);
    $collab=$collab->fetch();
    $role=getACollabRole($idCollab);
    $role=$role->fetch();
    $puname=getACollabPU($idCollab);
    $puname=$puname->fetch();
    $siteName=getSiteName($collab['ID_Site']);
    $siteName=$siteName->fetch();
    $grade=getACollabGrade($idCollab);
    $grade=$grade->fetch();
    $dbRC=getACollabRC($idCollab); // RC in database
    $dbRC=$dbRC->fetch();
    $rateCard=$dbRC['RateCard'];
    $lastRC=getCollabCurrentYearRCIdVal($idCollab); // Last Ratecard
    $lastRC=$lastRC->fetch();
    if($lastRC and checkCollabFieldUpdated('ID_rateCard',$lastRC['rcID'],$idCollab) and updateCollab('ID_rateCard',$lastRC['rcID'],$idCollab)){
        $message.='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> Succes de mise à jour vers la dernière valeur de rateCard .</div>';
        $rateCard=$lastRC['rcVal'];
    }
    elseif($lastRC and checkCollabFieldUpdated('ID_rateCard',$lastRC['rcID'],$idCollab) and !updateCollab('ID_rateCard',$lastRC['rcID'],$idCollab)){
        $message.='<div class="alert   alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
        data-dismiss="alert" aria-label="close">&times;</button> Erreur de mise à jour vers la dernière valeur de rateCard .</div>';
    }
    $support=getSupportDetails($collab['ID_Support']);
    $support=$support->fetch();
    $manager=getManagerDetails($collab['ID_Manager']);
    $manager=$manager->fetch();
    $CM=getCMDetails($collab['ID_CM']);
    $CM=$CM->fetch();
    $listMois = array('1' => 'Janvier' ,'2' => 'Février','3' => 'Mars','4' => 'Avril','5' => 'Mai','6' => 'Juin',
    '7' => 'Juillet','8' => 'Août','9' => 'Septembre','10' => 'Octobre','11' => 'Novembre','12' => 'Décembre' );
    $totalPlannedCharges=array(); // Array des charges planifiées totales
    $totalRealCharges=array(); // Array des charges réelles totales
    
    for ($i=$initMonth; $i <= $lastMonth ; $i++) {
        $monthTotal=sumMonthChargesCurrentYear($i,$idCollab);
        $monthTotal=$monthTotal->fetch();
        $totalPlannedCharges[$i]=$monthTotal['sommePlan'];
        $totalRealCharges[$i]=$monthTotal['sommeReal'];
    }

    $wdCollab=array();
    for ($j=$initMonth; $j<=$lastMonth; $j++) { 
        $workingDaysCollab=workingDaysCollabGivenYearMonth($year,$j,$idCollab); // Jours ouvrables collaborateurs
        $data=$workingDaysCollab->fetch();
        $wdCollab[$j]=$data['NbJours'];
    }

    $noneInterntaskList=listNoneInternProjTasksCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth); //liste des activités de type non internes pour l'année sélectionnée
    $internTaskList=listInternProjTasksCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth); //Liste des activités de type interne
    $yearCollabNoneInternTasks=array();
    $yearCollabInternTasks=array();

    $projListNoneInternNullCharges=listNoneInternProjNullChargeCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth); // Liste projets non internes avec Charges Totales nulles
    $projListInternNullCharges=listInternProjNullChargeCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth); // Liste projets internes avec Charges Totales nulles


    $noneInterntaskList=listNoneInternProjTasksCollabCurrentYear($idCollab); //liste des activités de type non internes pour l'année en cours
    $internTaskList=listInternProjTasksCollabCurrentYear($idCollab); //Liste des activités de type interne
    $yearCollabNoneInternTasks=array();
    $yearCollabInternTasks=array();

    $projListNoneInternNullCharges=listNoneInternProjNullChargeCollabCurrentYear($idCollab); // Liste projets non internes avec Charges Totales nulles
    $projListInternNullCharges=listInternProjNullChargeCollabCurrentYear($idCollab); // Liste projets internes avec Charges Totales nulles

    // Parsing des tâches pour avoir les charges correspondantes
    //------ Cas Activités non internes
    if ($noneInterntaskList) {
        $i=1; // début incrément
        while ($data=$noneInterntaskList->fetch()) {
            $yearCollabNoneInternTasks[$i]=$data['Titre']."-".$data['Nom_Tache'].":".$data['idTache'].":".$data['commentaire'];
            ${"noneInternTaskCharges".$i}=getPRChargesCollabgivenYearMonth($idCollab,$year,$data['idTache'],$initMonth,$lastMonth); // List charges ppour la tâche
            $i++;
        } 
        $nbNoneInternTasks=$i-1; // Nb of Intern tasks founds 
    }
    for ($i=1; $i<=$nbNoneInternTasks ; $i++) {
        ${"noneInternTaskArrayCharges".$i}=array(); // array charges for the specified Task for filtered year and months
        for ($j=$initMonth; $j <=$lastMonth ; $j++) { // Initialization of the array
            ${"noneInternTaskArrayCharges".$i}[$j]="disabled";
        }
        //-----
        while ($data=${"noneInternTaskCharges".$i}->fetch()) {
            ${"noneInternTaskArrayCharges".$i}[$data['mois']]=$data['ID']."-".$data['NbJoursPlan'].'-'.$data['NbJoursReal'];
        }
    }
    
    
    //------ Cas Activités internes
    if ($internTaskList) {
        $i=1; // début incrément
        while ($data=$internTaskList->fetch()) {
            $yearCollabInternTasks[$i]=$data['Titre']."-".$data['Nom_Tache'].":".$data['idTache'].":".$data['commentaire'];
            ${"internTaskCharges".$i}=getPRChargesCollabgivenYearMonth($idCollab,$year,$data['idTache'],$initMonth,$lastMonth); // List charges ppour la tâche
            $i++;
        } 
        $nbInternTasks=$i-1; // Nb of Intern tasks founds 
    }
    for ($i=1; $i<=$nbInternTasks ; $i++) {
        ${"internTaskArrayCharges".$i}=array(); // array charges for the specified Task for filtered year and months
        for ($j=$initMonth; $j <=$lastMonth ; $j++) { // Initialization of the array
            ${"internTaskArrayCharges".$i}[$j]="disabled";
        }
        //-----
        while ($data=${"internTaskCharges".$i}->fetch()) {
            ${"internTaskArrayCharges".$i}[$data['mois']]=$data['ID']."-".$data['NbJoursPlan'].'-'.$data['NbJoursReal'];
        }
    }
  
    require('view/frontend/collabChargingPlanView.php');

} */



/****************************************************************************************************************************************************/
/*------------------------------------------------------------ SUPPORTS --------------------------------------------------------------------------- */
/****************************************************************************************************************************************************/
// Function to load the support Team List
function loadSupportTeamList()
{
    $message="";
    $supportTeam=getSupports();
    require('view/frontend/supportTeamView.php');
}


// Function to load a Support consultant's creation Page
function loadSupportCreationPage()
{
    require('view/frontend/supportCreationView.php');
}

// fonction chargement page après création Support
function loadSupportAfterCreation($nom,$prenom)
{
    if (strpos($nom,"\"")!==false or strpos($nom,":")!==false or strpos($prenom,"\"")!==false or strpos($prenom,":")!==false ) {
        $message='<div class="alert   alert-danger alert-dismissable"> 
        <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
        <strong>Erreur !<strong> les caractères double-quote et ":" sont interdits.</div>';
    }
    elseif ($nom=="" or $prenom=="" ) {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button>
         <strong>Erreur !<strong> Champs Nom et Prénom ne doivent pas être vides.</div>';
    }
    elseif (existSupport($nom,$prenom)) {
        $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> 
        <strong>Warning!</strong> Support déjà existant. </div>';
    }
    else {
        if(createSupport($nom,$prenom)) {
            $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;
            </button> Support rajouté avec <strong>Success!</strong> .</div>';
        }else {
            $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;
            </button> Erreur de création du nouveau Support.</div>';
        }
    }
    $supportTeam=getSupports();
    require('view/frontend/supportTeamView.php');

}



/****************************************************************************************************************************************************/
/*-------------------------------------------------------------- MANAGERS ------------------------------------------------------------------------- */
/****************************************************************************************************************************************************/
// Function to load the list of managers
function loadManagingTeamList()
{
    $message="";
    $puList=getPU();
    $managingTeam=getManagers();
    require('view/frontend/managingTeamView.php');
}



/****************************************************************************************************************************************************/
/*--------------------------------------------------------- CARRIER MANAGERS ---------------------------------------------------------------------- */
/****************************************************************************************************************************************************/
// Function to load the list of carrier managers
function loadCMTeamList()
{
    $message="";
    $puList=getPU();
    $CMTeam=getCarrierManagers();
    require('view/frontend/CMTeamView.php');
}



/****************************************************************************************************************************************************/
/*------------------------------------------------------------- PROJETS --------------------------------------------------------------------------- */
/****************************************************************************************************************************************************/
function loadProjectMainMenu() // Access to Project Management main menu
{
    $clients=getClients();
    require('view/frontend/gestionProjetsMainMenuView.php');
}


// Function to load a project Creation Page
function loadProjectCreationPage()
{
    $clientList=getClients();
    $puList=getPU();
    $pu="";
    $client="";
    $typeProjet="";
    $message="";
    $tbody="";
    require('view/frontend/gestionProjetsCreationView.php');
}


// Function to load a project Modification Page
function loadProjectModificationPage($idProject)
{
    $project=getProject($idProject);
    $project=$project->fetch();
    $clientList=getClients();
    $puList=getPU();
    $taskList=projectTaskList($idProject);
    $listActivityTypes=getActivityTypes(); //get the list of activities types
    $arrayAT=array();
    while ($data=$listActivityTypes->fetch()) {
        $arrayAT[$data['ID']]=$data['Nom_typeActivite'];
    }
    $message="";
    require('view/frontend/gestionProjetsModifView.php');
}

// Function to load a project Modification Page selected by its code
function loadProjectModificationPageByProjCode($projCode)
{
    $project=getProjectByCode($projCode);
    $project=$project->fetch();
    $clientList=getClients();
    $puList=getPU();
    $taskList=projectTaskList($project['ID']);
    $listActivityTypes=getActivityTypes(); //get the list of activities types
    $arrayAT=array();
    while ($data=$listActivityTypes->fetch()) {
        $arrayAT[$data['ID']]=$data['Nom_typeActivite'];
    }
    $message="";
    require('view/frontend/gestionProjetsModifView.php');
}

//Function to validate a new Function's Task
function newProjectTaskValidation()
{
    $idProj=getProjectIDbyCode($_POST['codeProjet']);
    $idProj=$idProj->fetch();
    $idProject=$idProj['ID'];
    $taskName=$_POST['taskName'];
    $typeActivity=$_POST['typeActivite'];

    //Vérification que le champ Tâche n'est pas vide
    if ($taskName=="" or $typeActivity=="") {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
        le champs "Tâche" est <strong>obligatoire<strong>. </div>';
    }
    // Verification absence de double-quotes dans le champ
    elseif (strpos($taskName,"\"")!==false) {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
        Les champs ne supportent pas les double-quote. </div>';
    }
    //Verification que la tache n'est pas existante pour le projet
    elseif (existTask($idProject,$taskName)) {
        $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> 
        La tâche est déjà existante pour le projet en cours. </div>';
    }
    else {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Echec de création de la tâche. </div>';
        // Création de la tâche
        $idNewTask=newTask($idProject,$taskName,$typeActivity);
        $message='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> succes de création de la tâche. </div>';
    }
    $project=getProject($idProject);
    $project=$project->fetch();
    $clientList=getClients();
    $puList=getPU();
    $taskList=projectTaskList($idProject);
    $listActivityTypes=getActivityTypes(); //get the list of activities types
    $arrayAT=array();
    while ($data=$listActivityTypes->fetch()) {
        $arrayAT[$data['ID']]=$data['Nom_typeActivite'];
    }
    require('view/frontend/gestionProjetsModifView.php');
}

// Function to load a project's Tasks affectation page
function loadProjectTasksAffPage()
{
    
    
    $idPU=$_POST['PU'];
    $codeProj=$_POST['codeProjet'];
    $titre=$_POST['titreProjet'];
    $commercial=$_POST['Commercial'];
    $RFA=$_POST['RFA'];
    $idClient=$_POST['client'];
    $typeProjet=$_POST['typeProjet'];
    $volJourVendu=$_POST['VolJourVendu'];
    $budget=$_POST['BudgetVendu'];
    if(!empty($_POST['codeGenerique']))
    {
        $codeGenerique=1; 
    }else{
        $codeGenerique=0;
    }

    $message="";
    $idProject=getProjectIDbyCode($codeProj);
    $idProj=$idProject->fetch();
    $project=getProject($idProj['ID']);
    $project=$project->fetch();
    $clientList=getClients();
    $puList=getPU();
    $collabs=getCollabs();
    $taskList=getProjectTasks($codeProj);
    $listAffect=projTasksAffList($idProj['ID']);
    //require('view/frontend/gestionProjetsAffCreationView.php');
    require('view/frontend/gestionProjetsAffModifView.php');
}

// Function to load a project's Tasks' Modification page
function loadProjectTasksAffModifPage($idProject)
{
    if (isset($_POST['client']) and !isset($_POST['projectCreation'])) {
        $caller="projMainMenu";
    }
    else {
        $caller="projModif";
    }
    $message="";
    $project=getProject($idProject);
    $project=$project->fetch();
    $clientList=getClients();
    $puList=getPU();
    $collabs=getCollabs(); // liste de Collabs
    $taskList=projectTaskList($idProject);
    $listAffect=projTasksAffList($idProject);
    require('view/frontend/gestionProjetsAffModifView.php');
}

// Function to load a project's Tasks' Modification page selected by its Code
function loadProjectTasksAffModifPageByProjCode($projCode)
{ 
    if (isset($_POST['projectCode']) and !isset($_POST['projectCreation'])) {
        $caller="projMainMenu";
    }
    else {
        $caller="projModif";
    }
    $message="";
    $project=getProjectByCode($projCode);;
    $project=$project->fetch();
    $clientList=getClients();
    $puList=getPU();
    $collabs=getCollabs(); // liste de Collabs
    $taskList=projectTaskList($project['ID']);
    $listAffect=projTasksAffList($project['ID']);
    require('view/frontend/gestionProjetsAffModifView.php');
}


// Function to affect a Task before reload
function taskAffValidation()
{
    $idProj=getProjectIDbyCode($_POST['codeProjet']);
    $idProj=$idProj->fetch();
    $idProject=$idProj['ID'];
    $idCollab=$_POST['collab'];
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
    $sowid=$_POST['sowid'];
    $odm=$_POST['odm'];
    $coverage=$_POST['coverage'];
    if (isset($_POST['FOPCheck'])) {
        $fop=1;
    }
    else {
        $fop=0;
    }

    // Translate months in number
    $mois=array('Janvier'=>'1','Fevrier'=>'2','Mars'=>'3','Avril'=>'4','Mai'=>'5','Juin'=>'6','Juillet'=>'7',
    'Août'=>'8','Septembre'=>'9','Octobre'=>'10','Novembre'=>'11','Décembre'=>'12');
    //Obtain the periods of affectations if exist
    $listperiods=getTaskAffectationPeriods($idCollab,$task);
    $recover=false;
    if ($listperiods) {
        while ($data=$listperiods->fetch() and $recover==false) {
            if (!($debutAnnee>$data['Annee_Fin'] or $finAnnee<$data['Annee_Debut'] or ($data['Annee_Debut']==$data['Annee_Fin'] and $debutAnnee==$finAnnee and $debutAnnee==$data['Annee_Debut'] 
                    and ($mois[$debutMois]>$data['Mois_Fin'] or $mois[$finMois]<$data['Mois_Debut'])))) {
                    $recover=true;
            }
        }
    }


    //Création d'une Affectation à la tâche d'un projet
    if ($idCollab=="" or $task=="" or $tjm=="" or $debutAnnee=="" or $debutMois=="" or $finAnnee=="" or $finMois=="" or $sowid=="") 
    {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
        Les Champs Collab, Tâche, TJM, SOW-ID,dates de début et de Fin sont obligatoires. </div>';
    }
    elseif (!is_numeric($tjm) or !is_numeric($budgetInit) or !is_numeric($budgetComp) or !is_numeric($volJoursInit) or !is_numeric($volJoursComp) or !is_numeric($fraisInit) or !is_numeric($fraisComp) or !is_numeric($sowid) 
            or !is_numeric($autresCouts) or $tjm<0 or $budgetInit<0 or $budgetComp<0 or $volJoursInit<0 or $volJoursComp<0 or $fraisInit<0 or $fraisComp<0 or $sowid<0 or $autresCouts<0  ) {
                $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
                Les éléments suivants doivent être des nombres positifs ou nuls : TJM, Budget(s), Volume Jour(s), Frais, Autres Cout(s),SOW-ID . </div>';
    }
    elseif ( $mois[$debutMois] > $mois[$finMois]) {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
        Les Mois et/ou Année de fin sont antérieures à celles de début!. </div>';
    }
    elseif ($debutAnnee!=$finAnnee ) {
        $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
        Les Années de Début et de Fin doivent être identiques!. </div>';
    }
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
                for ($i=$mois[$debutMois]; $i <=12 ; $i++) { 
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
                }
                $message2='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button>'.$inputOK.' succès d\'imputation(s) nulles </div>';
                $message3='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button>'.$inputKO.' echecs d\'imputation(s) nulles </div>';
            }
            $message=$message1.$message2.$message3;
        }else {
            $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Echec de rajout de l\'affectation. </div>';
        }
    
    }


    $project=getProject($idProject);
    $project=$project->fetch();
    $clientList=getClients();
    $puList=getPU();
    $collabs=getCollabs(); // liste de Collabs
    $taskList=projectTaskList($idProject);
    $listAffect=projTasksAffList($idProject);
    require('view/frontend/gestionProjetsAffModifView.php');
}