<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Enquesta | Nebula Hosting</title>
        <link href="css/styles.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="img/favicon.png"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    </head>
    <body>

        <header>

            <a class="logo-nebula" href="https://www.nebula.cat/"><img src="img/logo-lila.png" alt="Logo Nebula"></a>
            <h1 class="titol-nebula">Nebula <span class="color-lila">Hosting</span></h1>
            <p class="autor-nebula">Desenvolupat per Gabriel Franco</p>

        </header>

        <div class="contingut">

        <?php

            // Si m'arriba la variable permis amb alguna cosa
            if($_POST) {

                if($_POST['permis']!='on') {
                    ?>
                    <p class="error-text">Vaja! <?php echo($_POST['nomcognoms']); ?>, si no em dones permís per a tractar les teves dades no puc emmagatzemar el resultat del formulari.</p>
                    <p class="botons"><a href="https://enquesta.nebula.cat/"><i class="fas fa-arrow-alt-circle-left"></i> Tornar enrere</a></p>
                    <?php
                } else {

                    //Connexió amb la base de dades
                    $connexio = mysqli_connect("########", "########", "########", "########");

                    if (!$connexio) {
                        die("<p class='error-text'>Connexió fallida" . mysqli_connect_error() . "</p>");
                    }

                    // Comprovació de si el correu ja ha enviat una
                    $correu = $_POST['correu'];

                    $comprovacioSQL = "SELECT * FROM enquesta WHERE correu = '$correu'";
                    $resultatComprovacio = mysqli_query($connexio, $comprovacioSQL);

                    $filesComprovacio = mysqli_num_rows($resultatComprovacio);

                    if ($filesComprovacio == 1) {

                        echo("<p class='error-text'>Ei " . $_POST['nomcognoms'] . "! Ja has enviat un formulari anteriorment, només es pot enviar un per persona.</p>");
                        echo("<p class='botons'><a href='https://enquesta.nebula.cat/'><i class='fas fa-arrow-alt-circle-left'></i> Tornar enrere</a></p>");

                    } else {
                        // Agafem els resultats del formulari
                        $nomcognoms = $_POST['nomcognoms'];
                        $edat = $_POST['edat'];
                        $webPropi = $_POST['webPropi'];
                        $tendriesWeb = $_POST['tendriesWeb'];
                        $perqueWeb = $_POST['perqueWeb'];
                        $preuWeb = $_POST['preuWeb'];
                        $preu10 = $_POST['preuDeu'];

                        //Agafem la seva adreça IP
                        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                            $ip = $_SERVER['HTTP_CLIENT_IP'];
                        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                        } else {
                            $ip = $_SERVER['REMOTE_ADDR'];
                        }

                        if(empty($_POST['perqueWebAltres'])) {
                            $inserirSQL = "INSERT INTO enquesta (correu, nomcognoms, edat, webPropi, tendriesWeb, perqueWeb, preuWeb, preuDeu, ip) VALUES ('$correu', '$nomcognoms', '$edat', '$webPropi', '$tendriesWeb', '$perqueWeb', '$preuWeb', '$preu10', '$ip')";
                            
                            if(mysqli_query($connexio, $inserirSQL)) {
                                echo("<p>Gràcies " . $nomcognoms . " per omplir l'enquesta!</p>");
                                echo("<p class='botons'><a href='https://www.nebula.cat/'><i class='fas fa-server'></i>Nebula Hosting</a></p>");

                            } else {
                                echo("<p class='error-text'>Ho sento " . $nomcognoms . " hi ha algun problema amb la base de dades!</p>");
                                echo("<p class='error-text'> Error: " . $inserirSQL . "</br></br>" . mysqli_error($connexio) . "</p>");
                            }

                        } else {
                            $perqueWebAltres = $_POST['perqueWebAltres'];
                            $inserirSQL = "INSERT INTO enquesta (correu, nomcognoms, edat, webPropi, tendriesWeb, perqueWeb, perqueWebAltres, preuWeb, preuDeu, ip) VALUES ('$correu', '$nomcognoms', '$edat', '$webPropi', '$tendriesWeb', '$perqueWeb', '$perqueWebAltres', '$preuWeb', '$preu10', '$ip')";

                            if(mysqli_query($connexio, $inserirSQL)) {
                                echo("<p>Gràcies " . $nomcognoms . " per omplir l'enquesta!</p>");
                                echo("<p class='botons'><a href='https://www.nebula.cat/'><i class='fas fa-server'></i> Nebula Hosting</a></p>");

                            } else {
                                echo("<p class='error-text'>Ho sento " . $nomcognoms . " hi ha algun problema amb la base de dades!</p>");
                                echo("<p class='error-text'> Error: " . $inserirSQL . "</br></br>" . mysqli_error($connexio) . "</p>");
                            }

                        }

                    }

                }

            }
            else {
                ?>
                <!-- FORMULARI PRINCIPAL -->
                <form class="formulari" action="#" method="POST">

                    <h1 class="titol-apartat-formulari">Sobre tu</h1>
                    <div class="camp-formulari">

                        <p class="enunciat">Introdueix el teu nom i cognoms:</p>
                        <input class="camp-text" type="text" name="nomcognoms" id="nomcognoms" placeholder="Exemple: Gabriel Franco" required/>

                    </div>

                    <div class="camp-formulari">

                        <p class="enunciat">Introdueix el teu correu electrònic:</p>
                        <input class="camp-text" type="email" name="correu" id="correu" placeholder="Introdueix el teu correu electrònic" required/>

                    </div>

                    <div class="camp-formulari">

                        <p class="enunciat">Quina es la teva edat?</p>
                        <input class="camp-text" type="text" name="edat" id="edat" placeholder="Exemple: 19" required/>

                    </div>

                    <h1 class="titol-apartat-formulari">Llocs web</h1>

                    <div class="camp-formulari">

                        <p class="enunciat">Tens un lloc web propi?</p>
                        <p><input type="radio" id="webPropi-si" name="webPropi" value="si"/><label for="webPropi-si">Si</label></p>
                        <p><input type="radio" id="webPropi-no" name="webPropi" value="no" required/><label for="webPropi-no">No</label></p>

                    </div>

                    <div class="camp-formulari">

                        <p class="enunciat">Si la resposta anterior és no, has pensat algun cop en tenir un lloc web?</p>
                        <p><input type="radio" id="tendriesWeb-si" name="tendriesWeb" value="si"/><label for="tendriesWeb-si">Si</label></p>
                        <p><input type="radio" id="tendriesWeb-no" name="tendriesWeb" value="no" required/><label for="tendriesWeb-no">No</label></p>


                    </div>

                    <div class="camp-formulari">

                        <p class="enunciat">Per què voldries arribar a tenir un lloc web?</p>
                        <select name="perqueWeb" id="perqueWeb" required>
                            <option value="personal">Personal</option>
                            <option value="empresarial">Empresarial</option>
                            <option value="aficions">Aficions</option>
                            <option value="altres">Altres</option>

                        </select>

                    </div>

                    <div class="camp-formulari">

                        <p class="enunciat">Si la resposta anterior és altres, indica-ho:</p>
                        <input class="camp-text" type="text" name="perqueWebAltres" id="perqueWebAltres"/>

                    </div>

                    <div class="camp-formulari">

                        <p class="enunciat">Indica el preu que creus que hauria de tenir un lloc web (anualment):</p>
                        <input class="camp-text" type="text" name="preuWeb" id="preuWeb" placeholder="Exemple: 34" required/>

                    </div>

                    <div class="camp-formulari">

                        <p class="enunciat">Creus que un preu al voltant dels 10€ (anualment) és un bon preu?</p>
                        <p><input type="radio" id="preuDeu-elevat" name="preuDeu" value="elevat"/><label for="preuDeu-elevat">Em sembla un preu massa elevat.</label></p>
                        <p><input type="radio" id="preuDeu-assequible" name="preuDeu" value="assequible"/><label for="preuDeu-assequible" required>És un preu assequible, és un preu raonable.</label></p>
                        <p><input type="radio" id="preuDeu-economic" name="preuDeu" value="economic"/><label for="preuDeu-economic">És un preu econòmic pel servei que es.</label></p>
                    </div>

                    <div class="checkbox-formulari">

                        <input type="checkbox" id="permis" name="permis"/><label for="permis">Dono permís per tractar les meves dades.</label>

                    </div>

                    <div class="enviar-formulari">

                        <input type="submit" name="enviar" id="enviar" value="Enviar formulari"/>

                    </div>

                </form>

        </div>
        <?php
            }
        ?>

    </body>
</html>