<?php
    session_start();

    //jezeli nie admin - przekieruj na głowną
    if (!$_SESSION['admin']){
        header("Location: ../index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Znajdź pracę</title>
    
	<link rel="stylesheet" type="text/css" href="../css/style.css">
    
	<link href="https://fonts.googleapis.com/css?family=Lato|Ubuntu" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
</head>
<body>
    
    <!-- menu-->
    <?php include "../skrypty/menu.php"; ?>

    
    <div class="content">
		
        <h1>Niezatrudnieni użytkownicy zarejestrowani w systemie</h1>
        <?php
            if (isset($_SESSION['blad'])){    
                echo '<h2 style="color: red;">'.$_SESSION['blad'].'</h2>';
                unset($_SESSION['blad']);
            }
            if (isset($_SESSION['sukces'])){    
                echo '<h2 style="color: green;">'.$_SESSION['sukces'].'</h2>';
                unset($_SESSION['sukces']);
            }
        ?>
        <h3>
            <button onclick="location.href='dodajuzytkownika.php'"><i class="fas fa-plus-circle"></i> Dodaj użytkownika</button>
        </h3>
        <h3>
            Kliknij na użytkownika, żeby pokazać opcje.
        </h3>
            
        <div class="box">
            <?php
                //łączenie z bazą
                require_once "../config/database.php";
                if ($pol = mysqli_connect($db_host, $db_user, $db_pass, $db_name)){
                    
                    mysqli_query($pol, "SET NAMES 'utf8'");
                    
                    //pokazywanie uzytkownikow
                    $zap1 = "SELECT * FROM uzytkownicy INNER JOIN daneosobowe ON uzytkownicy.UID = daneosobowe.UID WHERE uzytkownicy.UID NOT IN (SELECT UID FROM pracownicy) AND admin = 0";
                    $query1 = mysqli_query($pol, $zap1);
                    
                    while($w1 = mysqli_fetch_array($query1)){
                        if ($w1['plec'] == 'm') $plec = "mężczyzna";
                        else $plec = "kobieta";
                        echo'
                                <details>
                                    <summary>['.$w1['UID'].'] '.$w1['imie'].' '.$w1['nazwisko'].'</summary>

                                    <table>
                                        <tr>
                                            <td>Płeć:</td>
                                            <td>'.$plec.'</td>
                                        </tr>
                                        <tr>
                                            <td>E-mail:</td>
                                            <td>'.$w1['email'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Telefon:</td>
                                            <td>'.$w1['tel'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Data urodzenia:</td>
                                            <td>'.$w1['data_ur'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Adres:</td>
                                            <td>'.$w1['miasto'].', '.$w1['adres'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Korespondencja:</td>
                                            <td>'.$w1['poczta'].', '.$w1['kod_pocztowy'].'</td>
                                        </tr>
                                    </table>
                                    <button onclick="location.href=\'zatrudnij.php?uid='.$w1['UID'].'\'"><i class="fas fa-user-check"></i> Zatrudnij użytkownika</button>
                                    <button onclick="location.href=\'edytujuzytkownika.php?uid='.$w1['UID'].'\'"><i class="fas fa-user-edit"></i> Edytuj użytkownika</button>
                                </details>
                        ';
                    } 
                }
            ?>
        </div>
            
             
	</div>
    
    <div class="footer">
        <div class="footer-content">Projekt wykonał: Jakub Trzciński</div>
    </div>
	
</body>
</html>