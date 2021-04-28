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

                    // Total resultats
                    $tothom = 'SELECT * FROM enquesta';
                    $resultTothom = mysqli_query($connexio, $tothom);

                    $total = mysqli_num_rows($resultTothom);

                    echo("<p> Un total de <span class='negreta'>" . $total . " persones</span> han omplert el formulari.</p>");

                    // Variables per gràfics
                    $edat = 0;
                    $webPropiSi = 0;
                    $webPropiNo = 0;
                    $tendriesWebSi = 0;
                    $tendriesWebNo = 0;
                    $personal = 0;
                    $empresarial = 0;
                    $aficions = 0;
                    $altres = 0;
                    $preuMitja = 0;
                    $elevat = 0;
                    $economic = 0;
                    $assequible = 0;

                    // Llegim les dades de la taula i les guardem en variables
                    if(mysqli_num_rows($resultTothom) > 0) {
                        while($filera = mysqli_fetch_assoc($resultTothom)) {
                            
                            $sumaEdat = $sumaEdat + $filera["edat"];

                            if($filera["webPropi"] == 'si') {
                                $webPropiSi++;
                            } else {
                                $webPropiNo++;
                            }

                            if($filera["tendriesWeb"] == 'si') {
                                $tendriesWebSi++;
                            } else {
                                $tendriesWebNo++;
                            }

                            if($filera["perqueWeb"] == 'personal') {
                                $personal++;
                            } elseif ($filera["perqueWeb"] == 'empresarial') {
                                $empresarial++;
                            } elseif ($filera["perqueWeb"] == 'aficions') {
                                $aficions++;
                            } else {
                                $altres++;
                            }

                            $sumaPreus = $sumaPreus + $filera["preuWeb"];

                            if($filera["preuDeu"] == 'elevat') {
                                $elevat++;
                            } elseif($filera["preuDeu"] == 'assequible') {
                                $assequible++;
                            } else {
                                $economic++;
                            }

                        }

                        // Printem les dades

                        echo("<h2 class='titol-resultat'>Edat</h2><p>Quina es la teva edat?</p>");
                        $mitjaEdat = $sumaEdat / $total;
                        echo("<p>La mitja és de <span class='negreta'>" . $mitjaEdat . " anys</span>.</p>");

                        // Gràfic Web Propi
                        echo("<h2 class='titol-resultat'>Web propia</h2><p>Tens un lloc web propi?</p>");
                        $percWebPropiSi = $webPropiSi * 100 / $total; 
                        echo("<p class='color-verd grafic-recte' style='width: ". ($percWebPropiSi * 2 + 34) . "px'>" . $percWebPropiSi . "% (" . $webPropiSi . ")</p>");
                        $percWebPropiNo = $webPropiNo * 100 / $total; 
                        echo("<p class='color-vermell grafic-recte' style='width: ". ($percWebPropiNo * 2 + 34) . "px'>" . $percWebPropiNo . "% (" . $webPropiNo . ")</p>");

                        // Gràfic Tindries Web
                        echo("<h2 class='titol-resultat'>Tindries web</h2><p>Si la resposta anterior és no, has pensat algun cop en tenir un lloc web?</p>");
                        $percTendriesWebSi = $tendriesWebSi * 100 / $total;
                        echo("<p class='color-verd grafic-recte' style='width: ". ($percTendriesWebSi * 2 + 34) . "px'>" . $percTendriesWebSi . "% (" . $tendriesWebSi . ")</p>");
                        $percTendriesWebNo = $tendriesWebNo * 100 / $total;
                        echo("<p class='color-vermell grafic-recte' style='width: ". ($percTendriesWebNo * 2 + 34) . "px'>" . $percTendriesWebNo . "% (" . $tendriesWebNo . ")</p>");

                        // Gràfic Perque Web
                        echo("<h2 class='titol-resultat'>Perque web</h2><p>Si la resposta anterior és no, has pensat algun cop en tenir un lloc web?</p>");
                        $percPersonal = $personal * 100 / $total;
                        $percEmpresarial = $empresarial * 100 / $total;
                        $percAficions = $aficions * 100 / $total;
                        $percAltres = $altres * 100 / $total;
                        echo("<p class='color-verd grafic-recte' style='width: ". ($percPersonal * 2 + 34) . "px'>" . $percPersonal . "% (" . $personal . ")</p>");
                        echo("<p class='color-vermell grafic-recte' style='width: ". ($percEmpresarial * 2 + 34) . "px'>" . $percEmpresarial . "% (" . $empresarial . ")</p>");
                        echo("<p class='color-blau grafic-recte' style='width: ". ($percAficions * 2 + 34) . "px'>" . $percAficions . "% (" . $aficions . ")</p>");
                        echo("<p class='color-taronja grafic-recte' style='width: ". ($percAltres * 2 + 34) . "px'>" . $percAltres . "% (" . $altres . ")</p>");

                        // Gràfic Preu Lloc Web
                        echo("<h2 class='titol-resultat'>Preu</h2><p>Indica el preu que creus que hauria de tenir un lloc web (anualment):</p>");
                        $mitjaPreus = $sumaPreus / $total;
                        echo("<p>La mitja és de <span class='negreta'>" . $mitjaPreus . " euros</span>.</p>");

                        // Gràfic preu 10
                        echo("<h2 class='titol-resultat'>Preu 10</h2><p>Creus que un preu al voltant dels 10€ (anualment) és un bon preu?</p>");
                        $percElevat = $elevat * 100 / $total;
                        $percAssequible = $assequible * 100 / $total;
                        $percEconomic = $economic * 100 / $total;
                        echo("<p class='color-verd grafic-recte' style='width: ". ($percElevat * 2 + 34) . "px'>" . $percElevat . "% (" . $elevat . ")</p>");
                        echo("<p class='color-vermell grafic-recte' style='width: ". ($percAssequible * 2 + 34) . "px'>" . $percAssequible . "% (" . $assequible . ")</p>");
                        echo("<p class='color-blau grafic-recte' style='width: ". ($percEconomic * 2 + 34) . "px'>" . $percEconomic . "% (" . $economic . ")</p>");

                        ?>

                        <!-- Buscador -->
                        <h2 class="titol-resultat">Usuaris que han respòs</h2>
                        <p>Selecciona un correu electrònic d'un usuari</p>
                        <form class="selec-usuaris" method="POST" action="usuari.php">
                            <select name="usuari" class="buscador" id="usuari" required>
                                <?php

                                $correus = 'SELECT correu FROM enquesta';
                                $resultCorreus = mysqli_query($connexio, $correus);


                                if (mysqli_num_rows($resultCorreus) > 0) {
                                    while($correu = mysqli_fetch_assoc($resultCorreus)) {
                                        $tempCorreu = $correu["correu"];
                                        echo("<option value='" . $tempCorreu . "'>" . $tempCorreu . "</option>");
                                    }
                                }

                                ?>
                            </select>
                            <div class="enviar-formulari esquerra-boto">
                                <input type="submit" value="Buscar"/>
                            </div>
                        </form>
                        <p class="bottom">&nbsp;</p>
                        <?php
                                
                    }


                } else {

                    ?>

            <p class="error-text">Has d'iniciar sessió per a poder loguejar-te aqui</p>

                    <?php
                    
                }

            ?>

        </div>

    </body>
</html>