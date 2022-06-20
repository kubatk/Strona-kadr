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
        header("Location: struktura-firmy");
        exit();
    }
    mysqli_query($pol, "SET NAMES 'utf8'");

    //czy formularz wysłany?
    if (isset($_POST['nazwa'])){
        $zap = "INSERT INTO stanowiska VALUES (NULL, ".$_POST['dzial'].", '".$_POST['nazwa']."', ".$_POST['stawka'].", ".$_POST['miejsca'].")";
        if (mysqli_query($pol, $zap)){
            $_SESSION['sukces'] = "Dodano nowe stanowisko: ".$_POST['nazwa'];
            header("Location: firma.php");
            exit();
        }
        else{
            $_SESSION['blad'] = "Nie udało się dodać stanowiska. Spróbuj ponownie póżniej";
            header("Location: firma.php");
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
		
        <h1>Kreator tworzenia stanowiska</h1>
        
        <div class="box">
            <form method="post">
                <table>
                    <tr>
                        <td>Dział:</td>
                        <td>
                            <select name="dzial">
                                <?php
                                    //pokazywanie nazw działów
                                    $zap1 = "SELECT * FROM dzialy";
                                    $query1 = mysqli_query($pol, $zap1);
                    
                                    while($w1 = mysqli_fetch_array($query1)){
                                        echo'
                                            <option value="'.$w1['ID'].'">'.$w1['nazwa'].'</option>
                                        ';
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Nazwa:</td>
                        <td><input type="text" name="nazwa"></td>
                    </tr>
                    <tr>
                        <td>Stawka [zł]:</td>
                        <td><input type="number" step="0.01" name="stawka"></td>
                    </tr>
                    <tr>
                        <td>Ilość miejsc:</td>
                        <td><input type="number" name="miejsca"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Dodaj stanowisko"></td>
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