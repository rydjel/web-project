<?php
require("../frontend.php");
$idExtend=explode("-",$_POST['idExtend']);
$idJOCollab=$idExtend[1];
$JOCollab=getJOCollabDetails($idJOCollab);
$JOCollab=$JOCollab->fetch();
$reload=$JOCollab['NbJours'];
echo $reload;
