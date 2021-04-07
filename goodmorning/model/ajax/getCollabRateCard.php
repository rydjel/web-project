<?php
require("../frontend.php");
$db = dbConnect();
$value=getACollabRC($_POST["collab"]);
$data=$value->fetch();
echo $data['RateCard'];


