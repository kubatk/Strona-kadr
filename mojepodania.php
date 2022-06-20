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
		
        
        <h1>Oczekujące podania:</h1>
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
        

        <?php
            //łączenie z bazą
            require_once "config/database.php";
            if ($pol = mysqli_connect($db_host, $db_user, $db_pass, $db_name)){
                mysqli_query($pol, "SET NAMES 'utf8'");
                
                //pobranie ogloszen z bazy
                $zap = "SELECT stanowiska.nazwa AS stanowisko, dzialy.nazwa AS dzial, podania.zaakceptowane FROM ogloszenia, podania, stanowiska, dzialy WHERE podania.oferta = ogloszenia.ID AND ogloszenia.ID_stanowiska = stanowiska.ID AND stanowiska.ID_dzial = dzialy.ID AND podania.UID = ".$_SESSION['UID'];
                $query = mysqli_query($pol, $zap);
                
                while($w = mysqli_fetch_array($query)){
                    
                    if($w['zaakceptowane'])
                    echo'
                        <div class="box">
                            <div class="title">'.$w['dzial'].': '.$w['stanowisko'].'</div>
                            <div class="desc"><i class="fas fa-chevron-right"></i> <span style="color: darkgreen">Gratulujemy! Jesteś już naszym pracownikiem!</span></div>
                            </div>
                        ';
                    else
                        echo'
                        <div class="box">
                            <div class="title">'.$w['dzial'].': '.$w['stanowisko'].'</div>
                            <div class="desc"><i class="fas fa-chevron-right"></i> Twoje podanie jest jeszcze rozpatrywane</div>
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