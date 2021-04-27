<?php
require('../frontend.php');
$result=projectAutoSearch($_POST["query"]);

$data = array();

if ($result) {

    while ($row=$result->fetch()) {
        $data[] = $row["Code"];
    }
}

echo json_encode($data);



