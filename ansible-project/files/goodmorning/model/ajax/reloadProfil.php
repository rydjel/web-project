<?php
require("../frontend.php");
$idExtend=explode("-",$_POST['idExtend']);
$idProfil=$idExtend[1];
$profil=getProfilDetails($idProfil);
$profil=$profil->fetch();
$reload=$profil['détails'].":".$profil['ID_PT'];
echo $reload;

