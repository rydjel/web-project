<?php


//   Get access to the list of RateCards records with their corresponding region
//   Only RateCards valid for the current Date are selected
/***************************************************************************************************************************************/
/*-------------------------------------------------- RATE CARDS ---------------------------------------------------------------------  */
/***************************************************************************************************************************************/
// Acces Rate Cards Valables à la date du jour
function getRateCards($year)
{
    $db = dbConnect();
    $req=$db->query('select ID, Region, Role, Code, Grade, RateCard from ratecard where Annee="'.$year.'"
    ORDER by Region ASC, Role ASC, Code asc, Grade asc, RateCard asc');
    return $req;
}

// Function to get the rateCard ID
function getRateCardID($ratecard)
{
    $db = dbConnect();
    $req=$db->query('select ID from ratecard where RateCard="'.$ratecard.'"');
    return $req; 
}

//function to access a collab rate Card
function getACollabRateCard($idCollab)
{
    $db = dbConnect();
    $req=$db->query('select ratecard.RateCard from collaborateurs INNER join ratecard on collaborateurs.ID_rateCard=ratecard.ID where collaborateurs.ID="'.$idCollab.'"');
    return $req; 
}

// Access Rate card roles
function getRoles()
{
    $db = dbConnect();
    $req=$db->query('select distinct Role from ratecard');
    return $req; 
}

//Access roles of a site
function siteRoles($region)
{
    /* $region=2;
    if ($site=='IDF') {
        $region=0;
    }elseif($site!='') {
        $region=1;
    } */
    $db = dbConnect();
    $req=$db->query('select distinct Role from ratecard where ratecard.Region="'.$region.'"');
    return $req; 
}

// get rateCard and grade from Site, Role and Entry date
function gradeAndRC($region,$role,$dateEntree)
{
    /* $region=2;
    if ($site=='IDF') {
        $region=0;
    }elseif($site!='') {
        $region=1;
    } */
    $year=date("Y",strtotime($dateEntree));
    $db = dbConnect();
    $req=$db->query('select ratecard.Grade, ratecard.RateCard FROM ratecard where ratecard.Role="'.$role.'" and ratecard.Annee="'.$year.'"and ratecard.Region="'.$region.'"');
    return $req; 
}

// get current year grade and rateCard
function currentYearGradeAndRC($region,$role)
{
    $year=date("Y");
    $db = dbConnect();
    $req=$db->query('select ratecard.Grade, ratecard.RateCard FROM ratecard where ratecard.Role="'.$role.'" and ratecard.Annee="'.$year.'"and ratecard.Region="'.$region.'"');
    return $req; 
}


// Access Rate Cards valables à la date du jour et datant d'une année donnée
function getRateCardsGivenYearRegion($year,$region)
{
    $db = dbConnect();
    if ($region==0 or $region==1) {
        $req=$db->query('select ID, Region, Role, Code, Grade, RateCard from RateCard where ratecard.Annee="'.$year.'" and Region="'.$region.'"
        ORDER by Region ASC, Role ASC, Code asc, Grade asc, RateCard asc');
    }
    else{
        $req=$db->query('select ID, Region, Role, Code, Grade, RateCard from RateCard where ratecard.Annee="'.$year.'"
        ORDER by Region ASC, Role ASC, Code asc, Grade asc, RateCard asc');
    }
    return $req;
}


// Function to check if a rate Card exists
function existRateCard($code,$role,$grade,$region,$year)
{
    $db=dbConnect();
    $req=$db->query('select * from RateCard where Code="'.$code.'" and Role="'.$role.'" and Grade="'.$grade.'" and Region="'.$region.'" and Annee="'.$year.'"');
    //$rowcount=mysqli_num_rows($req);
   if ($req->fetchColumn()>0) {
       return true; // CLient already exists
   }
   else {
       return false; // Client doesn't exit
   }
}

// Get rate Card ID -- 2nd Version
function rateCardID($ratecard,$role,$grade,$region,$year)
{
    $db=dbConnect();
    $req=$db->query('select ID from RateCard where RateCard="'.$ratecard.'" and Role="'.$role.'" and Grade="'.$grade.'" and Region="'.$region.'" and Annee="'.$year.'"');
    return $req;
}

//Function to create a new rate Card
function createRateCard($code,$role,$grade,$region,$rateCard,$year)
{
    $created=insertRateCard($code,$role,$grade,$region,$rateCard,$year);
    return $created;
}

// Function to insert a new rate Card
function insertRateCard($code,$role,$grade,$region,$rateCard,$year)
{
    $db=dbConnect();
    $traductionRegion= array('IDF' =>'0','Région'=>'1','Tous'=>'2');
    $req=$db->prepare('INSERT INTO RateCard(Code,Role,Grade,Region,RateCard,Annee) VALUES("'.$code.'","'.$role.'","'.$grade.'","'.$traductionRegion[$region].'","'.$rateCard.'","'.$year.'")');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to update a Rate Card
function updateRateCard($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE RateCard SET '.$field.'="'.$value.'"WHERE ID="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a field in a Rate Card record has been updated
function checkRCFieldUpdated_($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from RateCard where ID="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}

//Function to load a rateCard
function getRCDetails($idrateCard)
{
    $db = dbConnect();
    $req=$db->query('select * from ratecard where ID="'.$idrateCard.'"');
    return $req; 
}

//function to get current year rateCard
function getCollabCurrentYearRC($idCollab)
{
    $db = dbConnect();
    $req=$db->query('select ratecard.RateCard 
    from ratecard 
    WHERE ratecard.Role=(SELECT ratecard.Role from ratecard inner join collaborateurs on collaborateurs.ID_rateCard=ratecard.ID WHERE collaborateurs.ID="'.$idCollab.'") 
    and ratecard.Region=(SELECT ratecard.Region from ratecard inner join collaborateurs on collaborateurs.ID_rateCard=ratecard.ID WHERE collaborateurs.ID="'.$idCollab.'") 
    and ratecard.Annee=year(CURRENT_DATE)');
    return $req; 
}

// function to get current year ratecard's value and ID
function getCollabCurrentYearRCIdVal($idCollab)
{
    $db = dbConnect();
    $req=$db->query('select ratecard.RateCard as rcVal, ratecard.ID as rcID
    from ratecard 
    WHERE ratecard.Role=(SELECT ratecard.Role from ratecard inner join collaborateurs on collaborateurs.ID_rateCard=ratecard.ID WHERE collaborateurs.ID="'.$idCollab.'") 
    and ratecard.Region=(SELECT ratecard.Region from ratecard inner join collaborateurs on collaborateurs.ID_rateCard=ratecard.ID WHERE collaborateurs.ID="'.$idCollab.'") 
    and ratecard.Annee=year(CURRENT_DATE)');
    return $req; 
}


/***************************************************************************************************************************************/
/* ----------------------------------------------- MARKET UNITS -----------------------------------------------------------------------*/
/***************************************************************************************************************************************/

// Get access to the list of MarketUnits
function getMarketUnits()
{
    $db=dbConnect();
    $req=$db->query('select * from MarketUnit');
    return $req;
}

// Get access to MU ID
function getMUID($muName)
{
    $db=dbConnect();
    $req=$db->query('select ID from MarketUnit where Nom="'.$muName.'"');
    $mu=$req->fetch();
    return $mu;
}

// Function to check if a MarketUnit exists
function existMU($muName)
{
    $db=dbConnect();
    $req=$db->query('select * from MarketUnit where Nom="'.$muName.'"');
    //$rowcount=mysqli_num_rows($req);
   if ($req->fetchColumn()>0) {
       return true; // CLient already exists
   }
   else {
       return false; // Client doesn't exit
   }
}

//Function to create a new Market Unit
function createMU($muName)
{
    $created=insertMU($muName);
    return $created;
}

// Function to insert a Production Unit
function insertMU($muName)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO MarketUnit(Nom) VALUES("'.$muName.'")');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to update a MU
function updateMU($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE MarketUnit SET '.$field.'="'.$value.'"WHERE ID="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a field in a MU record has been updated
function checkMUFieldUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from MarketUnit where ID="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}

//Function to load a MU
function getMUDetails($idMU)
{
    $db = dbConnect();
    $req=$db->query('select * from marketunit where marketunit.ID="'.$idMU.'"');
    return $req; 
}


/******************************************************************************************************************************************/
/* ---------------------------------------------------------INTITULE PROFIL --------------------------------------------------------------*/
/******************************************************************************************************************************************/
// Get access to the list of profil titles
function getProfilTitles()
{
    $db=dbConnect();
    $req=$db->query('select * from intituleprofil');
    return $req;
}



// Function to check if a profil title exists
function existPT($intitule)
{
    $db=dbConnect();
    $req=$db->query('select * from intituleprofil where intitule="'.$intitule.'"');
    //$rowcount=mysqli_num_rows($req);
   if ($req->fetchColumn()>0) {
       return true; // CLient already exists
   }
   else {
       return false; // Client doesn't exit
   }
}

//Function to create a new profil title
function createPT($intitule)
{
    $created=insertPT($intitule);
    return $created;
}

// Function to insert a Profil Title
function insertPT($intitule)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO intituleprofil(intitule) VALUES("'.$intitule.'")');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to update a Profil Title (PT)
function updatePT($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE intituleprofil SET '.$field.'="'.$value.'"WHERE ID="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a field in a PT record has been updated
function checkPTFieldUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from intituleprofil where ID="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}

//Function to load a PT
function getPTDetails($idPT)
{
    $db = dbConnect();
    $req=$db->query('select * from intituleprofil where intituleprofil.ID="'.$idPT.'"');
    return $req; 
}

/******************************************************************************************************************************************/
/* ------------------------------------------------------- CLIENTS -----------------------------------------------------------------------*/
/******************************************************************************************************************************************/

// Get access to the list of CLients
function getClients()
{
    $db=dbConnect();
    $req=$db->query('select * from Client order by NomClient');
    return $req;
}

// Get access to client ID
function getClientID($clientName)
{
    $db=dbConnect();
    $req=$db->query('select ID from Client where NomCLient="'.$clientName.'"');
    $client=$req->fetch();
    return $client;
}


// Function to check if a client exists
function existClient($customerName)
{
    $db=dbConnect();
    $req=$db->query('select * from Client where NomCLient="'.$customerName.'"');
    //$rowcount=mysqli_num_rows($req);
   if ($req->fetchColumn()>0) {
       return true; // CLient already exists
   }
   else {
       return false; // Client doesn't exit
   }
}

// Function to get the MarketUnit's ID
function getIDMarketUnit($marketUnitName)
{
    $db=dbConnect();
    $req=$db->query('select ID from MarketUnit where Nom="'.$marketUnitName.'"');
    $id=$req->fetch();
    return $id['ID'];
}

// Function to get the fields of a client Table
function getClientRowsFields()
{
    $db=dbConnect();
    $req=$db->query('select Client.ID, NomClient, MarketUnit.Nom as nomMU from Client inner join MarketUnit on Client.ID_MarketUnit=MarketUnit.ID order by NomClient asc');
    return $req;
}


//Function to create a new client 
function createClient($customerName,$marketUnitName)
{
    $idMarketUnit=getIDMarketUnit($marketUnitName);
    $created=insertClient($customerName,$idMarketUnit);
    return $created;
}

// Function to insert a client
function insertClient($clientName,$idMarketUnit)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO Client(NomClient,ID_MarketUnit) VALUES("'.$clientName.'","'.$idMarketUnit.'")');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to update a client
function updateClient($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE Client SET '.$field.'="'.$value.'"WHERE ID="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a field has been updated
function checkFieldUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from Client where ID="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}

//Function to load a client
function getClientDetails($idClient)
{
    $db = dbConnect();
    $req=$db->query('select client.NomClient, marketunit.Nom as nomMU from client inner join marketunit 
    on client.ID_MarketUnit=marketunit.ID where client.ID="'.$idClient.'"');
    return $req; 
}


/******************************************************************************************************************************************/
/* -------------------------------------------------------PNL KPI TYPES ------------------------------------------------------------------*/
/******************************************************************************************************************************************/

// Get access to the list of pnl kpi types
function getPnlKPIType()
{
    $db=dbConnect();
    $req=$db->query('select * from pnlkpitype order by type');
    return $req;
}

// Get access to pnl kpi type ID
function getPnlKPITypeID($type)
{
    $db=dbConnect();
    $req=$db->query('select id_pnlkpitype from pnlkpitype where type="'.$type.'"');
    $kpiType=$req->fetch();
    return $kpiType;
}


// Function to check if a pnl kpi type exists
function existPnlKPIType($type)
{
    $db=dbConnect();
    $req=$db->query('select * from pnlkpitype where type="'.$type.'"');
    //$rowcount=mysqli_num_rows($req);
   if ($req->fetchColumn()>0) {
       return true; // already exists
   }
   else {
       return false; // doesn't exit
   }
}



//Function to create a new PNL KPI Type 
function createPnlKPIType($type)
{
    $created=insertPnlKPIType($type);
    return $created;
}

// Function to insert a new PNL KPI Type
function insertPnlKPIType($type)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO pnlkpitype(type) VALUES("'.$type.'")');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to update a PNL KPI Type
function updatePnlKPIType($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE pnlkpitype SET '.$field.'="'.$value.'"WHERE id_pnlkpitype="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a field has been updated
function checkPnlKPITypeFieldUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from pnlkpitype where id_pnlkpitype="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}

//Function to load a PNL KPI Type
function getPnlKPITypeDetails($id_pnlkpitype)
{
    $db = dbConnect();
    $req=$db->query('select pnlkpitype.type from pnlkpitype where pnlkpitype.id_pnlkpitype="'.$id_pnlkpitype.'"');
    return $req; 
}



/******************************************************************************************************************************************/
/* ------------------------------------------------------------PNL KPI  ------------------------------------------------------------------*/
/******************************************************************************************************************************************/

// Get access to the list of pnl kpi 
function getPnlKPI()
{
    $db=dbConnect();
    $req=$db->query('select * from pnlkpi');
    return $req;
}

// Get access to pnl kpi  ID
function getPnlKpiID($idKpiType,$idMois)
{
    $db=dbConnect();
    $req=$db->query('select id_pnlkpi from pnlkpi where id_pnlkpitype="'.$idKpiType.'" and id_mois="'.$idMois.'"');
    $kpi=$req->fetch();
    return $kpi;
}


// Function to check if a pnl kpi exists
function existPnlKpi($idKpiType,$idMois)
{
    $db=dbConnect();
    $req=$db->query('select * from pnlkpi where id_pnlkpitype="'.$idKpiType.'" and id_mois="'.$idMois.'"');
    //$rowcount=mysqli_num_rows($req);
   if ($req->fetchColumn()>0) {
       return true; // already exists
   }
   else {
       return false; // doesn't exit
   }
}



//Function to create a new PNL KPI 
function createPnlKpi($idKpiType,$idMois,$budget,$forecast)
{
    $created=insertPnlKpi($idKpiType,$idMois,$budget,$forecast);
    return $created;
}

// Function to insert a new PNL KPI 
function insertPnlKpi($idKpiType,$idMois,$budget,$forecast)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO pnlkpi(id_pnlkpitype,id_mois,budget,forecast) VALUES("'.$idKpiType.'","'.$idMois.'","'.$budget.'","'.$forecast.'")');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to update a PNL KPI
function updatePnlKpi($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE pnlkpi SET '.$field.'="'.$value.'"WHERE id_pnlkpi="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a field has been updated
function checkPnlKpiFieldUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from pnlkpi where id_pnlkpi="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}

//Function to load a PNL KPI
function getPnlKpiDetails($id_pnlkpi)
{
    $db = dbConnect();
    $req=$db->query('select * from pnlkpi where pnlkpi.id_pnlkpi="'.$id_pnlkpi.'"');
    return $req; 
}


/******************************************************************************************************************************************/
/* -------------------------------------------------------------  MOIS ------------------------------------------------------------------*/
/******************************************************************************************************************************************/

// Get access to the list of months
function getMonths()
{
    $db=dbConnect();
    $req=$db->query('select mois.ID, mois.nom_mois from mois');
    return $req;
}

// get Month ID
function getMonthID($numMonth)
{
    $db=dbConnect();
    $req=$db->query('select mois.ID from mois where num_mois="'.$numMonth.'"');
    return $req;
}




/*****************************************************************************************************************************************/
/*--------------------------------------------------- TACHES PAR DEFAUT -----------------------------------------------------------------*/
/*****************************************************************************************************************************************/
// Get access to the list of Default Tasks
function getDefaultTasks()
{
    $db=dbConnect();
    $req=$db->query('select * from tachespardefaut');
    return $req;
}

// Get access to DT Id
function getDT_ID($taskName)
{
    $db=dbConnect();
    $req=$db->query('select ID_DT from tachespardefaut where nomTache="'.$taskName.'"');
    $task=$req->fetch();
    return $task;
}

// Get DT by ID
function getDTbyID($idDT)
{
    $db=dbConnect();
    $req=$db->query('select tachespardefaut.nomTache, tachespardefaut.ID_TypeActivite, typeactivite.Impact_TACE from tachespardefaut
    inner join typeactivite on tachespardefaut.ID_TypeActivite=typeactivite.ID where ID_DT="'.$idDT.'"');
    return $req;
}

// Function to check if a Default Task exists
function existDT($taskName)
{
    $db=dbConnect();
    $req=$db->query('select * from tachespardefaut where nomTache="'.$taskName.'"');
    //$rowcount=mysqli_num_rows($req);
   if ($req->fetchColumn()>0) {
       return true; // DT already exists
   }
   else {
       return false; // DT doesn't exit
   }
}



//Function to update a DT
function updateDT($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE tachespardefaut SET '.$field.'="'.$value.'"WHERE ID_DT="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a field has been updated
function checkDTFieldUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from tachespardefaut where ID_DT="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}

//Function to load a DT
function getDTDetails($idDT)
{
    $db = dbConnect();
    $req=$db->query('select tachespardefaut.nomTache, tachespardefaut.ID_TypeActivite from tachespardefaut where tachespardefaut.ID_DT="'.$idDT.'"');
    return $req; 
}

/***************************************************************************************************************************************/
/* ------------------------------------------------------- PRODUCTION UNIT ----------------------------------------------------------- */
/***************************************************************************************************************************************/

// Get access to the list of PU
function getPU()
{
    $db=dbConnect();
    $req=$db->query('select * from ProductionUnit');
    return $req;
}

// Get the Collabs' PU
function getCollabsPU()
{
    $db=dbConnect();
    $req=$db->query('select productionunit.ID,productionunit.Nom,productionunit.Region from ProductionUnit where productionunit.MU=0');
    return $req;
}

// Get access to PU ID
function getPUID($puName)
{
    $db=dbConnect();
    $req=$db->query('select ID from ProductionUnit where Nom="'.$puName.'"');
    return $req;
}

// Get access to PU entity ID
function getPUEntID($puID)
{
    $db=dbConnect();
    $req=$db->query('select ID_entite from ProductionUnit where ID="'.$puID.'"');
    return $req;
}

// Function to check if a ProductionUnit exists
function existPU($puName)
{
    $db=dbConnect();
    $req=$db->query('select * from ProductionUnit where Nom="'.$puName.'"');
    //$rowcount=mysqli_num_rows($req);
   if ($req->fetchColumn()>0) {
       return true; // CLient already exists
   }
   else {
       return false; // Client doesn't exit
   }
}

//Function to create a new Production Unit
function createPU($puName,$region,$MU,$idEntite)
{
    $created=insertPU($puName,$region,$MU,$idEntite);
    return $created;
}

// Function to insert a Production Unit
function insertPU($puName,$region,$MU,$idEntite)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO ProductionUnit(Nom,Region,MU,ID_entite) VALUES("'.$puName.'","'.$region.'","'.$MU.'",'.$idEntite.')');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to update a PU
function updatePU($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE ProductionUnit SET '.$field.'='.$value.' WHERE ID="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a field in a PU record has been updated
function checkPUFieldUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from ProductionUnit where ID="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}

//Function to load a PU
function getPUDetails($idPU)
{
    $db = dbConnect();
    $req=$db->query('select * from productionunit where productionunit.ID="'.$idPU.'"');
    return $req; 
}


/***************************************************************************************************************************************/
/* ------------------------------------------------------------ ENTITES ---------------------------------------------------------------- */
/***************************************************************************************************************************************/
// Get access to the list of entities
function getEntities()
{
    $db=dbConnect();
    $req=$db->query('select * from entite');
    return $req;
}



/***************************************************************************************************************************************/
/* ------------------------------------------------------------ SITES ---------------------------------------------------------------- */
/***************************************************************************************************************************************/

// Get access to the list of Sites
function getSites()
{
    $db=dbConnect();
    $req=$db->query('select * from site');
    return $req;
}

// Get access to Site ID
function getSiteID($siteName)
{
    $db=dbConnect();
    $req=$db->query('select ID from site where Nom="'.$siteName.'"');
    return $req;
}


//Get access to site region
function getSiteRegion($siteID)
{
    $db=dbConnect();
    $req=$db->query('select site.Region from site where site.ID="'.$siteID.'"');
    return $req;
}

//Get a site Name
function getSiteName($siteID)
{
    $db=dbConnect();
    $req=$db->query('select site.Nom from site where site.ID="'.$siteID.'"');
    return $req;
}

//get Collab Site Region 
function getCollabSiteRegion($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select site.Region from site inner join collaborateurs on collaborateurs.ID_Site=site.ID where collaborateurs.ID="'.$idCollab.'"');
    return $req;
}

// Function to check if a Site exists
function existSite($siteName)
{
    $db=dbConnect();
    $req=$db->query('select * from site where Nom="'.$siteName.'"');
    //$rowcount=mysqli_num_rows($req);
   if ($req->fetchColumn()>0) {
       return true; // Site already exists
   }
   else {
       return false; // Site doesn't exit
   }
}

//Function to create a new Site
function createSite($siteName,$region)
{
    $created=insertSite($siteName,$region);
    return $created;
}

// Function to insert a Site
function insertSite($siteName,$region)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO site(Nom,Region) VALUES("'.$siteName.'","'.$region.'")');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to update a Site
function updateSite($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE site SET '.$field.'="'.$value.'"WHERE ID="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a field in a site record has been updated
function checkSiteFieldUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from site where ID="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}

//Function to load a site
function getSiteDetails($idSite)
{
    $db = dbConnect();
    $req=$db->query('select * from site where site.ID="'.$idSite.'"');
    return $req; 
}



/***************************************************************************************************************************************/
/*---------------------------------------------------------- TYPES ACTIVITES --------------------------------------------------------- */
/***************************************************************************************************************************************/

// Get access to the list of Activities Types
function getActivityTypes()
{
    $db=dbConnect();
    $req=$db->query('select * from TypeActivite order by Nom_typeActivite');
    return $req;
}

//function to access TACE and Facturable attribute of an activity type
function getTACEFact($activityTypeID)
{
    $db=dbConnect();
    $req=$db->query('select Impact_TACE, Facturable from TypeActivite where ID="'.$activityTypeID.'"');
    return $req;  
}


// Get access to a Activity Type ID
function getActivityTypeID($activityName,$impactTACE,$facturable)
{
    $db=dbConnect();
    $req=$db->query('select ID from TypeActivite where Nom_typeActivite="'.$activityName.'" 
    and Impact_TACE="'.$impactTACE.'" and Facturable="'.$facturable.'"');
    return $req;  
}

// Function to check if a Tyep of Activity exists
function existActivityType($activityName)
{
    $db=dbConnect();
    $req=$db->query('select * from TypeActivite where Nom_typeActivite="'.$activityName.'"');
    //$rowcount=mysqli_num_rows($req);
   if ($req->fetchColumn()>0) {
       return true; // CLient already exists
   }
   else {
       return false; // Client doesn't exit
   }
}

//Function to create a new Activity Type
function createActivityType($activityName,$impactTACE,$facturable)
{
    $created=insertActivityType($activityName,$impactTACE,$facturable);
    return $created;
}

// Function to insert an Activity Type
function insertActivityType($activityName,$impactTACE,$facturable)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO TypeActivite(Nom_typeActivite,Impact_TACE,Facturable) VALUES("'.$activityName.'","'.$impactTACE.'","'.$facturable.'")');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

// Function to access new inserted Activity's ID
function newInsertedActivityID($activityName,$impactTACE,$facturable)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO TypeActivite(Nom_typeActivite,Impact_TACE,Facturable) VALUES("'.$activityName.'","'.$impactTACE.'","'.$facturable.'")');
    $req->execute();
    $lastID=$db->lastInsertId();
    return $lastID;
}

//Function to update a type of Activity
function updateActivityType($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE TypeActivite SET '.$field.'="'.$value.'"WHERE ID="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a field in a type of Activity record has been updated
function checkATFieldUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from TypeActivite where ID="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}

//Function to load a Type of Activity
function getATDetails($idAT)
{
    $db = dbConnect();
    $req=$db->query('select * from typeactivite where typeactivite.ID="'.$idAT.'"');
    return $req; 
}

/***************************************************************************************************************************************/
/*------------------------------------------------------- JOURS OUVRABLES ------------------------------------------------------------ */
/***************************************************************************************************************************************/

// Function to access all Working Days
function workingDays()
{
    $db=dbConnect();
    $req=$db->query('select * from joursouvrables');
    return $req;    
}


// Function to get working days of current year's months
function workingDaysCurrentYear()
{
    $db=dbConnect();
    $req=$db->query('select * from JoursOuvrables where Annee=YEAR(CURDATE())');
    return $req;
}


// Function to get working days of given year's months
function workingDaysGivenYear($year)
{
    $db=dbConnect();
    $req=$db->query('select * from JoursOuvrables where Annee="'.$year.'"'  );
    return $req;   
}

//Function to update a Working Day
function updateJO($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE JoursOuvrables SET '.$field.'="'.$value.'"WHERE ID="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a field in a PU record has been updated
function checkJOFieldUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from JoursOuvrables where ID="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}

//Function to load a Working day
function getJODetails($idJO)
{
    $db = dbConnect();
    $req=$db->query('select * from joursouvrables where joursouvrables.ID="'.$idJO.'"');
    return $req; 
}

/***************************************************************************************************************************************/
/*---------------------------------------------------------- COLLABORATEURS ---------------------------------------------------------- */
/***************************************************************************************************************************************/
// Get access to the list of Collabs
function getCollabs()
{
    $db=dbConnect();
    $req=$db->query('select * from Collaborateurs order by collaborateurs.Nom asc');
    return $req;
}

// Get access to a particular collab
function getACollab($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select * from Collaborateurs where ID="'.$idCollab.'"');
    return $req;   
}

// Function to get Collab ID
function getCollabID($ggid)
{
    $db=dbConnect();
    $req=$db->query('select ID from Collaborateurs where GGID="'.$ggid.'"');
    return $req;   
}


// Function to get a PU's Collab lists
function getPUCollabList($puID)
{
    $db=dbConnect();
    $req=$db->query('select collaborateurs.ID, concat(collaborateurs.Nom,\' \',collaborateurs.Prénom) as Nom_Prenom FROM collaborateurs where collaborateurs.ID_PU="'.$puID.'"');
    return $req;   
}


//Get access to a collab red card id
function collabRateCardId($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select ratecard.ID from collaborateurs inner JOIN ratecard on ratecard.ID=collaborateurs.ID_rateCard WHERE collaborateurs.ID="'.$idCollab.'"');
    return $req;  
}

// Function to access a collab's ratecard value
function getCollabRCValue($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select ratecard.RateCard from collaborateurs inner JOIN ratecard on ratecard.ID=collaborateurs.ID_rateCard WHERE collaborateurs.ID="'.$idCollab.'"');
    return $req;  
}

// Function to check if a Collab exists
function existCollab($ggid)
{
    $db=dbConnect();
    $req=$db->query('select * from Collaborateurs where GGID="'.$ggid.'"');
    //$rowcount=mysqli_num_rows($req);
   if ($req->fetchColumn()>0) {
       return true; // Collab already exists
   }
   else {
       return false; // Collab doesn't exit
   }
}

//Function to create a new Collab
function createCollab($idPU,$ggid,$nom,$prenom,$idSite,$dateEntree,$dateSortie,$idrateCard,$pourcentageActivity,$idSupport,$manager,$commentaire,$CM,$isManager,$isCM,$cvBook,$tjmCible)
{
    $created=insertCollab($idPU,$ggid,$nom,$prenom,$idSite,$dateEntree,$dateSortie,$idrateCard,$pourcentageActivity,$idSupport,$manager,$commentaire,$CM,$isManager,$isCM,$cvBook,$tjmCible);
    return $created;
}

// Function to insert a Collab
function insertCollab($idPU,$ggid,$nom,$prenom,$idSite,$dateEntree,$dateSortie,$idrateCard,$pourcentageActivity,$idSupport,$manager,$commentaire,$CM,$isManager,$isCM,$cvBook,$tjmCible)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO Collaborateurs(ID_PU,GGID,Nom,Prénom,ID_Site,Date_Entree,Date_Sortie,ID_rateCard,Pourcentage_Activity,ID_Support,ID_Manager,Commentaire,ID_CM,isManager,isCM,cvBook,TJMCible)
         VALUES("'.$idPU.'","'.$ggid.'","'.$nom.'","'.$prenom.'","'.$idSite.'","'.$dateEntree.'","'.$dateSortie.'","'.$idrateCard.'","'.$pourcentageActivity.'","'.$idSupport.'","'.$manager.'",
         "'.$commentaire.'","'.$CM.'","'.$isManager.'","'.$isCM.'","'.$cvBook.'","'.$tjmCible.'")');
    $req->execute();
    $lastID=$db->lastInsertId();
    return $lastID;
}

//Function to update a Collab
function updateCollab($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE Collaborateurs SET '.$field.'="'.$value.'"WHERE ID="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a field in a collab record has been updated
function checkCollabFieldUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from Collaborateurs where ID="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}

// Function to get a collab role title
function getACollabRole($idCollab)
{
    $db=dbConnect();
    $req=$db->query('SELECT ratecard.Role FROM collaborateurs INNER JOIN ratecard on collaborateurs.ID_rateCard=ratecard.ID where collaborateurs.ID="'.$idCollab.'"');
    return $req;
}


// Function to get to a collab Production Unit title
function getACollabPU($idCollab)
{
    $db=dbConnect();
    $req=$db->query('SELECT productionunit.Nom from collaborateurs inner join productionunit on collaborateurs.ID_PU=productionunit.ID where collaborateurs.ID="'.$idCollab.'"');
    return $req;
}


// Function to get to a collab rateCard
function getACollabRC($idCollab)
{
    $db=dbConnect();
    $req=$db->query('SELECT ratecard.RateCard FROM collaborateurs INNER JOIN ratecard on collaborateurs.ID_rateCard=ratecard.ID where collaborateurs.ID="'.$idCollab.'"');
    return $req;
}

// Function to get to a collab grade
function getACollabGrade($idCollab)
{
    $db=dbConnect();
    $req=$db->query('SELECT ratecard.Grade FROM collaborateurs INNER JOIN ratecard on collaborateurs.ID_rateCard=ratecard.ID where collaborateurs.ID="'.$idCollab.'"');
    return $req;
}

// function to get to the list of Sites
function getSitesList()
{
    $db=dbConnect();
    $req=$db->query('select distinct collaborateurs.Site from collaborateurs') ;
    return $req;
}





/***************************************************************************************************************************************/
/*------------------------------------------------------------------- SUPPORTS --------------------------------------------------------*/
/***************************************************************************************************************************************/
// Acces Liste des supports
function getSupports()
{
    $db = dbConnect();
    $req=$db->query('select * from support ORDER by nom ASC');
    return $req;
}


// Function to check if a Support exists
function existSupport($nom,$prenom)
{
    $db=dbConnect();
    $req=$db->query('select * from support where nom="'.$nom.'" and prenom="'.$prenom.'"');
    if ($req->fetchColumn()>0) {
        return true; // support already exists
    }
    else {
        return false; // support doesn't exit
    }
}

//Function to create a new Support
function createSupport($nom,$prenom)
{
    $created=insertSupport($nom,$prenom);
    return $created;
}

// Function to insert a new Support
function insertSupport($nom,$prenom)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO support(nom,prenom) VALUES("'.$nom.'","'.$prenom.'")');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to update a Support
function updateSupport($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE support SET '.$field.'="'.$value.'"WHERE ID="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a Support record's field has been updated
function checkSupportFieldUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from support where ID="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}

//Function to load a Support
function getSupportDetails($idSupport)
{
    $db = dbConnect();
    $req=$db->query('select * from support where ID="'.$idSupport.'"');
    return $req; 
}


/***************************************************************************************************************************************/
/*--------------------------------------------------------- MANAGERS ------------------------------------------------------------------*/
/***************************************************************************************************************************************/
// Acces Liste des managers
function getManagers()
{
    $db = dbConnect();
    $req=$db->query('select productionunit.Nom as nomPU, site.Nom as nomSite, collaborateurs.GGID,
    collaborateurs.Nom, collaborateurs.Prénom, collaborateurs.ID as idCollab 
    from collaborateurs 
    INNER join productionunit on collaborateurs.ID_PU=productionunit.ID 
    inner join site on site.ID=collaborateurs.ID_Site 
    where collaborateurs.isManager=1 
    ORDER BY collaborateurs.Nom ASC');
    return $req;
}

// Function to get available collabs to be managers in a PU
function getAvailableCollabToBeManagers($pu)
{
    $db = dbConnect();
    $req=$db->query('select collaborateurs.Nom, collaborateurs.Prénom, collaborateurs.ID as idCollab from collaborateurs INNER join productionunit on collaborateurs.ID_PU=productionunit.ID
    where productionunit.ID="'.$pu.'" and collaborateurs.isManager=0 ORDER BY collaborateurs.Nom ASC');
    return $req;  
}

// Function to get available managers for a collab 
function getAvailableManagers($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select collaborateurs.Nom, collaborateurs.Prénom, collaborateurs.ID as idCollab from collaborateurs  
    where collaborateurs.isManager=1 and collaborateurs.ID!="'.$idCollab.'" order by Nom');
    return $req;
}

// Function to get a manager Details
function getManagerDetails($idManager)
{
    $req=getACollab($idManager);
    return $req;
}


//Function to add a collab as new manager
function createManager($idCollab)
{
    $created=updateCollab('isManager',1,$idCollab);
    return $created;
}

// Function to delete a collab as Manager
function deleteManager($idCollab)
{
    $deleted=updateCollab('isManager',0,$idCollab);
    return $deleted;
}

//Function to get the liste of Collab managed by a Manager
function getManagerCollabList($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select collaborateurs.ID, collaborateurs.Nom, collaborateurs.Prénom from collaborateurs  
    where collaborateurs.ID_Manager="'.$idCollab.'" order by collaborateurs.Nom asc');
    return $req; 
}

//Function to get the list of the collabs of a manager who are still working in the company
function getManagerCollabListIN($idCollab)
{
    $db=dbConnect();
    $req=$db->query('SELECT
    collaborateurs.ID,
    collaborateurs.Nom,
    collaborateurs.Prénom
    FROM
    collaborateurs
    WHERE
    collaborateurs.ID_Manager = "'.$idCollab.'"
    AND (year(collaborateurs.Date_Sortie)>year(CURRENT_DATE) OR (year(collaborateurs.Date_Sortie)=year(CURRENT_DATE) and month(collaborateurs.Date_Sortie)>=month(CURRENT_DATE)))
    ORDER BY
    collaborateurs.Nom ASC');
    return $req; 
}

//Function to get the list of the collabs of a manager who are not working in the company
function getManagerCollabListOUT($idCollab)
{
    $db=dbConnect();
    $req=$db->query('SELECT
    collaborateurs.ID,
    collaborateurs.Nom,
    collaborateurs.Prénom
    FROM
    collaborateurs
    WHERE
    collaborateurs.ID_Manager = "'.$idCollab.'"
    AND YEAR(collaborateurs.Date_Sortie) = YEAR(CURRENT_DATE) AND MONTH(collaborateurs.Date_Sortie) < MONTH(CURRENT_DATE)
    ORDER BY
    collaborateurs.Nom ASC');
    return $req; 
}


/***************************************************************************************************************************************/
/*---------------------------------------------------- CARRIER MAMAGER --------------------------------------------------------------- */
/***************************************************************************************************************************************/
// Acces Liste des carrier managers
function getCarrierManagers()
{
    $db = dbConnect();
    $req=$db->query('select productionunit.Nom as nomPU, site.Nom as nomSite, collaborateurs.GGID,
    collaborateurs.Nom, collaborateurs.Prénom, collaborateurs.ID as idCollab 
    from collaborateurs 
    INNER join productionunit on collaborateurs.ID_PU=productionunit.ID 
    inner join site on site.ID=collaborateurs.ID_Site 
    where collaborateurs.isCM=1 
    ORDER BY collaborateurs.Nom ASC');
    return $req;
}

// Function to get available collabs to be CM in a PU
function getAvailableCollabToBeCM($pu)
{
    $db = dbConnect();
    $req=$db->query('select collaborateurs.Nom, collaborateurs.Prénom, collaborateurs.ID as idCollab from collaborateurs INNER join productionunit on collaborateurs.ID_PU=productionunit.ID
    where productionunit.ID="'.$pu.'" and collaborateurs.isCM=0 ORDER BY collaborateurs.Nom ASC');
    return $req;  
}

// Function to get available CM for a collab
function getAvailableCM($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select collaborateurs.Nom, collaborateurs.Prénom, collaborateurs.ID as idCollab from collaborateurs  
    where collaborateurs.isCM=1 and collaborateurs.ID!="'.$idCollab.'" order by Nom');
    return $req;
}

// Function to get a CM Details
function getCMDetails($idCollab)
{
    $req=getACollab($idCollab);
    return $req;
}


//Function to create a new CM
function createCM($idCollab)
{
    $created=updateCollab('isCM',1,$idCollab);
    return $created;
}


// Function to delete a CM
function deleteCM($idCollab)
{
    $deleted=updateCollab('isCM',0,$idCollab);
    return $deleted;   
}

//Function to get the list of collabs dependant of the CM
function getCMCollabList($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select collaborateurs.ID, collaborateurs.Nom, collaborateurs.Prénom from collaborateurs  
    where collaborateurs.ID_CM="'.$idCollab.'"');
    return $req; 
}


/***************************************************************************************************************************************/
/*-----------------------------------------------------------PROFIL------------------------------------------------------------------- */
/***************************************************************************************************************************************/
// Get access to a collab profil (ID, ID_Collab,détails)
function getprofil($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select * from profil where ID_Collab="'.$idCollab.'"');
    return $req;
}


// Function to check if a collab has already a profil (Only one profil per Collab!)
function existsProfil($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select * from profil where ID_Collab="'.$idCollab.'"');
    //$rowcount=mysqli_num_rows($req);
   if ($req->fetchColumn()>0) {
       return true; // CLient already exists
   }
   else {
       return false; // Client doesn't exit
   }
}

//Function to create a new Collab Profil
function createProfil($idCollab,$details,$idPT)
{
    $created=insertProfil($idCollab,$details,$idPT);
    return $created;
}

// Function to insert a collab profil
function insertProfil($idCollab,$details,$idPT)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO profil(ID_Collab,détails,ID_PT) VALUES("'.$idCollab.'","'.$details.'","'.$idPT.'")');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to update a Profil
function updateProfil($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE profil SET '.$field.'="'.$value.'"WHERE ID="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a field in a Collab profil record has been updated
function checkProfilFieldUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from profil where ID="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}

//Function to load a collab profil
function getProfilDetails($idProfil)
{
    $db = dbConnect();
    $req=$db->query('select * from profil where profil.ID="'.$idProfil.'"');
    return $req; 
}

// Function to consult a collab Profil
function consultCollabProfil($idProfil)
{
    $db = dbConnect();
    $req=$db->query('SELECT intituleprofil.intitule, profil.détails from profil LEFT JOIN intituleprofil ON intituleprofil.ID=profil.ID_PT WHERE profil.ID_Collab="'.$idProfil.'"');
    return $req; 
}

/***************************************************************************************************************************************/
/*------------------------------------------------------------EXPERIENCE---------------------------------------------------------------*/
/***************************************************************************************************************************************/

// Get access to a collab experiences
function getCollabExperiences($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select * from experience where ID_Collab="'.$idCollab.'"');
    return $req;
}


// Function to check if a collab's experience already exists
function existsCollabExperience($idCollab,$debut,$fin,$details)
{
    $db=dbConnect();
    $req=$db->query('select * from experience where ID_Collab="'.$idCollab.'" and Details="'.$details.'" and Date_Debut="'.$debut.'" and Date_Fin="'.$fin.'"');
    //$rowcount=mysqli_num_rows($req);
   if ($req->fetchColumn()>0) {
       return true; // CLient already exists
   }
   else {
       return false; // Client doesn't exit
   }
}

//Function to create a new Collab Experince
function createCollabExperience($idCollab,$dateDebut,$dateFin,$details)
{
    $created=insertCollabExperience($idCollab,$dateDebut,$dateFin,$details);
    return $created;
}

// Function to insert a collab experience
function insertCollabExperience($idCollab,$dateDebut,$dateFin,$details)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO experience(ID_Collab,Date_Debut,Date_Fin,Details) VALUES("'.$idCollab.'","'.$dateDebut.'","'.$dateFin.'","'.$details.'")');
    $req->execute();
    $lastID=$db->lastInsertId();
    return $lastID;
}

//Function to update a Collab Experience
function updateCollabExperience($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE experience SET '.$field.'="'.$value.'"WHERE ID="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a field in a Collab experience record has been updated
function checkCollabExperienceFieldUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from experience where ID="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}

//Function to load a collab cetification
function getExpDetails($idExp)
{
    $db = dbConnect();
    $req=$db->query('select * from experience where experience.ID="'.$idExp.'"');
    return $req; 
}

/***************************************************************************************************************************************/
/*---------------------------------------------------------COMPETENCE ---------------------------------------------------------------- */
/***************************************************************************************************************************************/
// Get access to a collab competences
function getCollabCompetences($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select * from competence where ID_Collab="'.$idCollab.'"');
    return $req;
}


// Function to check if a collab's competence already exists before update
function existsCollabCompetence($idComp,$titre)
{
    $db=dbConnect();
    $req=$db->query('select competence.Titre from competence where competence.ID_Collab=(SELECT competence.ID_Collab from competence where competence.ID="'.$idComp.'") AND competence.Titre="'.$titre.'"');
    //$rowcount=mysqli_num_rows($req);
    $req->execute();
    if ($req->rowCount()>0) {
        return true; // competence already exists
    }
    else {
        return false; // competence doesn't exit
    }
}

// Function to check if a collab's competence already exists before creation
function existsCollabCompBefCreation($idCollab,$titre)
{
    $db=dbConnect();
    $req=$db->query('select competence.Titre from competence where competence.ID_Collab="'.$idCollab.'" AND competence.Titre="'.$titre.'"');
    //$rowcount=mysqli_num_rows($req);
    $req->execute();
    if ($req->rowCount()>0) {
        return true; // competence already exists
    }
    else {
        return false; // competence doesn't exit
    }
}

//Function to create a new Collab Competence
/* function createCollabCompetence($idCollab,$titre,$niveau)
{
    $created=insertCollabCompetence($idCollab,$titre,$niveau);
    return $created;
} */

// Function to insert a collab competence
function insertCollabCompetence($idCollab,$titre,$niveau)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO competence(ID_Collab,Titre,Niveau) VALUES("'.$idCollab.'","'.$titre.'","'.$niveau.'")');
    $req->execute();
    $lastID=$db->lastInsertId();
    return $lastID;   
}

//Function to update a Collab Competence
function updateCollabCompetence($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE competence SET '.$field.'="'.$value.'"WHERE ID="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a field in a Collab competence record has been updated
function checkCollabCompetenceFieldUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from competence where ID="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}

//Function to load a collab competence
function getCompDetails($idComp)
{
    $db = dbConnect();
    $req=$db->query('select * from competence where competence.ID="'.$idComp.'"');
    return $req; 
}


/***************************************************************************************************************************************/
/*------------------------------------------------------CERTIFICATION -----------------------------------------------------------------*/
/***************************************************************************************************************************************/
// Get access to a collab certifications
function getCollabCertifications($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select * from certification where ID_Collab="'.$idCollab.'"');
    return $req;
}


// Function to check if a collab's certification already exists before update
function existsCollabCertification($idCertif,$titre)
{
    $db=dbConnect();
    $req=$db->query('select certification.Titre from certification where certification.ID_Collab=(SELECT certification.ID_Collab from certification where certification.ID="'.$idCertif.'") AND certification.Titre="'.$titre.'"');
    //$rowcount=mysqli_num_rows($req);
    $req->execute();
    if ($req->rowCount()>0) {
        return true; // competence already exists
    }
    else {
        return false; // competence doesn't exit
    }
}


// Function to check if a collab's certification already exists before creation
function existsCollabCertifBefCreation($idCollab,$titre)
{
    $db=dbConnect();
    $req=$db->query('select certification.Titre from certification where certification.ID_Collab="'.$idCollab.'" AND certification.Titre="'.$titre.'"');
    //$rowcount=mysqli_num_rows($req);
    $req->execute();
    if ($req->rowCount()>0) {
        return true; // competence already exists
    }
    else {
        return false; // competence doesn't exit
    }
}


//Function to create a new Collab certification
function createCollabCertif($idCollab,$titre)
{
    $created=insertCollabCertif($idCollab,$titre);
    return $created;
}

// Function to insert a collab certification
function insertCollabCertif($idCollab,$titre)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO certification(ID_Collab,Titre) VALUES("'.$idCollab.'","'.$titre.'")');
    $req->execute();
    $lastID=$db->lastInsertId();
    return $lastID; 
}

//Function to update a Collab certification
function updateCollabCertif($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE certification SET '.$field.'="'.$value.'"WHERE ID="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a field in a Collab certification record has been updated
function checkCollabCertifFieldUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from certification where ID="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}

//Function to load a collab cetification
function getCertifDetails($idCertif)
{
    $db = dbConnect();
    $req=$db->query('select Titre from certification where certification.ID="'.$idCertif.'"');
    return $req; 
}

/***************************************************************************************************************************************/
/*-------------------------------------------------- JOURS OUVRABLES COLLABORATEURS -------------------------------------------------- */
/***************************************************************************************************************************************/

function workingDaysCollabCurrentYear($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select * from joursouvrablescollab where Annee=YEAR(CURDATE()) and ID_Collab="'.$idCollab.'"');
    return $req;
}

//Function to access the working days of a collab for a given year
function workingDaysCollabGivenYear($year,$idCollab)
{
    $db=dbConnect();
    $req=$db->query('select * from JoursOuvrablesCollab where Annee="'.$year.'" and ID_Collab="'.$idCollab.'"');
   return $req;
}

//Function to access the working days of a collab for a given year and month
function workingDaysCollabGivenYearMonth($year,$month,$idCollab)
{
    $db=dbConnect();
    $req=$db->query('select * from JoursOuvrablesCollab where Annee="'.$year.'" and Mois="'.$month.'" and ID_Collab="'.$idCollab.'"');
   return $req;
}

//Function to access the working days of a collab for a given year and list of months
function workingDaysCollabGivenYearListMonth($year,$month,$firstMonth,$lastMonth,$idCollab)
{
    $db=dbConnect();
    $req=$db->query('select * from JoursOuvrablesCollab where Annee="'.$year.'" and ID_Collab="'.$idCollab.'" and Mois between "'.$firstMonth.'" and "'.$lastMonth.'"');
   return $req;
}

//Function to update a Collab Working Day
function updateJOCollab($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE joursouvrablescollab SET '.$field.'="'.$value.'"WHERE ID="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a field in a Collab working day record has been updated
function checkJOCollabFieldUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from joursouvrablescollab where ID="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}

//function to insert a new collab working day
function insertCollabWorkingDays($db,$idCollab,$annee,$mois,$nbJours)
{
    //$db=dbConnect();
    $req=$db->prepare('INSERT INTO joursouvrablescollab(ID_Collab,Annee,Mois,NbJours)
         VALUES("'.$idCollab.'","'.$annee.'","'.$mois.'","'.$nbJours.'")');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to load a Collab Working day
function getJOCollabDetails($idJOCollab)
{
    $db = dbConnect();
    $req=$db->query('select * from joursouvrablescollab where joursouvrablescollab.ID="'.$idJOCollab.'"');
    return $req; 
}


/***************************************************************************************************************************************/
/*----------------------------------------------- PLAN DE CHARGE COLLABORATEUR --------------------------------------------------------*/
/***************************************************************************************************************************************/

// Access liste Projets + taches rattachées d'un collab pour l'année en cours (obsolète !)
function listProjTasksCollabCurrentYear($idCollab)
{
    $db=dbConnect();
    $req=$db->query('SELECT distinct projet.Code, projet.Titre, tache.Nom_Tache, tache.ID as idTache from projet INNER join tache 
                    on tache.ID_Projet=projet.ID inner join affectationmensuelle on affectationmensuelle.ID_Tache=tache.ID where 
                    affectationmensuelle.Annee=YEAR(CURDATE()) and affectationmensuelle.ID_Collab="'.$idCollab.'"');
    return $req;
    $req->closeCursor();  
}

// Access liste Projets + taches rattachées d'un collab pour l'année sélectionnée (obsolète !)
function listProjTasksCollabfilteredYear($idCollab,$year)
{
    $db=dbConnect();
    $req=$db->query('SELECT distinct projet.Code, projet.Titre, tache.Nom_Tache, tache.ID as idTache from projet INNER join tache 
                    on tache.ID_Projet=projet.ID inner join affectationmensuelle on affectationmensuelle.ID_Tache=tache.ID where 
                    affectationmensuelle.Annee="'.$year.'" and affectationmensuelle.ID_Collab="'.$idCollab.'"');
    return $req; 
    $req->closeCursor(); 
}

// Accès liste des tâches de projets de types autres qu'interne d'un collab pour l'annee et mois  en cours et avec une somme de charges non nulle
function listNoneInternProjTasksCollabCurrentYear($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select distinct projet.Titre, projet.Code, tache.Nom_Tache, tache.ID as idTache, commentaireimputation.commentaire
    from tache INNER join projet on tache.ID_Projet=projet.ID 
    inner join affectationmensuelle on affectationmensuelle.ID_Tache=tache.ID
    LEFT join commentaireimputation on tache.ID=commentaireimputation.ID_Tache
    where affectationmensuelle.Annee=YEAR(CURDATE()) and affectationmensuelle.Mois=month(CURDATE())
    and projet.TypeProjet !="Activité Interne" and (affectationmensuelle.ID_Collab="'.$idCollab.'")  
    GROUP BY affectationmensuelle.ID_Tache 
    HAVING (SUM(affectationmensuelle.NbJoursPlan)>0 OR SUM(affectationmensuelle.NbJoursReal)>0)');
    return $req;
    $req->closeCursor();  
}

// Accès liste des tâches de projets de types autres qu'interne d'un collab pour l'année, les mois sélectionnés et avec une somme de charges non nulles
// Ajouter concat (annee finale , mois final ) + comparaison concat(mois, annee)
// where concat(affectationmensuelle.Annee,affectationmensuelle.Mois) as DATEAFFECTATION between concat($year,$initMonth) and concat ($lastYear,$lastMonth)

function listNoneInternProjTasksCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth,$lastYear)
{
    $db=dbConnect();
  /*  $req=$db->query('select distinct projet.Titre, projet.Code, tache.Nom_Tache, tache.ID as idTache, tjm.Valeur as TJM, commentaireimputation.commentaire
    from tache inner join projet on tache.ID_Projet=projet.ID inner join affectationmensuelle on affectationmensuelle.ID_Tache=tache.ID
    INNER join tjm on concat(tjm.ID_Tache,\'-\',tjm.ID_Collab) = concat(affectationmensuelle.ID_Tache,\'-\',affectationmensuelle.ID_Collab)
    inner join collaborateurs on collaborateurs.ID=affectationmensuelle.ID_Collab
    LEFT join commentaireimputation on concat(tache.ID,\'.\',collaborateurs.ID) = concat(commentaireimputation.ID_Tache,\'.\',commentaireimputation.ID_Collab)
    where affectationmensuelle.Annee between "'.$year.'" and "'.$lastYear.'"  and affectationmensuelle.Mois between "'.$initMonth .'" and "'.$lastMonth.'" 
    and projet.TypeProjet !="Activité Interne" and (affectationmensuelle.ID_Collab="'.$idCollab.'")
    GROUP BY affectationmensuelle.ID_Tache 
    HAVING (SUM(affectationmensuelle.NbJoursPlan)>0 OR SUM(affectationmensuelle.NbJoursReal)>0)');*/

    $req=$db->query('SELECT DISTINCT
    projet.Titre,
    projet.Code,
    tache.Nom_Tache,
    tache.ID AS idTache,
    tjm.Valeur AS TJM,
    commentaireimputation.commentaire
FROM tache INNER JOIN projet ON tache.ID_Projet = projet.ID
INNER JOIN affectationmensuelle ON affectationmensuelle.ID_Tache = tache.ID
INNER JOIN tjm ON CONCAT(tjm.ID_Tache,tjm.ID_Collab) = CONCAT( affectationmensuelle.ID_Tache, affectationmensuelle.ID_Collab)
INNER JOIN collaborateurs ON collaborateurs.ID = affectationmensuelle.ID_Collab
LEFT JOIN commentaireimputation ON CONCAT(tache.ID, collaborateurs.ID) = CONCAT(commentaireimputation.ID_Tache,commentaireimputation.ID_Collab)
WHERE
       CONCAT(affectationmensuelle.Annee,lpad(affectationmensuelle.Mois,2,\'0\')) BETWEEN CONCAT( "'.$year.'",lpad("'.$initMonth.'",2,\'0\'))  AND CONCAT("'.$lastYear.'",lpad("'.$lastMonth.'",2,\'0\')) 
        AND projet.TypeProjet != "Activité Interne" AND (affectationmensuelle.ID_Collab = "'.$idCollab.'")
GROUP BY
    affectationmensuelle.ID_Tache
HAVING
    (
        SUM(
            affectationmensuelle.NbJoursPlan
        ) > 0 OR SUM(
            affectationmensuelle.NbJoursReal
        ) > 0
    )');
    return $req;
    $req->closeCursor();  
}

// Accès liste des tâches de projets de type interne d'un collab pour l'annee et le mois en cours
function listInternProjTasksCollabCurrentYear($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select distinct projet.Titre, projet.Code, tache.Nom_Tache, tache.ID as idTache, commentaireimputation.commentaire 
    from tache INNER join projet on tache.ID_Projet=projet.ID 
    inner join affectationmensuelle on affectationmensuelle.ID_Tache=tache.ID
    LEFT join commentaireimputation on tache.ID=commentaireimputation.ID_Tache
    where affectationmensuelle.Annee=YEAR(CURDATE()) and affectationmensuelle.Mois=month(CURDATE())
    and projet.TypeProjet="Activité Interne" and (affectationmensuelle.ID_Collab="'.$idCollab.'")
    GROUP BY affectationmensuelle.ID_Tache 
    HAVING (SUM(affectationmensuelle.NbJoursPlan)>0 OR SUM(affectationmensuelle.NbJoursReal)>0)');
    return $req;
    $req->closeCursor();  
}

// Accès liste des tâches de projets de type interne d'un collab pour l'année et les mois sélectionnés
function listInternProjTasksCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth,$lastYear)
{
    $db=dbConnect();
    $req=$db->query('select distinct projet.Titre, projet.Code, tache.Nom_Tache, tache.ID as idTache, commentaireimputation.commentaire
    from tache inner join projet on tache.ID_Projet=projet.ID inner join affectationmensuelle on affectationmensuelle.ID_Tache=tache.ID
    inner join collaborateurs on collaborateurs.ID=affectationmensuelle.ID_Collab
    LEFT join commentaireimputation on concat(tache.ID,\'.\',collaborateurs.ID) = concat(commentaireimputation.ID_Tache,\'.\',commentaireimputation.ID_Collab)
    where CONCAT(affectationmensuelle.Annee,lpad(affectationmensuelle.Mois,2,\'0\')) BETWEEN CONCAT( "'.$year.'",lpad("'.$initMonth.'",2,\'0\'))  AND CONCAT("'.$lastYear.'",lpad("'.$lastMonth.'",2,\'0\')) 
    and projet.TypeProjet ="Activité Interne" and (affectationmensuelle.ID_Collab="'.$idCollab.'") AND projet.Titre NOT LIKE \'%Intercontrats%\'
    GROUP BY affectationmensuelle.ID_Tache 
    HAVING (SUM(affectationmensuelle.NbJoursPlan)>0 OR SUM(affectationmensuelle.NbJoursReal)>0)');
    return $req;
    $req->closeCursor();  
}

// Accès liste des projets de types autres qu'interne d'un collab pour l'année et le mois en cours et avec une somme de charges nulle
function listNoneInternProjNullChargeCollabCurrentYear($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select distinct projet.id as idProj, projet.Titre from tache INNER join projet on tache.ID_Projet=projet.ID 
    inner join affectationmensuelle on affectationmensuelle.ID_Tache=tache.ID where affectationmensuelle.Annee=YEAR(CURDATE()) and affectationmensuelle.Mois=month(CURDATE())
    and projet.TypeProjet !="Activité Interne" and affectationmensuelle.ID_Collab="'.$idCollab.'" GROUP BY affectationmensuelle.ID_Tache 
    HAVING (SUM(affectationmensuelle.NbJoursPlan)=0 AND SUM(affectationmensuelle.NbJoursReal)=0)');
    return $req;
    $req->closeCursor();  
}

// Accès liste des tâches de projets de types autres qu'interne d'un collab pour l'année et les mois sélectionnés et avec une somme de charges nulle
function listNoneInternProjNullChargeCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth,$lastYear)
{
    $db=dbConnect();
    $req=$db->query('select distinct projet.id as idProj, projet.Titre, projet.Code from tache INNER join projet on tache.ID_Projet=projet.ID 
    inner join affectationmensuelle on affectationmensuelle.ID_Tache=tache.ID where projet.TypeProjet !="Activité Interne" and
    CONCAT(affectationmensuelle.Annee,lpad(affectationmensuelle.Mois,2,\'0\')) BETWEEN CONCAT( "'.$year.'",lpad("'.$initMonth.'",2,\'0\'))  AND CONCAT("'.$lastYear.'",lpad("'.$lastMonth.'",2,\'0\')) 
    and  affectationmensuelle.ID_Collab="'.$idCollab.'" GROUP BY affectationmensuelle.ID_Tache 
    HAVING (SUM(affectationmensuelle.NbJoursPlan)=0 AND SUM(affectationmensuelle.NbJoursReal)=0)');
    return $req;
    $req->closeCursor();  
}

// Accès liste des tâches de projets de type interne d'un collab pour l'année et le mois en cours avec une somme de charge nulle
function listInternProjNullChargeCollabCurrentYear($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select distinct projet.id as idProj, concat(projet.Code,\'-\',projet.Titre) as Titre from tache inner join projet on tache.ID_Projet=projet.ID 
    inner join affectationmensuelle on affectationmensuelle.ID_Tache=tache.ID where affectationmensuelle.Annee=YEAR(CURDATE()) and affectationmensuelle.Mois=month(CURDATE())
    and projet.TypeProjet ="Activité Interne" and affectationmensuelle.ID_Collab="'.$idCollab.'" GROUP BY affectationmensuelle.ID_Tache 
    HAVING (SUM(affectationmensuelle.NbJoursPlan)=0 AND SUM(affectationmensuelle.NbJoursReal)=0)');
    return $req;
    $req->closeCursor();  
}

// Accès liste des tâches de projets de type interne d'un collab pour l'année et les mois sélectionnés
function listInternProjNullChargeCollabfilteredYear($idCollab,$year,$initMonth,$lastMonth,$lastYear)
{
    $db=dbConnect();
    $req=$db->query('select distinct projet.id as idProj, concat(projet.Code,\'-\',projet.Titre) as Titre from tache INNER join projet on tache.ID_Projet=projet.ID 
    inner join affectationmensuelle on affectationmensuelle.ID_Tache=tache.ID where  CONCAT(affectationmensuelle.Annee,lpad(affectationmensuelle.Mois,2,\'0\')) 
    BETWEEN CONCAT( "'.$year.'",lpad("'.$initMonth.'",2,\'0\'))  AND CONCAT("'.$lastYear.'",lpad("'.$lastMonth.'",2,\'0\'))
     and projet.TypeProjet ="Activité Interne" and 
    affectationmensuelle.ID_Collab="'.$idCollab.'" AND projet.Titre NOT LIKE \'%Intercontrats%\' GROUP BY affectationmensuelle.ID_Tache 
    HAVING (SUM(affectationmensuelle.NbJoursPlan)=0 AND SUM(affectationmensuelle.NbJoursReal)=0)');
    return $req;
    $req->closeCursor();  
}

// Accès aux durées réelles d'intercontrat
function getRealInterContract($idCollab,$year,$initMonth,$lastMonth,$lastYear)
{
    $db=dbConnect();
    $req=$db->query('SELECT affectationmensuelle.NbJoursReal, affectationmensuelle.Mois as mois, affectationmensuelle.Annee, affectationmensuelle.ID FROM affectationmensuelle INNER JOIN tache ON affectationmensuelle.ID_Tache = tache.ID INNER JOIN projet
     ON tache.ID_Projet = projet.ID WHERE projet.Titre LIKE \'%Intercontrats%\' AND affectationmensuelle.ID_Collab="'.$idCollab.'" AND CONCAT(affectationmensuelle.Annee,lpad(affectationmensuelle.Mois,2,\'0\')) 
    BETWEEN CONCAT( "'.$year.'",lpad("'.$initMonth.'",2,\'0\'))  AND CONCAT("'.$lastYear.'",lpad("'.$lastMonth.'",2,\'0\'))');
    return $req;
}


// Accès aux durées planifiées d'intercontrat
function getPlanInterContract($idCollab,$year,$initMonth,$lastMonth,$lastYear)
{
    $db=dbConnect();
    $req=$db->query('SELECT affectationmensuelle.NbJoursPlan, affectationmensuelle.Mois as mois, affectationmensuelle.Annee, affectationmensuelle.ID FROM affectationmensuelle INNER JOIN tache ON affectationmensuelle.ID_Tache = tache.ID INNER JOIN projet
     ON tache.ID_Projet = projet.ID WHERE projet.Titre LIKE \'%Intercontrats%\' AND affectationmensuelle.ID_Collab="'.$idCollab.'" AND CONCAT(affectationmensuelle.Annee,lpad(affectationmensuelle.Mois,2,\'0\')) 
    BETWEEN CONCAT( "'.$year.'",lpad("'.$initMonth.'",2,\'0\'))  AND CONCAT("'.$lastYear.'",lpad("'.$lastMonth.'",2,\'0\'))');
    return $req;
}

// Access  charges réelles et planifiées d'un collab pour l'année en cours et une tâche donnée (obsolète !)
function getPRChargesCollabCurrentYearDefMonth($idCollab,$idTask)
{
    $db=dbConnect();
    $req=$db->query('select affectationmensuelle.NbJoursPlan, affectationmensuelle.NbJoursReal, affectationmensuelle.Mois as mois, affectationmensuelle.ID 
    from affectationmensuelle where affectationmensuelle.ID_Tache="'.$idTask.'" and affectationmensuelle.ID_Collab="'.$idCollab.'" 
    and affectationmensuelle.Annee=YEAR(CURDATE())');
    return $req;
}

// Accès charges réelles et planifiées d'une tache d'un collab pour l'année sélectionée (obsolète !)
function getPRChargesCollabfilteredYearDefMonth($idCollab,$year,$idTask)
{
    $db=dbConnect();
    $req=$db->query('select affectationmensuelle.NbJoursPlan, affectationmensuelle.NbJoursReal, affectationmensuelle.Mois as mois, affectationmensuelle.ID 
    from affectationmensuelle where affectationmensuelle.ID_Tache="'.$idTask.'" and affectationmensuelle.ID_Collab="'.$idCollab.'" 
    and affectationmensuelle.Annee="'.$year.'"');
    return $req;
}

// Access  charges réelles et planifiées d'une tache d'un collab pour l'année et le mois en cours
function getPRChargesCollabCurrentYearMonth($idCollab,$idTask)
{
    $db=dbConnect();
    $req=$db->query('select affectationmensuelle.NbJoursPlan, affectationmensuelle.NbJoursReal, affectationmensuelle.Mois as mois, affectationmensuelle.ID 
    from affectationmensuelle where affectationmensuelle.ID_Tache="'.$idTask.'" and affectationmensuelle.ID_Collab="'.$idCollab.'" 
    and affectationmensuelle.Annee=YEAR(CURDATE()) and affectationmensuelle.Mois=MONTH(CURDATE())');
    return $req;
}

// Accès charges réelles et planifiées d'une tache d'un collab pour l'année et les mois sélectionnés
function getPRChargesCollabgivenYearMonth($idCollab,$year,$idTask,$firstMonth,$lastMonth,$lastYear)
{
    $db=dbConnect();
    $req=$db->query('select affectationmensuelle.NbJoursPlan,affectationmensuelle.Annee, affectationmensuelle.NbJoursReal, affectationmensuelle.Mois as mois, affectationmensuelle.ID 
    from affectationmensuelle where affectationmensuelle.ID_Tache="'.$idTask.'" and affectationmensuelle.ID_Collab="'.$idCollab.'" 
    and   CONCAT(affectationmensuelle.Annee,lpad(affectationmensuelle.Mois,2,\'0\')) BETWEEN CONCAT( "'.$year.'",lpad("'.$firstMonth.'",2,\'0\'))  AND CONCAT("'.$lastYear.'",lpad("'.$lastMonth.'",2,\'0\'))');

    return $req;
}

// Access à l'ensemble des charges réelles et planifiées d'un collab pour l'ens des taches sur une période donnée
function getPRChargesCollabAllTasksgivenYearMonth($idCollab,$year,$firstMonth,$lastMonth,$lastYear)
{
    $db=dbConnect();
    $req=$db->query('select affectationmensuelle.NbJoursPlan, affectationmensuelle.NbJoursReal, affectationmensuelle.Mois as mois, affectationmensuelle.ID,affectationmensuelle.Annee 
    from affectationmensuelle where affectationmensuelle.ID_Collab="'.$idCollab.'" and CONCAT(affectationmensuelle.Annee,lpad(affectationmensuelle.Mois,2,\'0\')) 
    BETWEEN CONCAT( "'.$year.'",lpad("'.$firstMonth.'",2,\'0\'))  AND CONCAT("'.$lastYear.'",lpad("'.$lastMonth.'",2,\'0\'))');
    return $req;
}

// Accès liste des tâches non imputées de projets de types autres qu'interne d'un collab pour l'annee et mois en cours
function listNoneInternProjTasksWithoutImpCollabCurrentYearMonth($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select distinct projet.Titre, tache.Nom_Tache, tache.ID as idTache from tache inner join projet on tache.ID_Projet=projet.ID 
    inner join on tjm.ID_Tache=tache.ID where tjm.ID_Collab="'.$idCollab.'" and 
    concat(month(curdate()),year(curdate())) between concat(tjm.Mois_Debut,tjm.Annee_Debut) and concat(tjm.Mois_Fin,tjm.Annee_Fin) 
    and projet.TypeProjet != "Activité Interne" and concat(tjm.ID_Collab,\'-\',tjm.ID_Tache,\'-\',tjm.Mois_Debut) not in 
    (select concat(affectationmensuelle.ID_Collab,\'-\',affectationmensuelle.ID_Tache,\'-\',affectationmensuelle.Mois) FROM affectationmensuelle) 
    and concat(tjm.ID_Collab,\'-\',tjm.ID_Tache,\'-\',tjm.Mois_Fin) not in 
    (select concat(affectationmensuelle.ID_Collab,\'-\',affectationmensuelle.ID_Tache,\'-\',affectationmensuelle.Mois) FROM affectationmensuelle)');
    return $req;  
}

// Accès liste des tâches non imputées de projets de types autres qu'interne d'un collab pour l'année et les mois sélectionnés 
function listNoneInternProjTasksWithoutImpCollabfilteredYearMonth($idCollab,$year,$initMonth,$lastMonth)
{
    $init=$initMonth.$year;
    $last=$lastMonth.$year;
    $db=dbConnect();
    $req=$db->query('select distinct projet.Titre, tache.Nom_Tache, tache.ID as idTache from tache inner join projet on tache.ID_Projet=projet.ID 
    INNER join tjm on tjm.ID_Tache=tache.ID where tjm.ID_Collab='.$idCollab.' and 
    (('.$init.' between concat(tjm.Mois_Debut,tjm.Annee_Debut) and concat(tjm.Mois_Fin,tjm.Annee_Fin))
    or ('.$last.' between concat(tjm.Mois_Debut,tjm.Annee_Debut) and concat(tjm.Mois_Fin,tjm.Annee_Fin))
    or(concat(tjm.Mois_Debut,tjm.Annee_Debut)>='.$init.' and concat(tjm.Mois_Fin,tjm.Annee_Fin)<='.$last.' )) and projet.TypeProjet !="Activité Interne" 
    AND concat(tjm.ID_Collab,\'-\',tjm.ID_Tache,\'-\',tjm.Mois_Debut) not in 
    (select concat(affectationmensuelle.ID_Collab,\'-\',affectationmensuelle.ID_Tache,\'-\',affectationmensuelle.Mois) FROM affectationmensuelle) 
    and concat(tjm.ID_Collab,\'-\',tjm.ID_Tache,\'-\',tjm.Mois_Fin) not in 
    (select concat(affectationmensuelle.ID_Collab,\'-\',affectationmensuelle.ID_Tache,\'-\',affectationmensuelle.Mois) FROM affectationmensuelle)');
    return $req;
    $req->closeCursor();  
}


// Accès liste des tâches non imputées de projets de type interne d'un collab pour l'annee et mois en cours
function listInternProjTasksWithoutImpCollabCurrentYearMonth($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select distinct projet.Titre, tache.Nom_Tache, tache.ID as idTache from tache inner join projet on tache.ID_Projet=projet.ID 
    inner join tjm on tjm.ID_Tache=tache.ID where tjm.ID_Collab="'.$idCollab.'" and 
    concat(month(curdate()),year(curdate())) between concat(tjm.Mois_Debut,tjm.Annee_Debut) and concat(tjm.Mois_Fin,tjm.Annee_Fin) 
    and projet.TypeProjet = "Activité Interne" and concat(tjm.ID_Collab,\'-\',tjm.ID_Tache,\'-\',tjm.Mois_Debut) not in 
    (select concat(affectationmensuelle.ID_Collab,\'-\',affectationmensuelle.ID_Tache,\'-\',affectationmensuelle.Mois) FROM affectationmensuelle) 
    and concat(tjm.ID_Collab,\'-\',tjm.ID_Tache,\'-\',tjm.Mois_Fin) not in 
    (select concat(affectationmensuelle.ID_Collab,\'-\',affectationmensuelle.ID_Tache,\'-\',affectationmensuelle.Mois) FROM affectationmensuelle)');
    return $req;
    $req->closeCursor();  
}

// Accès liste des tâches non imputées de projets de type interne d'un collab pour l'année et mois sélectionnés
function listInternProjTasksWithoutImpCollabfilteredYearMonth($idCollab,$year,$initMonth,$lastMonth)
{
    $init=$initMonth.$year;
    $last=$lastMonth.$year;
    $db=dbConnect();
    $req=$db->query('select distinct projet.Titre, tache.Nom_Tache, tache.ID as idTache from tache inner join projet on tache.ID_Projet=projet.ID 
    INNER join tjm on tjm.ID_Tache=tache.ID where tjm.ID_Collab='.$idCollab.' and 
    (('.$init.' between concat(tjm.Mois_Debut,tjm.Annee_Debut) and concat(tjm.Mois_Fin,tjm.Annee_Fin))
    or ('.$last.' between concat(tjm.Mois_Debut,tjm.Annee_Debut) and concat(tjm.Mois_Fin,tjm.Annee_Fin))
    or(concat(tjm.Mois_Debut,tjm.Annee_Debut)>='.$init.' and concat(tjm.Mois_Fin,tjm.Annee_Fin)<='.$last.' )) and projet.TypeProjet ="Activité Interne" 
    AND concat(tjm.ID_Collab,\'-\',tjm.ID_Tache,\'-\',tjm.Mois_Debut) not in 
    (select concat(affectationmensuelle.ID_Collab,\'-\',affectationmensuelle.ID_Tache,\'-\',affectationmensuelle.Mois) FROM affectationmensuelle) 
    and concat(tjm.ID_Collab,\'-\',tjm.ID_Tache,\'-\',tjm.Mois_Fin) not in 
    (select concat(affectationmensuelle.ID_Collab,\'-\',affectationmensuelle.ID_Tache,\'-\',affectationmensuelle.Mois) FROM affectationmensuelle)');
    return $req;
    $req->closeCursor();  
}


// Acces à la liste des mois et années de tjm d'une tâche d'un collab pour une période donnée
function listMonthYearTasksWithoutImpCollabfilteredYearMonth($idCollab,$idTask,$year,$initMonth,$lastMonth)
{
    $init=$initMonth.$year;
    $last=$lastMonth.$year;
    $db=dbConnect();
    $req=$db->query('select tjm.Mois_Debut,tjm.Annee_Debut,tjm.Mois_Fin,tjm.Annee_Fin from tjm 
    where tjm.ID_Collab='.$idCollab.' and tjm.ID_Tache='.$idTask.' and
    (('.$init.' between concat(tjm.Mois_Debut,tjm.Annee_Debut) and concat(tjm.Mois_Fin,tjm.Annee_Fin))
    or ('.$last.' between concat(tjm.Mois_Debut,tjm.Annee_Debut) and concat(tjm.Mois_Fin,tjm.Annee_Fin))
    or(concat(tjm.Mois_Debut,tjm.Annee_Debut)>='.$init.' and concat(tjm.Mois_Fin,tjm.Annee_Fin)<='.$last.' ))
    AND concat(tjm.ID_Collab,\'-\',tjm.ID_Tache,\'-\',tjm.Mois_Debut) not in 
    (select concat(affectationmensuelle.ID_Collab,\'-\',affectationmensuelle.ID_Tache,\'-\',affectationmensuelle.Mois) FROM affectationmensuelle) 
    and concat(tjm.ID_Collab,\'-\',tjm.ID_Tache,\'-\',tjm.Mois_Fin) not in 
    (select concat(affectationmensuelle.ID_Collab,\'-\',affectationmensuelle.ID_Tache,\'-\',affectationmensuelle.Mois) FROM affectationmensuelle)');
    return $req;
    $req->closeCursor();  
}


/***************************************************************************************************************************************/
/*------------------------------------------------- AFFECTATIONS MENSUELLES ---------------------------------------------------------- */
/***************************************************************************************************************************************/
//function to insert a new monthly affectation
function insertMonthlyAffectation($db,$Annee,$Mois,$idCollab,$idTache,$nbJoursReal,$nbJoursPlan)
{
    //$db=dbConnect();
    $req=$db->prepare('INSERT INTO affectationmensuelle(Annee,Mois,ID_Collab,ID_Tache,NbJoursReal,NbJoursPlan)
         VALUES("'.$Annee.'","'.$Mois.'","'.$idCollab.'","'.$idTache.'","'.$nbJoursReal.'","'.$nbJoursPlan.'")');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

function insertImputation($Annee,$Mois,$idCollab,$idTache,$nbJoursReal,$nbJoursPlan)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO affectationmensuelle(Annee,Mois,ID_Collab,ID_Tache,NbJoursReal,NbJoursPlan)
         VALUES("'.$Annee.'","'.$Mois.'","'.$idCollab.'","'.$idTache.'","'.$nbJoursReal.'","'.$nbJoursPlan.'")');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

// Acces Mois de début d'affectation année en cours (obsolète !)
function firstMonthAffectationCurrentYear($idCollab,$idTask)
{
    $db=dbConnect();
    $req=$db->query('select MIN(affectationmensuelle.Mois) as minMois from affectationmensuelle where affectationmensuelle.ID_Collab="'.$idCollab.'" 
    and affectationmensuelle.ID_Tache="'.$idTask.'" and affectationmensuelle.Annee=YEAR(CURDATE())');
    return $req;
    $req->closeCursor();
}

// Acces Mois de début d'affectation année sélectionnée (obsolète !)
function firstMonthAffectationFilteredYear($idCollab,$idTask,$year)
{
    $db=dbConnect();
    $req=$db->query('select MIN(affectationmensuelle.Mois) as minMois from affectationmensuelle where affectationmensuelle.ID_Collab="'.$idCollab.'" 
    and affectationmensuelle.ID_Tache="'.$idTask.'" and affectationmensuelle.Annee="'.$year.'"');
    return $req;
    $req->closeCursor();
}

// Acces Mois de Fin d'affectation année en cours (obsolète !)
function lastMonthAffectationCurrentYear($idCollab,$idTask)
{
    $db=dbConnect();
    $req=$db->query('select MAX(affectationmensuelle.Mois) as maxMois from affectationmensuelle where affectationmensuelle.ID_Collab="'.$idCollab.'" 
    and affectationmensuelle.ID_Tache="'.$idTask.'" and affectationmensuelle.Annee=YEAR(CURDATE())');
    return $req;
    $req->closeCursor();
}

// Acces Mois de début d'affectation année sélectionnée (obsolète !)
function lastMonthAffectationFilteredYear($idCollab,$idTask,$year)
{
    $db=dbConnect();
    $req=$db->query('select MAX(affectationmensuelle.Mois) as maxMois from affectationmensuelle where affectationmensuelle.ID_Collab="'.$idCollab.'" 
    and affectationmensuelle.ID_Tache="'.$idTask.'" and affectationmensuelle.Annee="'.$year.'"');
    return $req;
    $req->closeCursor();
}

//Function to update an Affectation
function updateAffectation($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE affectationmensuelle SET '.$field.'="'.$value.'"WHERE ID="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
    $req->closeCursor();
}

//Function to check if a field in a Affectation record has been updated
function checkAffectationFieldUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from affectationmensuelle where ID="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }
    $req->closeCursor();
}

//Function to calculate the sum of planned and real charges for a month in current year
function sumMonthChargesCurrentYear($month,$idCollab,$year)
{
    $db=dbConnect();
    $req=$db->query('select SUM(affectationmensuelle.NbJoursPlan) as sommePlan, SUM(affectationmensuelle.NbJoursReal) as sommeReal  from affectationmensuelle
    INNER JOIN tache ON affectationmensuelle.ID_Tache = tache.ID INNER JOIN projet ON projet.ID = tache.ID_Projet 
    where affectationmensuelle.ID_Collab="'.$idCollab.'" and affectationmensuelle.Annee="'.$year.'" AND affectationmensuelle.Mois="'.$month.'"
    AND projet.Titre NOT LIKE \'%Intercontrats%\'');
    return $req;
    $req->closeCursor();
}

//Function to calculate the sum of planned and real charges for a month in filtered year
function sumMonthChargesFilteredYear($month,$idCollab,$year)
{
    $db=dbConnect();
    $req=$db->query('select SUM(affectationmensuelle.NbJoursPlan) as sommePlan, SUM(affectationmensuelle.NbJoursReal) as sommeReal  from affectationmensuelle
    INNER JOIN tache ON affectationmensuelle.ID_Tache = tache.ID INNER JOIN projet ON projet.ID = tache.ID_Projet 
    where affectationmensuelle.ID_Collab="'.$idCollab.'" and affectationmensuelle.Annee="'.$year.'" AND affectationmensuelle.Mois="'.$month.'"
    AND projet.Titre NOT LIKE \'%Intercontrats%\'');
    return $req;
    $req->closeCursor();
}

// Function to delete an imputation
function deleteImputation($year,$month,$idCollab,$idTask)
{
    $db=dbConnect();
    $req=$db->prepare('delete from affectationmensuelle where affectationmensuelle.Annee="'.$year.'" and affectationmensuelle.Mois="'.$month.'" 
    and affectationmensuelle.ID_Tache="'.$idTask.'" and affectationmensuelle.ID_Collab="'.$idCollab.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
    $req->closeCursor();   
}

// Function to delete a list of imputations
function deleteListImputations($begin,$end,$idCollab,$idTask)
{
    $db=dbConnect();
    $req=$db->prepare('delete from affectationmensuelle where affectationmensuelle.ID_Tache="'.$idTask.'" and affectationmensuelle.ID_Collab="'.$idCollab.'"
    and concat(affectationmensuelle.Annee,lpad(affectationmensuelle.Mois,2,0)) between '.$begin.' and '.$end.'');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
    $req->closeCursor();   
}


/***************************************************************************************************************************************/
/*-------------------------------------------------------- TACHES ---------------------------------------------------------------------*/
/***************************************************************************************************************************************/
//get access to tasks with initialized activities types
function initializedTasks()
{
    $db=dbConnect();
    $req=$db->query('SELECT tache.ID from tache left join projet on tache.ID_Projet=projet.ID where projet.codeGenerique=1') ;
    //$req=$db->query('SELECT tache.ID from tache where tache.ID_TypeActivite=2');
    return $req;
    $req->closeCursor();
}

//get access to the list of tasks of a PU's intern projects
function getPUINternProjectsTasks($idPU)
{
    $db=dbConnect();
    $req=$db->query('SELECT tache.ID from tache inner join projet on tache.ID_Projet=projet.ID inner join productionunit on productionunit.ID=projet.ID_PU
     where projet.codeGenerique=1 and (productionunit.MU=1 or projet.ID_PU="'.$idPU.'")');
    //$req=$db->query('SELECT tache.ID from tache where tache.ID_TypeActivite=2');
    return $req;
    $req->closeCursor();
}

// Function to check if a Task exists
function existTask($idProj,$taskName)
{
    $db=dbConnect();
    $req=$db->query('select * from tache where ID_Projet="'.$idProj.'" and Nom_Tache="'.$taskName.'"');
    //$rowcount=mysqli_num_rows($req);
   if ($req->fetchColumn()>0) {
       return true; // Collab already exists
   }
   else {
       return false; // Collab doesn't exit
   }
}


// create a new taskList
function newTask($idProjet,$nomTache,$idTypeActivite)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO tache(ID_Projet,Nom_Tache,ID_TypeActivite) VALUES("'.$idProjet.'","'.$nomTache.'","'.$idTypeActivite.'")');
    $req->execute();
    $lastID=$db->lastInsertId();
    return $lastID;
}

//Function to update a Task
function updateTask($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE tache SET '.$field.'="'.$value.'"WHERE ID="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
    $req->closeCursor();
}

//Function to check if a field in a Task record has been updated
function checkTaskFieldUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from tache where ID="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }
    $req->closeCursor();
}

// Function to get a taskList's activity details
function taskActivity($idTask)
{
    $db=dbConnect();
    $req=$db->query('select typeactivite.ID as idTypeAct, typeactivite.Nom_typeActivite, typeactivite.Impact_TACE, typeactivite.Facturable 
    FROM tache INNER join typeactivite on tache.ID_TypeActivite=typeactivite.ID WHERE tache.ID="'.$idTask.'"');
    return $req;  
}

// Function to get to a task details
function getTaskDetails($idTask) 
{
    $db=dbConnect();
    $req=$db->query('select tache.Nom_Tache, typeactivite.ID as typeActivityID, typeactivite.Impact_TACE, typeactivite.Facturable from tache 
    inner join typeactivite on tache.ID_TypeActivite=typeactivite.ID WHERE tache.ID="'.$idTask.'"');
    return $req;
}


// Function to check if a task is billable
function getTaskBillStatus($idTask) 
{
    $db=dbConnect();
    $req=$db->query('SELECT typeactivite.Facturable from typeactivite INNER JOIN tache on tache.ID_TypeActivite=typeactivite.ID WHERE tache.ID="'.$idTask.'"');
    return $req;
}

/***************************************************************************************************************************************/
/*--------------------------------------------------COMMENTAIRES IMPUTATIONS COLLABORATEURS--------------------------------------------*/
/***************************************************************************************************************************************/
// Get access to a collab imputation comment
function getCollabTaskImputComment($idCollab,$idTask)
{
    $db=dbConnect();
    $req=$db->query('select commentaire from commentaireimputation where ID_Collab="'.$idCollab.'" and ID_Tache="'.$idTask.'"');
    return $req;
}


// Function to check if a comment already exists
function existsCollabImputComment($idCollab,$idTask)
{
    $db=dbConnect();
    $req=$db->query('select * from commentaireimputation where ID_Collab="'.$idCollab.'" and ID_Tache="'.$idTask.'"');
    //$rowcount=mysqli_num_rows($req);
   if ($req->fetchColumn()>0) {
       return true; // Comment already exists
   }
   else {
       return false; // Comment doesn't exit
   }
}

//Function to create a new Collab's Imputation comment
function createCollabImputComment($comment,$idCollab,$idTask)
{    
    $created=insertCollabImputComment($comment,$idCollab,$idTask);
    return $created;
}

// Function to insert a collab Task Imputation comment
function insertCollabImputComment($comment,$idCollab,$idTask)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO commentaireimputation(commentaire,ID_Collab,ID_Tache) VALUES("'.$comment.'","'.$idCollab.'","'.$idTask.'")');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to update a Collab Task Imputation Comment
function updateCollabImputComment($comment,$idTask,$idCollab)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE commentaireimputation SET commentaire="'.$comment.'"WHERE ID_Tache="'.$idTask.'" and ID_Collab="'.$idCollab.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a field in a Collab certification record has been updated
function checkCollabImputCommentFieldUpdated($comment,$idTask,$idCollab)
{
    $db=dbConnect();
    $req=$db->query('select * from commentaireimputation where commentaire="'.$comment.'" and ID_Tache="'.$idTask.'" and ID_Collab="'.$idCollab.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}

/***************************************************************************************************************************************/
/*----------------------------------------------------- PROJETS -----------------------------------------------------------------------*/
/***************************************************************************************************************************************/

// Get access to the list of Projects
function getProjects()
{
    $db=dbConnect();
    $req=$db->query('select * from projet');
    return $req;
}

// Get access to a project
function getProject($idProject)
{
    $db=dbConnect();
    $req=$db->query('select * from projet where ID="'.$idProject.'"');
    return $req;   
}

// Get access to a project by its Code
function getProjectByCode($projectCode)
{
    $db=dbConnect();
    $req=$db->query('select * from projet where Code="'.$projectCode.'"');
    return $req;   
}

// project's code autocomplete search
function projectAutoSearch($fuzzyVal)
{
    $db=dbConnect();
    $req=$db->query('SELECT * FROM projet WHERE Code LIKE \'%'.$fuzzyVal.'%\'');
    return $req;   
}


// get access to the list of a client's project
function projectList($idClient)
{
    $db=dbConnect();
    $req=$db->query('select projet.Titre, projet.ID from projet where projet.ID_Client="'.$idClient.'"');
    return $req;   
}

// Get access to project ID by client 
function getProjectID($projectName, $idClient)
{
    $db=dbConnect();
    $req=$db->query('select ID from projet where Titre="'.$projectName.'" and ID_Client="'.$idClient.'"');
    return $req;
}

// Get access to project ID by code 
function getProjectIDbyCode($codeProj)
{
    $db=dbConnect();
    $req=$db->query('select ID from projet where Code="'.$codeProj.'"');
    return $req;
}

// Function to check if a project exists
function existProject($codeProjet)
{
    $db=dbConnect();
    $req=$db->query('select * from projet where Code="'.$codeProjet.'"');
    //$rowcount=mysqli_num_rows($req);
   if ($req->fetchColumn()>0) {
       return true; // CLient already exists
   }
   else {
       return false; // Client doesn't exit
   }
}

//Function to create a new project 
function createProject($idPU,$code,$titre,$commercial,$RFA,$idClient,$typeProjet,$volJourVendu,$budget,$codeGenerique)
{
    $created=insertClient($idPU,$code,$titre,$commercial,$RFA,$idClient,$typeProjet,$volJourVendu,$budget,$codeGenerique);
    return $created;
}

// Function to insert a project
function insertProject($idPU,$code,$titre,$commercial,$RFA,$idClient,$typeProjet,$volJourVendu,$budget,$codeGenerique)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO Client(ID_PU,Code,Titre,Commercial,RFA,ID_Client,TypeProjet,VolJourVendu,budget,codeGenerique) 
    VALUES("'.$idPU.'","'.$code.'","'.$titre.'","'.$commercial.'","'.$RFA.'","'.$idClient.'","'.$typeProjet.'","'.$volJourVendu.'","'.$budget.'","'.$codeGenerique.'")');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

// Function to access new inserted project's ID
function newInsertedProjID($idPU,$code,$titre,$commercial,$RFA,$idClient,$typeProjet,$volJourVendu,$budget,$codeGenerique)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO projet(ID_PU,Code,Titre,Commercial,RFA,ID_Client,TypeProjet,VolJourVendu,budget,codeGenerique) 
    VALUES("'.$idPU.'","'.$code.'","'.$titre.'","'.$commercial.'","'.$RFA.'","'.$idClient.'","'.$typeProjet.'","'.$volJourVendu.'","'.$budget.'","'.$codeGenerique.'")');
    $req->execute();
    $lastID=$db->lastInsertId();
    return $lastID;
}

//Function to update a project
function updateProject($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE projet SET '.$field.'="'.$value.'"WHERE ID="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a field has been updated
function checkFieldProjectUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from projet where ID="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}

// get list of tasks of a project affected to a collab during a period
function projectTaskListFiltered($idProj,$idCollab,$initYear,$initMonth,$lastMonth,$lastYear)
{
    $db=dbConnect();
    $req=$db->query('select distinct tache.Nom_Tache, tache.ID as taskID from tache inner join projet on projet.ID=tache.ID_Projet inner join affectationmensuelle
     on affectationmensuelle.ID_Tache=tache.ID where projet.ID="'.$idProj.'" and affectationmensuelle.ID_Collab="'.$idCollab.'"and 
     CONCAT(affectationmensuelle.Annee,lpad(affectationmensuelle.Mois,2,\'0\')) 
     BETWEEN CONCAT( "'.$initYear.'",lpad("'.$initMonth.'",\'2\',\'0\'))  AND CONCAT("'.$lastYear.'",lpad("'.$lastMonth.'",\'2\',\'0\'))
     GROUP BY affectationmensuelle.ID_Tache HAVING (SUM(affectationmensuelle.NbJoursPlan)=0 AND SUM(affectationmensuelle.NbJoursReal)=0)');
    return $req;   
} 

// get list of tasks of a None intern project affected to a collab during a period
function noneInternprojectTaskListFiltered($idProj,$idCollab,$year,$initMonth,$lastMonth,$lastYear)
{
    $db=dbConnect();
    $req=$db->query('select distinct tache.Nom_Tache, tache.ID as taskID, tjm.Valeur as TJM from tache inner join projet on projet.ID=tache.ID_Projet inner join affectationmensuelle
     on affectationmensuelle.ID_Tache=tache.ID INNER join tjm on concat(tjm.ID_Tache,\'-\',tjm.ID_Collab) = concat(affectationmensuelle.ID_Tache,\'-\',affectationmensuelle.ID_Collab) 
      where projet.ID="'.$idProj.'" and tjm.ID_Collab="'.$idCollab.'" and CONCAT(affectationmensuelle.Annee,lpad(affectationmensuelle.Mois,2,\'0\')) 
     BETWEEN CONCAT( "'.$year.'",lpad("'.$initMonth.'",\'2\',\'0\'))  AND CONCAT("'.$lastYear.'",lpad("'.$lastMonth.'",\'2\',\'0\'))  
     GROUP BY affectationmensuelle.ID_Tache HAVING (SUM(affectationmensuelle.NbJoursPlan)=0 AND SUM(affectationmensuelle.NbJoursReal)=0)');
    return $req;   
}

// Function to list all Tasks of a project
function projectTaskList($idProj) 
{
    $db=dbConnect();
    $req=$db->query('select tache.Nom_Tache, tache.ID as taskID, typeactivite.ID as typeActivityID, typeactivite.Nom_typeActivite, 
    typeactivite.Impact_TACE, typeactivite.Facturable from tache inner join typeactivite on tache.ID_TypeActivite=typeactivite.ID 
    inner join projet on tache.ID_Projet=projet.ID WHERE tache.ID_Projet="'.$idProj.'"');
    return $req;
}


// Function to access tasks list by project Code
function getProjectTasks($codeProj)
{
    $db=dbConnect();
    $req=$db->query('select tache.Nom_Tache, tache.ID as taskID from tache 
    inner join projet on tache.ID_Projet=projet.ID WHERE projet.Code="'.$codeProj.'"');
    return $req;  
}

// Function to list the project's tasks affectations --> Rajouter champs SOW-ID
function projTasksAffList($idProj)
{
    $db=dbConnect();
    $req=$db->query('SELECT collaborateurs.Nom, collaborateurs.Prénom, collaborateurs.ID as idCollab, ratecard.RateCard, ratecard.ID as idRateCard, 
    tache.Nom_Tache,tache.ID as idTask, typeactivite.Nom_typeActivite,typeactivite.Impact_TACE,typeactivite.Facturable, 
    typeactivite.ID as idTypeActvite, tjm.ID as idTJM, tjm.Valeur, tjm.BudgetInit, tjm.BudgetComp,tjm.VolJourInit,tjm.VolJourComp,tjm.FraisInit,tjm.FraisComp,
    tjm.AutresCouts,tjm.Annee_Debut,tjm.Mois_Debut,tjm.Annee_Fin,tjm.Mois_Fin,tjm.ISOW,tjm.SOW_ID,tjm.ODM,tjm.FOP,tjm.coverage from tache INNER join projet on tache.ID_Projet=projet.ID 
    INNER join typeactivite on tache.ID_TypeActivite=typeactivite.ID inner JOIN tjm on tjm.ID_Tache=tache.ID 
    INNER join collaborateurs on tjm.ID_Collab=collaborateurs.id inner join ratecard on collaborateurs.ID_rateCard=ratecard.ID where projet.ID="'.$idProj.'"');
    return $req; 
}

// Function to get the MU value of a projet's PU
function getProjPUMUValue($idProj)
{
    $db=dbConnect();
    $req=$db->query('select productionunit.MU from projet INNER JOIN productionunit on productionunit.ID=projet.ID_PU where projet.ID="'.$idProj.'"');
    return $req;
}


// Function to get a Project's PU Collab lists
function getProjPUCollabList($idProj)
{
    $db=dbConnect();
    $req=$db->query('select collaborateurs.ID FROM projet inner join productionunit on productionunit.ID=projet.ID_PU
     inner join collaborateurs on collaborateurs.ID_PU=productionunit.ID  where projet.ID="'.$idProj.'"');
    return $req;   
}

/***************************************************************************************************************************************/
/*------------------------------------------------------------- TJM -------------------------------------------------------------------*/
/***************************************************************************************************************************************/
// Get access to the list of TJM
function getTJM()
{
    $db=dbConnect();
    $req=$db->query('select * from tjm');
    return $req;
}


//Function to create a new TJM
function createTJM($idCollab,$idTask,$anneeDebut,$moisDebut,$anneeFin,$moisFin,$valeur,$vjInit,$vjComp,$fraisInit,$fraisComp,$autresCouts,$budgetInit,$budgetComp,$isow,$sowID,$odm,$fop,$coverage)
{
    $created=insertTJM($idCollab,$idTask,$anneeDebut,$moisDebut,$anneeFin,$moisFin,$valeur,$vjInit,$vjComp,$fraisInit,$fraisComp,$autresCouts,$budgetInit,$budgetComp,$isow,$sowID,$odm,$fop,$coverage);
    return $created;
}

// Function to insert a TJM
function insertTJM($idCollab,$idTask,$anneeDebut,$moisDebut,$anneeFin,$moisFin,$valeur,$vjInit,$vjComp,$fraisInit,$fraisComp,$autresCouts,$budgetInit,$budgetComp,$isow,$sowID,$odm,$fop,$coverage)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO tjm(ID_Collab,ID_Tache,Annee_Debut,Mois_Debut,Annee_Fin,Mois_Fin,Valeur,VolJourInit,VolJourComp,FraisInit,FraisComp,AutresCouts,BudgetInit,BudgetComp,
    ISOW,SOW_ID,ODM,FOP,coverage)
    VALUES("'.$idCollab.'","'.$idTask.'","'.$anneeDebut.'","'.$moisDebut.'","'.$anneeFin.'","'.$moisFin.'","'.$valeur.'","'.$vjInit.'","'.$vjComp.'","'.$fraisInit.'",
    "'.$fraisComp.'","'.$autresCouts.'","'.$budgetInit.'","'.$budgetComp.'","'.$isow.'","'.$sowID.'","'.$odm.'","'.$fop.'","'.$coverage.'")');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to update a TJM
function updateTJM($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE tjm SET '.$field.'="'.$value.'"WHERE ID="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to check if a field in a TJM record has been updated
function checkTJMFieldUpdated($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->query('select * from tjm where ID="'.$id.'" and '.$field.'="'.$value.'"');
    if ($req->fetchColumn()>0) {
        return false;
    }
    else {
        return true;
    }

}



// get list of affectations periods for a collab's task
function getTaskAffectationPeriods($idCollab,$idTask)
{
    $db=dbConnect();
    $req=$db->query('select tjm.Mois_Debut,tjm.Mois_Fin, tjm.Annee_Fin, tjm.Annee_Debut  from tjm 
    where tjm.ID_Collab="'.$idCollab.'" and tjm.ID_Tache="'.$idTask.'"');
    return $req;
    $req->closeCursor();  
}


// Get other affectation periods of a collab's task when updating one of them
function getOtherAffPeriods($idCollab,$idTask,$idTJM)
{
    $db=dbConnect();
    $req=$db->query('select tjm.Mois_Debut,tjm.Mois_Fin, tjm.Annee_Fin, tjm.Annee_Debut  from tjm 
    where tjm.ID_Collab="'.$idCollab.'" and tjm.ID_Tache="'.$idTask.'" and tjm.ID !="'.$idTJM.'"');
    return $req;
    $req->closeCursor();  
}

//function to get  an Affectation's Initial and End Month
function getAffectationMonths($idTJM)
{
    $db=dbConnect();
    $req=$db->query('select tjm.Mois_Debut,tjm.Mois_Fin from tjm where tjm.ID ="'.$idTJM.'"');
    return $req;
    $req->closeCursor(); 
}

//function to get  an Affectation's Initial and End year,Month
function getAffectationYearsMonths($idTJM)
{
    $db=dbConnect();
    $req=$db->query('select tjm.Annee_Debut,tjm.Mois_Debut,tjm.Annee_Fin,tjm.Mois_Fin from tjm where tjm.ID ="'.$idTJM.'"');
    return $req;
    $req->closeCursor(); 
}



//function to access a particular TJM
function getTJMbyID($idTJM)
{
    $db=dbConnect();
    $req=$db->query('select * from tjm where tjm.ID ="'.$idTJM.'"');
    return $req;   
}


/********************************************************************************************************************/
/*---------------------------------------------- ENTREE - SORTIE ---------------------------------------------------*/
/********************************************************************************************************************/
// Get access to a in-out entry
function getInOut($idCollab)
{
    $db=dbConnect();
    $req=$db->query('select * from entreesortie where ID_Collab="'.$idCollab.'"');
    return $req;
}

//Function to create a new In-Out Collab's Entry
function createInOut($idCollab,$dateIn,$dateOut,$idMoisIn,$idMoisOut)
{
    $created=insertInOut($idCollab,$dateIn,$dateOut,$idMoisIn,$idMoisOut);
    return $created;
}

// Function to insert a new In-Out Collab's Entry
function insertInOut($idCollab,$dateIn,$dateOut,$idMoisIn,$idMoisOut)
{
    $db=dbConnect();
    $req=$db->prepare('INSERT INTO entreesortie(ID_Collab,date_in,date_out,id_mois_in,id_mois_out)
    VALUES("'.$idCollab.'","'.$dateIn.'","'.$dateOut.'","'.$idMoisIn.'","'.$idMoisOut.'")');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}

//Function to update an In-Out Entry
function updateInOut($field,$value,$id)
{
    $db=dbConnect();
    $req=$db->prepare('UPDATE entreesortie SET '.$field.'="'.$value.'"WHERE ID_Collab="'.$id.'"');
    $req->execute();
    if ($req->rowCount() > 0) {
        return true;
    }
    else {
        return false;
    }
}




/********************************************************************************************************************/
/* ---------------------------------------------- DATABASE ---------------------------------------------------------*/
/********************************************************************************************************************/
// Function to connect to the database
function dbConnect()
{
    $db = new PDO('mysql:host=localhost;dbname=cis;charset=utf8', 'root', 'molsha');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $db;
}





