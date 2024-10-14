<?php
require "connect.php";  

$rendez = $_GET["rendez"] ?? "jarat";  
$kifejezes = $_POST["kifejezes"] ?? ""; 
// Define valid columns for sorting
$validColumns = ["azon", "jarat", "honnan", "hova", "indul", "erkezik"];
$rendez = in_array($rendez, $validColumns) ? $rendez : "jarat";  // Default to "jarat" if invalid

// SQL query with search functionality and sorting
$sql = "SELECT * FROM hajos 
        WHERE (azon LIKE ? 
        OR jarat LIKE ? 
        OR honnan LIKE ? 
        OR hova LIKE ? 
        OR indul LIKE ? 
        OR erkezik LIKE ?)
        ORDER BY {$rendez} ASC";

$stmt = $dbconn->prepare($sql);

if ($stmt) {
    // Use wildcard search with % (LIKE operator in SQL)
    $searchTerm = "%{$kifejezes}%";
    $stmt->bind_param("ssssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $eredmeny = $stmt->get_result();  // Get result set

    // Output table
    $kimenet = "<table>
                    <tr>
                        <th><a href=\"?rendez=azon\">Azon</a></th>
                        <th><a href=\"?rendez=jarat\">Járat</a></th>
                        <th><a href=\"?rendez=honnan\">Honnan</a></th>
                        <th><a href=\"?rendez=hova\">Hova</a></th>
                        <th><a href=\"?rendez=indul\">Indul</a></th>
                        <th><a href=\"?rendez=erkezik\">Érkezik</a></th>
                        <th>Művelet</th>
                    </tr>";

    while ($sor = $eredmeny->fetch_assoc()) {
        // Sanitize data for safe output
        $azon = htmlspecialchars($sor["azon"], ENT_QUOTES, "utf-8");
        $jarat = htmlspecialchars($sor["jarat"], ENT_QUOTES, "utf-8");
        $honnan = htmlspecialchars($sor["honnan"], ENT_QUOTES, "utf-8");
        $hova = htmlspecialchars($sor["hova"], ENT_QUOTES, "utf-8");
        $indul = htmlspecialchars($sor["indul"], ENT_QUOTES, "utf-8");
        $erkezik = htmlspecialchars($sor["erkezik"], ENT_QUOTES, "utf-8");

        // Table row for each ship schedule
        $kimenet .= "<tr>
                        <td>{$azon}</td>
                        <td>{$jarat}</td>
                        <td>{$honnan}</td>
                        <td>{$hova}</td>
                        <td>{$indul}</td>
                        <td>{$erkezik}</td>
                        <td><a href=\"torles.php?id={$sor['azon']}\">Törlés</a> | <a href=\"modositas.php?id={$sor['azon']}\">Módosítás</a></td>
                    </tr>";
    }
    $kimenet .= "</table>";
    
    $stmt->close();  // Close the statement
} else {
    echo "Hiba az utasítás létrehozásában: " . $dbconn->error;
}

?>
