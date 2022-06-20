<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Znajdź pracę</title>
    
	<link rel="stylesheet" type="text/css" href="css/style.css">
    
	<link href="https://fonts.googleapis.com/css?family=Lato|Ubuntu" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
</head>
<body>
    
    <!-- menu-->
    <?php include "skrypty/menu.php"; ?>

    
    <div class="content">
		
        
        <h1>Aktualnie poszukujemy:</h1>
        <?php
        
            if (isset($_SESSION['blad'])){    
                echo '<h2 style="color: red;">'.$_SESSION['blad'].'</h2>';
                unset($_SESSION['blad']);
            }
            if (isset($_SESSION['sukces'])){    
                echo '<h2 style="color: green;">'.$_SESSION['sukces'].'</h2>';
                unset($_SESSION['sukces']);
            }
        
            if (isset($_SESSION['admin']) && $_SESSION['admin']){
                echo'
                <h3>
                    <button onclick="location.href=\'admin/dodajogloszenie.php\'"><i class="fas fa-plus-circle"></i> Dodaj nowe ogłoszenie</button>
                </h3>
                ';
            }
        ?>
        
        <!-- DRUKOWANIE LISTY OFERT -->
        
        
        <?php
            //łączenie z bazą
            require_once "config/database.php";
            if ($pol = mysqli_connect($db_host, $db_user, $db_pass, $db_name)){
                mysqli_query($pol, "SET NAMES 'utf8'");
                
                //pobranie ogloszen z bazy
                $zap = "SELECT ogloszenia.ID AS ID, dzialy.nazwa AS dzial, stanowiska.nazwa AS stanowisko, stanowiska.stawka, ogloszenia.opis, ogloszenia.wymagania FROM ogloszenia, stanowiska, dzialy WHERE ogloszenia.ID_stanowiska = stanowiska.ID AND stanowiska.ID_dzial = dzialy.ID";
                $query = mysqli_query($pol, $zap);
                
                while($w = mysqli_fetch_array($query)){
                    
                    echo'
                    <div class="box">
                        <div class="title">'.$w['dzial'].': '.$w['stanowisko'].'</div>
                        <div class="desc">'.$w['opis'].'</div>
                    ';
                    
                    if(isset($_SESSION['admin']) && $_SESSION['admin'])
                        echo'    
                        <a href="admin/edytujogloszenie.php?id='.$w['ID'].'" class="more">Otwórz w trybie edycji</a>
                        <a href="oferta.php?id='.$w['ID'].'" class="more">Pokaż w widoku użytkownika</a>
                        ';
                    else echo'
                        <a href="oferta.php?id='.$w['ID'].'" class="more">Pokaż szczegóły</a>
                    ';
                    
                    echo'
                        </div>
                    ';
                }
                
                //zamknięcie połączenia
                mysqli_close($pol);
                
            }

        
        ?>
             
	</div>
    
    <div class="footer">
        <div class="footer-content">Projekt wykonał: Jakub Trzciński</div>
    </div>
	
</body>
</html>