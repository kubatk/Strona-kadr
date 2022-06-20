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
		
        <h1>Struktura firmy - jednostki organizacyjne</h1>
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
            <button onclick="location.href='dodajdzial.php'"><i class="fas fa-plus-circle"></i> Dodaj dział</button>
            <button onclick="location.href='dodajstanowisko.php'"><i class="fas fa-plus-circle"></i> Dodaj stanowisko</button>
            <button onclick="location.href='wolneetaty.php'"><i class="fas fa-eye"></i> Pokaż wolne etaty</button>
        </h3>
            
        <div class="box">
            <?php
                //łączenie z bazą
                require_once "../config/database.php";
                if ($pol = mysqli_connect($db_host, $db_user, $db_pass, $db_name)){
                    
                    mysqli_query($pol, "SET NAMES 'utf8'");
                    
                    //pokazywanie nazw działów
                    $zap1 = "SELECT * FROM dzialy";
                    $query1 = mysqli_query($pol, $zap1);
                    
                    while($w1 = mysqli_fetch_array($query1)){
                        echo'
                                <details>
                                    <summary>'.$w1['nazwa'].'</summary>
                                    <a href="edytujdzial.php?id='.$w1['ID'].'" title="Kliknij, aby edytować"><i class="fas fa-edit"></i> Edytuj dział</a>
                                    <br>
                                    <ul>
                        ';
                        
                        //wyswietlanie stanowisk
                        $zap2 = "SELECT * FROM stanowiska WHERE ID_dzial = ".$w1['ID'];
                        $query2 = mysqli_query($pol, $zap2);
                        
                        while ($w2 = mysqli_fetch_array($query2)){
                            echo'
                                <li><a href="edytujstanowisko.php?id='.$w2['ID'].'" title="Kliknij, aby edytować"><i class="fas fa-edit"></i></a> '.$w2['nazwa'].'</li>
                            ';
                        }
                        
                        echo'
                                    </ul>
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