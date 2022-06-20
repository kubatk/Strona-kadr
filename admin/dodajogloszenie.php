<?php
    session_start();

    //jezeli nie admin - przekieruj na głowną
    if (!$_SESSION['admin']){
        header("Location: ../index.php");
        exit();
    }

    //łączenie z bazą
    require_once "../config/database.php";
    if (!$pol = mysqli_connect($db_host, $db_user, $db_pass, $db_name)){
        $_SESSION['blad'] = "Nie udało się połączyć z bazą. Spróbuj ponownie póżniej";
        header("Location: ../index.php");
        exit();
    }
    mysqli_query($pol, "SET NAMES 'utf8'");

    //czy formularz wysłany?
    if (isset($_POST['opis'])){
        $zap = "INSERT INTO ogloszenia VALUES (NULL, ".$_POST['stanowisko'].", '".$_POST['opis']."', '".$_POST['wymagania']."')";
        if (mysqli_query($pol, $zap)){
            $_SESSION['sukces'] = "Dodano nowe ogłoszenie";
            header("Location: ../index.php");
            exit();
        }
        else{
            $_SESSION['blad'] = "Nie udało się dodać ogłoszenia. Spróbuj ponownie póżniej";
            header("Location: ../index.php");
            exit();
        }
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

        <h1>Kreator tworzenia oferty pracy</h1>
        
        <div class="box">
            <form method="post">
                <table>
                    <tr>
                        <td>Stanowisko:</td>
                        <td>
                            <select name="stanowisko">
                                <?php
                                    //pokazywanie nazw działów
                                    $zap1 = "SELECT stanowiska.ID AS ID, dzialy.nazwa AS dzial, stanowiska.nazwa AS stanowisko FROM dzialy JOIN stanowiska ON dzialy.ID = ID_dzial ORDER BY dzialy.ID ASC;";
                                    $query1 = mysqli_query($pol, $zap1);
                    
                                    while($w1 = mysqli_fetch_array($query1)){
                                        echo'
                                            <option value="'.$w1['ID'].'">'.$w1['dzial'].': '.$w1['stanowisko'].'</option>
                                        ';
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Opis:</td>
                        <td><textarea name="opis" rows="25" cols="60" style="font-size: 18px;"></textarea></td>
                    </tr>
                    <tr>
                        <td>Wymagania:</td>
                        <td><textarea name="wymagania" rows="10" cols="60" style="font-size: 18px;" placeholder="Wymagania oddziel znakiem ';'"></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" style="float: right;" value="Dodaj ogloszenie"></td>
                    </tr>
                </table>
            </form>
        </div>
            
             
	</div>
    
    <div class="footer">
        <div class="footer-content">Projekt wykonał: Jakub Trzciński</div>
    </div>
    <?php
        mysqli_close($pol);
    ?>
</body>
</html>