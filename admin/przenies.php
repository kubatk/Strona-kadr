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
        header("Location: ../pracownicy.php");
        exit();
    }
    mysqli_query($pol, "SET NAMES 'utf8'");

    //odebranie ID użytkownika
    if (isset($_GET['uid'])){
        $uid = $_GET['uid'];
    }
    else{
        $_SESSION['blad'] = "Nie można zatrudnić pracownika. Spróbuj ponownie później.";
        header('Location: pracownicy.php');
        exit();
    }

    //czy formularz wysłany?
    if (isset($_POST['stanowisko'])){
        $zap = "UPDATE pracownicy SET ID_stanowiska = ".$_POST['stanowisko']." WHERE UID = ".$uid;
        if (mysqli_query($pol, $zap)){
            $_SESSION['sukces'] = "Pomyślnie przypisano pracownika";
            header("Location: pracownicy.php");
            exit();
        }
        else{
            $_SESSION['blad'] = "Nie udało się przypisać pracownika. Spróbuj ponownie póżniej";
            header("Location: pracownicy.php");
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

        <h1>Przenoszenie pracownika</h1>
        
        <?php
            $zap1 = "SELECT imie, nazwisko FROM daneosobowe WHERE UID = ".$uid;
            $query1 = mysqli_query($pol, $zap1);
            $w1 = mysqli_fetch_array($query1);
            echo"<h2>Przenosisz: ".$w1['imie']." ".$w1['nazwisko']."</h2>";
        ?>
        
        <div class="box">
            <form method="post">
                <table>
                    <tr>
                        <td>Stanowisko:</td>
                        <td>
                            <select name="stanowisko">
                                <?php
                                    //pokazywanie nazw działów
                                    $zap2 = "SELECT stanowiska.ID AS ID, dzialy.nazwa AS dzial, stanowiska.nazwa AS stanowisko FROM dzialy JOIN stanowiska ON dzialy.ID = ID_dzial ORDER BY dzialy.ID ASC;";
                                    $query2 = mysqli_query($pol, $zap2);
                    
                                    while($w2 = mysqli_fetch_array($query2)){
                                        echo'
                                            <option value="'.$w2['ID'].'">'.$w2['dzial'].': '.$w2['stanowisko'].'</option>
                                        ';
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" style="float: right;" value="Przypisz pracownika"></td>
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