<?php
require("../frontend.php");
$db = dbConnect();
$list='<option value=""></option>';
$siteRegion=getSiteRegion($_POST["siteID"]);
$siteRegion=$siteRegion->fetch();
if ($siteRegion) {
    $roleList=siteRoles($siteRegion["Region"]);
    while ($data=$roleList->fetch()) {
        $list.='<option value="'.$data['Role'].'">'.$data['Role'].'</option>';
    }   
}

echo $list;


