<?php
require("../frontend.php");
$db = dbConnect();
$values=getTACEFact($_POST["typeActivite"]);
$data=$values->fetch();
echo ($data['Impact_TACE'].":".$data['Facturable']);


