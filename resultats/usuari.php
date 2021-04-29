<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Enquesta | Nebula Hosting</title>
        <link href="../css/styles.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="../img/favicon.png"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    </head>
    <body>

        <header>

            <a class="logo-nebula" href="https://www.nebula.cat/"><img src="../img/logo-lila.png" alt="Logo Nebula"></a>
            <h1 class="titol-nebula">Nebula <span class="color-lila">Hosting</span></h1>
            <p class="autor-nebula">Desenvolupat per Gabriel Franco</p>

        </header>

        <div class="contingut resultat">

            <?php 
                if($_SESSION['loguejat'] == 'true') {

                    // Agafo variables de connexio
                    include "../credencials.php";

                    // Connexio amb la BDD
                    $connexio = mysqli_connect('localhost', $bddUsuari, $bddContra, $bddBase);
                    if (!$connexio) {
                        die("<p class='error-text'>Connexió fallida" . mysqli_connect_error() . "</p>");
                    }

                    $correuSeleccionat = $_POST['usuari'];
                    $usuariSQL = "SELECT * FROM enquesta WHERE correu = '$correuSeleccionat'";
                    $resultUsuari = mysqli_query($connexio, $usuariSQL);

                    if (mysqli_num_rows($resultUsuari) > 0) {
                        while($usuari = mysqli_fetch_assoc($resultUsuari)) {
                            $nomcognoms = $usuari["nomcognoms"];
                            $edat = $usuari["edat"];
                            $webPropi = $usuari["webPropi"];
                            $tendriesWeb = $usuari["tendriesWeb"];
                            $perqueWeb = $usuari["perqueWeb"];
                            $perqueWebAltres = $usuari["perqueWebAltres"];
                            $preuWeb = $usuari["preuWeb"];
                            $preuDeu = $usuari["preuDeu"];
                            $ip = $usuari["ip"];
                        }
                    }

                    ?>

                    <p class="enunciat-resultat">Correu</p>
                    <p><?php echo($correuSeleccionat); ?></p>
                    <p class="enunciat-resultat">Introdueix el teu nom i cognoms:</p>
                    <p><?php echo($nomcognoms); ?></p>
                    <p class="enunciat-resultat">Quina es la teva edat?</p>
                    <p><?php echo($edat); ?></p>
                    <p class="enunciat-resultat">Tens un lloc web propi?</p>
                    <p><?php echo($webPropi); ?></p>
                    <p class="enunciat-resultat">Si la resposta anterior és no, has pensat algun cop en tenir un lloc web?</p>
                    <p><?php echo($tendriesWeb); ?></p>
                    <p class="enunciat-resultat">Per què voldries arribar a tenir un lloc web?</p>
                    <p><?php echo($perqueWeb); ?></p>
                    <p class="enunciat-resultat">Si la resposta anterior és altres, indica per a què voldries un lloc web:</p>
                    <p><?php echo($perqueWebAltres); ?></p>
                    <p class="enunciat-resultat">Indica el preu que creus que hauria de tenir un lloc web (anualment):</p>
                    <p><?php echo($preuWeb); ?></p>
                    <p class="enunciat-resultat">Creus que un preu al voltant dels 10€ (anualment) és un bon preu?</p>
                    <p><?php echo($preuDeu); ?></p>
                    <p class="enunciat-resultat">Direccion IP:</p>
                    <p><?php echo($ip); ?></p>

                    <p class="botons"><a href="resultats.php"><i class="fas fa-arrow-circle-left"></i> Tornar</a></p>

                    <?php


                } else {

                    ?>

            <p class="error-text">Has d'iniciar sessió per a poder loguejar-te aqui</p>

                    <?php
                    
                }

            ?>

        </div>

    </body>
</html>