<?php
    session_start();

    //przechwycenie id ogloszenia
    if(isset($_GET['id'])){
        $oferta = $_GET['id'];
    }
    else{
        header("Location: index.php");
        exit();
    }
    
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
        
        <?php
        //łączenie z bazą
            require_once "config/database.php";
            if ($pol = mysqli_connect($db_host, $db_user, $db_pass, $db_name)){
                mysqli_query($pol, "SET NAMES 'utf8'");
                
                //bobieranie danych
                $zap="SELECT ogloszenia.ID AS ID, dzialy.nazwa AS dzial, stanowiska.nazwa AS stanowisko, opis, wymagania, stawka, miejsca FROM ogloszenia, dzialy, stanowiska WHERE ogloszenia.ID_stanowiska = stanowiska.ID AND stanowiska.ID_dzial = dzialy.ID AND ogloszenia.ID = ".$oferta;
                $query = mysqli_query($pol, $zap);
                $w = mysqli_fetch_array($query);
                
                //eksport wymagan do tablicy
                $wymagania = explode("; ",$w['wymagania']);
                
                mysqli_close($pol);
            }
        ?>
        
        <h2>Przeglądasz ofertę: "<?php echo $w['dzial'].": ".$w['stanowisko']; ?>"</h2>
        <div class="box">
            <div class="desc">
                <pre><?php echo $w['opis']; ?></pre>
                <br><hr><br>
                <b>Stawka:</b> <?php echo $w['stawka']; ?>zł
                <br><br>
                <b>Wymagania:</b>
                <ul>
                    <?php
                        //wyswietlenie wymagan
                        foreach ($wymagania as $wymog){
                            echo "<li>$wymog</li>";
                        }
                    ?>
                </ul>

                <br>
                Jeżeli oferta wydaje Ci się być interesująca - nie czekaj!
                <button onclick="location.href='aplikuj.php?id=<?php echo $w['ID']; ?>'">Zgłoś się teraz!</button>
            </div>
        </div>
                
            

             
	</div>
    
    <div class="footer">
        <div class="footer-content">Projekt wykonał: Jakub Trzciński</div>
    </div>
	
</body>
</html>