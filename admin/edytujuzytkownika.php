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
        header("Location: uzytkownicy.php");
        exit();
    }
    mysqli_query($pol, "SET NAMES 'utf8'");

    //sprawdź czy podane id
    if (isset($_GET['uid'])) $edytuj_id = $_GET['uid'];
    else{
        $_SESSION[blad] = "Nie można edytować użytkownika. Spróbuj ponownie póżniej";
        header("Location: uzytkownicy.php");
        exit();
    }

    //update maila
    //czy formularz wysłany?
    if (isset($_POST['mail'])){
        $email = $_POST['email'];
        
        $zap1 = "UPDATE uzytkownicy SET email = '$email' WHERE UID = ".$edytuj_id;
        if (mysqli_query($pol, $zap1)){
            $_SESSION['sukces'] = "Zmieniono adres email.";
            header("Location: uzytkownicy.php");
            exit();
        }
        else{
            $_SESSION['blad'] = "Wystąpił błąd przy zmianie danych. Spróbuj ponownie później";
            header("Location: uzytkownicy.php");
            exit();
        }
    }

    //udate danych
    //czy formularz wysłany?
    if (isset($_POST['dane'])){
        
        $imie = $_POST['imie'];
        $nazwisko = $_POST['nazwisko'];
        $dataurodzenia = $_POST['dataurodzenia'];
        $plec = $_POST['plec'];
        $telefon = $_POST['telefon'];
        $miasto = $_POST['miasto'];
        $adres = $_POST['adres'];
        $poczta = $_POST['poczta'];
        $kod = $_POST['kod'];
        
        $zap1 = "UPDATE daneosobowe SET imie = '$imie', nazwisko = '$nazwisko', data_ur = '$dataurodzenia', plec = '$plec', tel = '$telefon', miasto = '$miasto', adres = '$adres', poczta = '$poczta', kod_pocztowy = '$kod' WHERE UID = ".$edytuj_id;
        if (mysqli_query($pol, $zap1)){
            $_SESSION['sukces'] = "Zmieniono dane użytkownika.";
            header("Location: uzytkownicy.php");
            exit();
        }
        else{
            $_SESSION['blad'] = "Wystąpił błąd przy zmianie danych. Spróbuj ponownie później";
            header("Location: uzytkownicy.php");
            exit();
        }
    }
        
        
    //pobranie aktualnych danych.
    
    $zap2 = "SELECT * FROM uzytkownicy JOIN daneosobowe ON uzytkownicy.UID = daneosobowe.UID WHERE uzytkownicy.UID = ".$edytuj_id;
    $query2 = mysqli_query($pol, $zap2);
    
    $dane = mysqli_fetch_array($query2);

    //zamknięcie połączenia
    mysqli_close($pol);
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
		
        <h1>Edycja danych użytkownika</h1>
        
        <div class="box">
            <form method="post">
                <table>
                    <tr>
                        <td>E-mail:</td>
                        <td><input type="text" name="email" value="<?php echo $dane['email']; ?>"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Zmień e-mail" name="mail"></td>
                    </tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr>
                        <td>Imię:</td>
                        <td><input type="text" name="imie" value="<?php echo $dane['imie']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Nazwisko:</td>
                        <td><input type="text" name="nazwisko" value="<?php echo $dane['nazwisko']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Data urodzenia:</td>
                        <td><input type="date" name="dataurodzenia" value="<?php echo $dane['data_ur']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Płeć:</td>
                        <td>
                            <select name="plec">
                                <?php
                                    if ($dane['plec'] == 'm')
                                        echo'
                                    <option value="m">mężczyzna</option>
                                    <option value="k">kobieta</option>
                                        ';
                                    else
                                        echo'
                                    <option value="k">kobieta</option>
                                    <option value="m">mężczyzna</option>
                                        ';
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Nr telefonu:</td>
                        <td><input type="text" name="telefon" value="<?php echo $dane['tel']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Miasto:</td>
                        <td><input type="text" name="miasto" value="<?php echo $dane['miasto']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Adres:</td>
                        <td><input type="text" name="adres" value="<?php echo $dane['adres']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Poczta:</td>
                        <td><input type="text" name="poczta" value="<?php echo $dane['poczta']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Kod pocztowy:</td>
                        <td><input type="text" name="kod" value="<?php echo $dane['kod_pocztowy']; ?>"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Zmień dane" name="dane"></td>
                    </tr>
                </table>
            </form>
        </div>
            
             
	</div>
    
    <div class="footer">
        <div class="footer-content">Projekt wykonał: Jakub Trzciński</div>
    </div>
</body>
</html>