<?php 

if(isset($_POST['rendben'])){
    $azon = htmlspecialchars(strip_tags(ucwords(strtolower(trim($_POST['azon'])))));
    $jarat = htmlspecialchars(strip_tags(ucwords(strtolower(trim($_POST['jarat'])))));
    $honnan = htmlspecialchars(strip_tags(trim($_POST['honnan'])));
    $hova = htmlspecialchars(strip_tags(trim($_POST['hova'])));
    $indul = htmlspecialchars(strip_tags(trim($_POST['indul'])));
    $erkezik = htmlspecialchars(strip_tags(trim($_POST['erkezik'])));

    if(empty($azon)){
        $hibak[] = "Nem adott meg azonosítót!";
    }
    if(empty($jarat)){
        $hibak[] = "Nem adott meg járatot!";
    }
    if(empty($honnan)){
        $hibak[] = "Nem adta meg az indulási helyet!";
    }
    if(empty($hova)){
        $hibak[] = "Nem adta meg a célállomást!";
    }
    if(empty($indul)){
        $hibak[] = "Indulási időt nem adott meg!";
    }
    if(empty($erkezik)){
        $hibak[] = "Érkezési időt nem adott meg!";
    }


    if(isset($hibak)){
        $kimenet = "<ul>\n";
        foreach($hibak as $hiba){
            $kimenet .= "<li>{$hiba}</li>";
        }
        $kimenet .= "</ul>\n";
    } else {
        require "../connect.php";

        $stmt = $dbconn->prepare("INSERT INTO hajos (azon, jarat, honnan, hova, indul, erkezik) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $azon, $jarat, $honnan, $hova, $indul, $erkezik);

        if ($stmt->execute()) {
            $kimenet = "<p>Sikeres adatbevitel!</p>";
        } else {
            $kimenet = "<p>Hiba történt az adatbevitel során!</p>";
        }

        $stmt->close();
        $dbconn->close();
    }

}

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../stilus.css">
    <title>Új menetrend feltöltése</title>
</head>
<body>
    <h1>Névjegy felvitele</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <!-- Hibaüzenetek vagy sikeres visszajelzés a usernek -->
        <?php if(isset($kimenet)) print $kimenet; ?>

        <p><label for="azon">Azonosító: *</label></p>
        <input type="text" name="azon" id="azon" value="<?php if(isset($azon)) print $azon; ?>">

        <p><label for="jarat">Járat: *</label></p>
        <input type="text" name="jarat" id="jarat" value="<?php if(isset($jarat)) print $jarat; ?>">

        <p><label for="honnan">Honnan: *</label></p>
        <input type="text" name="honnan" id="honnan" value="<?php if(isset($honnan)) print $honnan; ?>">

        <p><label for="hova">Hova: *</label></p>
        <input type="text" name="hova" id="hova" value="<?php if(isset($hova)) print $hova; ?>">

        <p><label for="indul">Indul: *</label></p>
        <input type="time" name="indul" id="indul" value="<?php if(isset($indul)) print $indul; ?>">

        <p><label for="erkezik">Érkezik: *</label></p>
        <input type="time" name="erkezik" id="erkezik" value="<?php if(isset($erkezik)) print $erkezik; ?>">

        <p><em>*-al jelölt mezők kitöltése kötelező</em></p>

        <input type="submit" value="Rendben" name="rendben" id="rendben">
        <input type="reset" value="Mégsem">
    
    </form>
</body>
</html>
