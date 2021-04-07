<?php
require("../frontend.php");
$db = dbConnect();
// Accès commentaire
$comment=getCollabTaskImputComment($_POST['collab'],$_POST['task']);
$comment=$comment->fetch();
if ($comment) {
    $value=$comment['commentaire'];
}
else {
    $value="";
}
echo $value;


