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
		
        
        <h1>Podania oczekujące na rozpatrzenie:</h1>
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
            require_once "../config/database.php";
            if ($pol = mysqli_connect($db_host, $db_user, $db_pass, $db_name)){
                mysqli_query($pol, "SET NAMES 'utf8'");
                
                //pobranie stanowisk
                $zap = "SELECT ogloszenia.ID AS ID, dzialy.nazwa AS dzial, stanowiska.nazwa AS stanowisko, stanowiska.ID as ID_stanowiska FROM ogloszenia, stanowiska, dzialy WHERE ogloszenia.ID_stanowiska = stanowiska.ID AND stanowiska.ID_dzial = dzialy.ID";
                $query = mysqli_query($pol, $zap);
                
                
                while($w = mysqli_fetch_array($query)){
                    
                    //pobranie wolnych miejsc z bazy
                    $zap1 = "SELECT ((SELECT miejsca FROM stanowiska WHERE ID = ".$w['ID_stanowiska'].") - (SELECT COUNT(liczba) FROM (SELECT ID_stanowiska AS liczba FROM pracownicy WHERE ID_stanowiska = ".$w['ID_stanowiska'].") AS tab)) AS wolne";
                    $query1 = mysqli_query($pol, $zap1);
                    $wolne = mysqli_fetch_array($query1);
                    
                    echo'
                    <div class="box">
                        <div class="title">'.$w['dzial'].': '.$w['stanowisko'].'<br>
                        <span style="font-size: 20px;">(wolne miejsca: '.$wolne['wolne'].')</span></div>
                    ';
                    
                    //pobranie pracowników
                    $zap2 = "SELECT * FROM uzytkownicy, daneosobowe WHERE uzytkownicy.UID = daneosobowe.UID AND uzytkownicy.UID = (SELECT UID FROM podania WHERE oferta = ".$w['ID']." AND zaakceptowane = 0)";
                    $query2 = mysqli_query($pol, $zap2);
                    
                    if (mysqli_num_rows($query2) > 0){
                        
                        //wypis użytkowników
                        while($w2 = mysqli_fetch_array($query2)){
                            if ($w2['plec'] == 'm') $plec = "mężczyzna";
                            else $plec = "kobieta";
                            
                            //pobranie numeru podania
                            $zap3 = "SELECT ID FROM podania WHERE UID = ".$w2['UID']." AND oferta = ".$w['ID'];
                            $query3 = mysqli_query($pol, $zap3);
                            $w3 = mysqli_fetch_array($query3);
                            
                            echo'
                                    <br><details>
                                        <summary>['.$w2['UID'].'] '.$w2['imie'].' '.$w2['nazwisko'].'</summary>

                                        <table>
                                            <tr>
                                                <td>Płeć:</td>
                                                <td>'.$plec.'</td>
                                            </tr>
                                            <tr>
                                                <td>E-mail:</td>
                                                <td>'.$w2['email'].'</td>
                                            </tr>
                                            <tr>
                                                <td>Telefon:</td>
                                                <td>'.$w2['tel'].'</td>
                                            </tr>
                                            <tr>
                                                <td>Data urodzenia:</td>
                                                <td>'.$w2['data_ur'].'</td>
                                            </tr>
                                            <tr>
                                                <td>Adres:</td>
                                                <td>'.$w2['miasto'].', '.$w2['adres'].'</td>
                                            </tr>
                                            <tr>
                                                <td>Korespondencja:</td>
                                                <td>'.$w2['poczta'].', '.$w2['kod_pocztowy'].'</td>
                                            </tr>
                                        </table>
                                        <button onclick="location.href=\'akceptujpodanie.php?id='.$w3['ID'].'\'" style="background-color: #4caf50;"><i class="fas fa-check"></i> Zaakceptuj podanie</button>
                                        <button onclick="location.href=\'odrzucpodanie.php?id='.$w3['ID'].'\'" style="background-color: #dc524c;"><i class="fas fa-times"></i></i> Odrzuć podanie</button>
                                    </details>
                            ';
                        }
                    }
                    else{
                        echo '<br><span style="color: #CCC; font-size: 18px;">
                            Nikt jeszcze nie zgłosił się na stanowisko...<br>
                        </span>';
                    }
                    
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