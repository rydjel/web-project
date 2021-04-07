<?php
require("../frontend.php");
$db = dbConnect();
$client=$_POST['client'];
$marketUnit=$_POST['marketUnit'];
$idMarketUnit=getIDMarketUnit($marketUnit);
$idExtend=explode("-",$_POST['idExtend']);
$id=$idExtend[1];
if (strpos($client,"\"")!==false or strpos($client,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
    data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Caractères double-quote et deux-points sont interdits</div>';
    $result="KO";
}
elseif ($client=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <a href="#" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</a> Le champ client est vide.</div>';
    $result="KO";
}
elseif (!checkFieldUpdated('NomClient',$client,$id) and !checkFieldUpdated('ID_MarketUnit',$idMarketUnit,$id)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Auncune modification effectuée. </div>';
    $result="OK";
}
elseif (checkFieldUpdated('NomClient',$client,$id) and existClient($client)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Client déjà existant. </div>';
    $result="KO";
}
else {
    if (checkFieldUpdated('NomClient',$client,$id) and updateClient('NomClient',$client,$id) ) {
        $maj=true;
    }
    if (checkFieldUpdated('ID_MarketUnit',$idMarketUnit,$id) and updateClient('ID_MarketUnit',$idMarketUnit,$id) ) {
        $maj=true;
    }
    if ($maj) {
        $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Mise(s) à jour effectuée(s) avec <strong>Success!</strong> .</div>';
        $result="OK";
    }
}
echo $result.":".$message;