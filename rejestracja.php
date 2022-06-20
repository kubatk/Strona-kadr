<?php
    session_start();

    //sprawdzanie czy uzytkownik juz zalogowany
    if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == true){
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
		
        <h1>Rejestracja w systemie:</h1>
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
        
        <div class="box">
            <form method="post" action="skrypty/register.php">
                <table>
                    <tr>
                        <td>Imię:</td>
                        <td><input type="text" name="imie"></td>
                    </tr>
                    <tr>
                        <td>Nazwisko:</td>
                        <td><input type="text" name="nazwisko"></td>
                    </tr>
                    <tr>
                        <td>Data urodzenia:</td>
                        <td><input type="date" name="dataurodzenia"></td>
                    </tr>
                    <tr>
                        <td>Płeć:</td>
                        <td>
                            <select name="plec">
                                <option value="m">mężczyzna</option>
                                <option value="k">kobieta</option>
                            </select>
                        </td>
                    </tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr>
                        <td>E-mail:</td>
                        <td><input type="text" name="email"></td>
                    </tr>
                    <tr>
                        <td>Nr telefonu:</td>
                        <td><input type="text" name="telefon"></td>
                    </tr>
                    <tr>
                        <td>Miasto:</td>
                        <td><input type="text" name="miasto"></td>
                    </tr>
                    <tr>
                        <td>Adres:</td>
                        <td><input type="text" name="adres"></td>
                    </tr>
                    <tr>
                        <td>Poczta:</td>
                        <td><input type="text" name="poczta"></td>
                    </tr>
                    <tr>
                        <td>Kod pocztowy:</td>
                        <td><input type="text" name="kod"></td>
                    </tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr>
                        <td>Hasło:</td>
                        <td><input type="password" name="haslo"></td>
                    </tr>
                    <tr>
                        <td>Powtórz hasło:</td>
                        <td><input type="password" name="haslo2"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            <label style="font-size: 20px;">
                                <input type="checkbox" name="regulamin">
                                Wyrażam zgodę na przetwarzanie danych osobowych
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Utwórz konto!"></td>
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