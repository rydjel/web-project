<?php
require('controller/frontend.php'); 
try {
    // Traitement des choix de l'utilisateur
    if (isset($_POST['ValidationWelcomeView']) and $_POST['DR']!="Sélectionner ...")
    {
        switch ($_POST['DR']) {
            case 'Rate Card':
                loadRateCards();
                break;

            case 'Clients':
                loadClients("");
                break;

            case 'Production Unit':
                loadProductionUnit();
                break;

            case 'Sites':
                loadSites();
                break;

            case 'Market Unit':
                loadMarketUnit();
                break;
            
            case 'Jours Ouvrables':
                loadcurrentYearWorkingDays();
                break;

            case 'Types Activités':
                loadActivityType();
                break;
            
            case 'Manager':
                loadManagingTeamList();
                break;
            
            case 'Carrier Manager':
                loadCMTeamList();
                break;

            case 'Support':
                loadSupportTeamList();
                break; 
            
            case 'profilTitle':
                loadPT();
                break;

            case 'defaultTask':
                loadDT();
                break;

            case 'PNL-KPI-TYPE':
                loadKpiType();
                break;
                
            case 'PNL-KPI':
                loadPnlKpi();
                break;   
        }
    }
    elseif (isset($_POST['gestionCollab'])) {
        loadGestionCollabMainMenu();
    }
    elseif (isset($_POST['planDeChargeCollab'])) {
        loadChargingPlanCollabMainMenu();
    }
    elseif (isset($_POST['gestionProjet'])) {
        loadProjectMainMenu();
    }
    elseif (isset($_POST['clientCreation'])) {
        loadClientsCreation();
    }
    elseif (isset($_POST['clientCreationRegistration'])) {
        loadClientsAfterCreation($_POST['client'],$_POST['marketUnit']);
    }
    elseif (isset($_POST['clientCancel'])) {
        loadClients("");
    }
    elseif (isset($_POST['productUnitCreation'])) {
        loadPUCreation();
    }
    elseif (isset($_POST['productUnitCancel'])) {
        loadProductionUnit();
    }
    elseif (isset($_POST['marketUnitCreation'])) {
        loadMUCreation();
    }
    elseif (isset($_POST['marketUnitRegistrationCreation'])) {
         if (empty($_POST["regionMU"])) {
            $region=0;
        }
        else {
            $region=1;
        }     
        loadMUAfterCreation($_POST['MU']);

    }
    elseif (isset($_POST['marketUnitCancel'])) {
        loadMarketUnit();
    }
    elseif (isset($_POST['yearJOFilter'])) {
        loadGivenYearWorkingDays($_POST['yearJO']);
    }
    elseif (isset($_POST['ATCancel'])) {
        loadActivityType();
    }
    elseif (isset($_POST['ATCreation'])) {
        loadATCreation();
    }
    elseif (isset($_POST['ATRegistrationCreation'])) {
        if (empty($_POST["facturable"])) {
            $facturable=0;
        }
        else {
            $facturable=1;
        }
        loadATAfterCreation($_POST['AT'],$_POST['impactTACE'],$facturable);
    }
    elseif (isset($_POST['RegionRCFilter'])) {
        loadRateCardsGivenYearRegion($_POST['yearRC'],$_POST['regionRC']);
    }
    elseif (isset($_POST['rateCardCancel'])) {
        loadRateCards();
    }
    elseif (isset($_POST['rateCardCreation'])) {
        loadRateCardCreation();
    }
    elseif (isset($_POST['rateCardRegistrationCreation'])) {
        loadRCAfterCreation($_POST['CodeRC'],$_POST['RoleRC'],$_POST['GradeRC'],$_POST['RegionRC'],$_POST['rateCardRC'],$_POST['AnneeRC']);
    }
    elseif (isset($_POST['collabConsultation']) and !empty($_POST['collab'])) {
        loadCollabConsultation($_POST['collab']);
    }
    elseif (isset($_POST['collabConsultation']) and empty($_POST['collab'])) {
        loadGestionCollabMainMenu();
    }
    elseif (isset($_POST['yearJOCollabFilter'])) {
        loadfilteredYearCollabConsultation($_POST['collab'],$_POST['yearJOCollab']);
    }
    elseif (isset($_POST['collabCancel'])) {
        loadGestionCollabMainMenu();
    }
    elseif (isset($_POST['collabCreation'])) {
        loadCollabCreation();
    }
    elseif (isset($_POST['yearJOCollabCreationFilter'])) {
        loadFilteredYearCollabCreation($_POST['yearJOCollabCreation']);
    }
    elseif (isset($_POST['collabModification']) and !empty($_POST['collab'])) {
        loadCollabModification($_POST['collab']);
    }
    elseif (isset($_POST['accessCollabProfil']) and !empty($_POST['collab'])) {
        loadCollabModification($_POST['collab']);
    }
    elseif (isset($_POST['collabModification']) and empty($_POST['collab'])) {
        loadGestionCollabMainMenu($_POST['collab']);
    }
    elseif (isset($_POST['yearJOCollabModificationFilter'])) {
        loadFilteredYearCollabModification($_POST['yearJOCollabModification'],$_POST['collab']);
    }
    elseif (isset($_POST['collabCPConsultation']) and $_POST['collab'] != "Sélectionner un Collaborateur ... " ) {
        loadCollabChargingPlan($_POST['collab']);
    }
    elseif (isset($_POST['ManagerCollabsCPConsultation']) and $_POST['manager'] != "Sélectionner un Manager ..." ) {
        loadManagerCollabsChargingPlan($_POST['manager']); // Access to the Charging Plans of the Manager's Collabs
    }
    elseif (isset($_POST['yearMonthChargesCollabFilter'])) {
        loadCollabChargingPlanFilteredYearMonth($_POST['collab'],$_POST['yearChargesCollab'],$_POST['InitMonthChargesCollab'],$_POST['LastMonthChargesCollab']);
    }
    elseif (isset($_POST['collabNewImputations']) and $_POST['collab'] != "Sélectionner un Collaborateur ... " ) {
        loadCollabImputationCreation($_POST['collab']);
    }
    elseif (isset($_POST['yearMonthToImputeCollabFilter'])) {
        loadCollabImputationCreationFilteredYearMonth($_POST['collab'],$_POST['yearChargesCollab'],$_POST['InitMonthChargesCollab'],$_POST['LastMonthChargesCollab']);
    }
    elseif (isset($_POST['CollabImputationUpdateValidation'])) {
        validateCollabImputationUpdate();
    }
    elseif (isset($_POST['collabChargePlanCancel'])) {
        loadChargingPlanCollabMainMenu();
    }
    elseif (isset($_POST['collabCPModification']) and $_POST['collab'] != "Sélectionner un Collaborateur ... " ) {
        loadCollabChargingPlanModif($_POST['collab']);
    }
    elseif (isset($_POST['yearChargesCollabModifFilter'])) {
        loadFilteredYearCollabChargingPlanModif($_POST['yearChargesCollabModif'],$_POST['collab']);
    }
    elseif (isset($_POST['projectCreation'])) {
        loadProjectCreationPage();
    }
    elseif (isset($_POST['projectModification']) and isset($_POST['client'])) {
        loadProjectModificationPage($_POST['projet']);
    }
    elseif (isset($_POST['projectModification']) and isset($_POST['projectCode'])) {
        loadProjectModificationPageByProjCode($_POST['projectCode']);
    }
    elseif (isset($_POST['accessProjModif'])) {
        loadProjectModificationPageByProjCode($_POST['accessProjModif']);
    }
    elseif (isset($_POST['projCancel'])) {
        loadProjectMainMenu();
    }
    elseif (isset($_POST['projTaskAffCancel']) and $_POST['callerView']=='projMainMenu') {
        loadProjectMainMenu();
    }
    elseif (isset($_POST['projTaskAffCancel']) and $_POST['callerView']=='projModif') {
        loadProjectModificationPageByProjCode($_POST['codeProjet']);
    }
    elseif (isset($_POST['taskAffectation'])) {
        loadProjectTasksAffModifPageByProjCode($_POST['codeProjet']);
    }
    elseif (isset($_POST['affectationModif']) and isset($_POST['client'])) {
        loadProjectTasksAffModifPage($_POST['projet']);
    }
    elseif (isset($_POST['affectationModif']) and isset($_POST['projectCode'])) {
        loadProjectTasksAffModifPageByProjCode($_POST['projectCode']);
    }
    elseif (isset($_POST['accessAffModif'])) {
        loadProjectTasksAffModifPageByProjCode($_POST['accessAffModif']);
    }
    elseif (isset($_POST['taskAffectModif'])) {
        loadProjectTasksAffModifPageByProjCode($_POST['codeProjet']);
    }
    elseif (isset($_POST['newTaskValidation'])) {
        newProjectTaskValidation();
    }
    elseif (isset($_POST['collabProfilAdd'])) {
        collabProfilValidation();
    }
    elseif (isset($_POST['collabCompValidation'])) {
        collabCompetenceValidation();
    }
    elseif (isset($_POST['collabCertifValid'])) {
        collabCertificationValidation();
    }
    elseif (isset($_POST['ExpValid'])) {
        collabExperienceValidation();
    }
    elseif (isset($_POST['AffectValidation'])) {
        taskAffValidation();
    }
    elseif (isset($_POST['supportCreation'])) {
        loadSupportCreationPage();
    }
    elseif (isset($_POST['supportCancel'])) {
        loadSupportTeamList();
    }
    elseif (isset($_POST['supportRegistrationCreation'])) {
        loadSupportAfterCreation($_POST['nomSupport'],$_POST['prenomSupport']);
    }

    else {
        // Chargement de la page d'accueil
        welcome();      
    }
} catch (Exception $e) {
    // En cas d'erreur, on afiche un message et on arrete tout
    die('Erreur : ' . $e->getMessage());
}
