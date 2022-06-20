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
        header("Location: firma.php");
        exit();
    }
    mysqli_query($pol, "SET NAMES 'utf8'");

    //sprawdź czy podane id
    if (isset($_GET['id'])) $edytuj_id = $_GET['id'];
    else{
        $_SESSION[blad] = "Nie można edytować stanowiska. Spróbuj ponownie póżniej";
        header("Location: firma.php");
        exit();
    }

    //przenoszenie stanowiska
    if (isset($_POST['dzial'])){
        $zap = "UPDATE stanowiska SET ID_dzial = ".$_POST['dzial']." WHERE ID =".$edytuj_id;
        if (mysqli_query($pol, $zap)){
            $_SESSION['sukces'] = "Przeniesiono stanowisko.";
            header("Location: firma.php");
            exit();
        }
        else{
            $_SESSION['blad'] = "Nie udało się przenieść stanowiska. Spróbuj ponownie póżniej";
            header("Location: firma.php");
            exit();
        }
    }

    //aktualizacja informacji
    if (isset($_POST['nazwa'])){
        $zap = "UPDATE stanowiska SET nazwa = '".$_POST['nazwa']."', stawka = ".$_POST['stawka'].", miejsca = ".$_POST['miejsca']." WHERE ID =".$edytuj_id;
        if (mysqli_query($pol, $zap)){
            $_SESSION['sukces'] = "Zaktualizowano stanowisko stanowisko.";
            header("Location: firma.php");
            exit();
        }
        else{
            $_SESSION['blad'] = "Nie udało się zaktualizować stanowiska. Spróbuj ponownie póżniej";
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
		
        <h1>Aktualizuj stanowisko</h1>
        
        <div class="box">
            <?php
            
                //pobieranie wartości pól z bazy
                $zap1 = "SELECT dzialy.ID AS ID, stanowiska.nazwa AS stanowisko, dzialy.nazwa AS dzial, stawka, miejsca FROM stanowiska JOIN dzialy ON stanowiska.ID_dzial = dzialy.ID WHERE stanowiska.ID = ".$edytuj_id;
                $query1 = mysqli_query($pol, $zap1);
                $w1 = mysqli_fetch_array($query1);
            ?>
            
            <table>
                <form method="post">
                    <tr>
                        <td>Dział:</td>
                        <td>
                            <select name="dzial">
                                <?php    
                                    echo'<option value="'.$w1['ID'].'">'.$w1['dzial'].'</option>';
                                    
                                    //pokazywanie nazw działów
                                    $zap2 = "SELECT * FROM dzialy WHERE ID != ".$w1['ID'];
                                    $query2 = mysqli_query($pol, $zap2);
                    
                                    while($w2 = mysqli_fetch_array($query2)){
                                        echo'
                                            <option value="'.$w2['ID'].'">'.$w2['nazwa'].'</option>
                                        ';
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Przenieś"></td>
                    </tr>
                    <tr><td colspan="2"><hr></td></tr>
                </form>
            
                <form method="post">
                    <tr>
                        <td>Nazwa:</td>
                        <td><input type="text" name="nazwa" value="<?php echo $w1['stanowisko']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Stawka [zł]:</td>
                        <td><input type="number" step="0.01" name="stawka" value="<?php echo $w1['stawka']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Ilość miejsc:</td>
                        <td><input type="number" name="miejsca" value="<?php echo $w1['miejsca']; ?>"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Aktualizuj stanowisko"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="button" value="Usun stanowisko" onclick="location.href='usunstanowisko.php?id=<?php echo $edytuj_id; ?>'" style="background-color: #dc524c;"></td>
                    </tr>
                </form>
            </table>
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