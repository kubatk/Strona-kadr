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
    
    //uzyskaj id do edycji
    if (isset($_GET['id'])){
        $edytuj_id = $_GET['id'];
    }
    else{
        $_SESSION['blad'] = "Nie można edytować ogłoszenia. Spróbuj ponownie później.";
        header('Location: ../index.php');
        exit();
    }
    
    //update oferty
    if (isset($_POST['opis'])){
        $zap = "UPDATE ogloszenia SET opis = '".$_POST['opis']."', wymagania = '".$_POST['wymagania']."' WHERE ID = ".$edytuj_id;
        if (mysqli_query($pol, $zap)){
            $_SESSION['sukces'] = "Pomyślnie zapisano zmiany";
            unset($_POST['opis']);
        }
        else{
            $_SESSION['blad'] = "Nie udało się edytować ogłoszenia. Spróbuj ponownie póżniej";
            unset($_POST['opis']);
        }
    }

    //usuniecie oferty
    if (isset($_POST['usun'])){
        $zap = "DELETE FROM ogloszenia WHERE ID = ".$edytuj_id;
        if (mysqli_query($pol, $zap)){
            
            $_SESSION['sukces'] = "Usunięto ogłoszenie!";
            header("Location: ../index.php");
            exit();
        }
        else{
            $_SESSION['blad'] = "Wystąpił błąd przy usuwaniu!";
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
    
    <!-- menu -->
    <?php include "../skrypty/menu.php"; ?>

    
    <div class="content">

        <h1>Edycja oferty pracy</h1>
        
        <?php
        
            if (isset($_SESSION['blad'])){    
                echo '<h2 style="color: red;">'.$_SESSION['blad'].'</h2>';
                unset($_SESSION['blad']);
            }
            if (isset($_SESSION['sukces'])){    
                echo '<h2 style="color: green;">'.$_SESSION['sukces'].'</h2>';
                unset($_SESSION['sukces']);
            }
        
            
            //pobranie oferty
            $zap2 = "SELECT ogloszenia.ID AS ID, dzialy.nazwa AS dzial, stanowiska.nazwa AS stanowisko, stanowiska.stawka, ogloszenia.opis, ogloszenia.wymagania FROM ogloszenia, stanowiska, dzialy WHERE ogloszenia.ID_stanowiska = stanowiska.ID AND stanowiska.ID_dzial = dzialy.ID AND ogloszenia.ID = ".$edytuj_id;
            $query2 = mysqli_query($pol, $zap2);
            $oferta = mysqli_fetch_array($query2);
        ?>
        <div class="box">
            <form method="post">
                <table>
                    <tr>
                        <td>Stanowisko:</td>
                        <td>
                            <select disabled style="width: 610px;">
                                <option><?php echo $oferta['dzial'].": ".$oferta['stanowisko']; ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span style="color: darkred; font-weight: bold; font-size: 18px;">Tego parametru nie można edytować</span></td>
                    </tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr>
                        <td>Opis:</td>
                        <td><textarea name="opis" rows="25" cols="60" style="font-size: 18px;"><?php echo $oferta['opis'] ?></textarea></td>
                    </tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr>
                        <td>Stawka:</td>
                        <td><input type="number" value="<?php echo $oferta['stawka']; ?>" disabled> zł</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span style="color: darkred; font-weight: bold; font-size: 18px;">Tego parametru nie można edytować. Ustawienie narzucone przez stanowisko</span></td>
                    </tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr>
                        <td>Wymagania:</td>
                        <td><textarea name="wymagania" rows="10" cols="60" style="font-size: 18px;" placeholder="Wymagania oddziel znakiem ';'"><?php echo $oferta['wymagania'] ?></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" style="float: right;" value="Aktualizuj dane">
                            <input title="Ta czynność jest nieodwracalna!" type="submit" style="float: right; background-color: #dc524c;" value="Usuń ofertę" name="usun">
                        </td>
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