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
		
        <h1>Wolne miejsca na poszczególnych stanowiskach:</h1>
        <div class="box">
            <ul>
                <?php
                    //łączenie z bazą
                    require_once "../config/database.php";
                    if ($pol = mysqli_connect($db_host, $db_user, $db_pass, $db_name)){
                        mysqli_query($pol, "SET NAMES 'utf8'");

                        //pobranie stanowisk
                        $zap = "SELECT stanowiska.ID AS ID, dzialy.nazwa AS dzial, stanowiska.nazwa AS stanowisko FROM dzialy JOIN stanowiska ON dzialy.ID = ID_dzial ORDER BY dzialy.ID ASC;";
                        $query = mysqli_query($pol, $zap);


                        while($w = mysqli_fetch_array($query)){

                            //pobranie wolnych miejsc z bazy
                            $zap1 = "SELECT ((SELECT miejsca FROM stanowiska WHERE ID = ".$w['ID'].") - (SELECT COUNT(liczba) FROM (SELECT ID_stanowiska AS liczba FROM pracownicy WHERE ID_stanowiska = ".$w['ID'].") AS tab)) AS wolne";
                            $query1 = mysqli_query($pol, $zap1);
                            $wolne = mysqli_fetch_array($query1);


                            if ($wolne['wolne'] > 0)
                            echo'
                                <li>'.$w['dzial'].': '.$w['stanowisko'].' - wolne miejsca: '.$wolne['wolne'].'</li>
                            ';
                        }

                        //zamknięcie połączenia
                        mysqli_close($pol);

                    }
                ?>
            </ul>
        </div>
	</div>
    
    <div class="footer">
        <div class="footer-content">Projekt wykonał: Jakub Trzciński</div>
    </div>
	
</body>
</html>