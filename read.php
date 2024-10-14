<?php
require("connect.php");
function getContacts(mysqli $dbconn): array {
    $query = "SELECT * FROM menetrend";
    $result = mysqli_query($dbconn, $query);

    if (!$result) {
        // Hiba esetén üres tömb visszaadása
        return [];
    }

    $contacts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $contacts[] = $row;
    }
    return $contacts;
}


function sendJsonResponse($data) {
    header('Content-Type: application/json; charset=utf-8');
    $menet = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    echo $menet;
    file_put_contents("m.json", $menet);
    
}

$contacts = getContacts($dbconn);
sendJsonResponse($contacts);


