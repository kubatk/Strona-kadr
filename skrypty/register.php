<?php
session_start();

//sprawdzanie czy uzytkownik juz zalogowany
if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == true){
    header("Location: ../index.php");
    exit();
}

//łączenie z bazą
require_once "../config/database.php";
if (!$pol = mysqli_connect($db_host, $db_user, $db_pass, $db_name)) blad("Błąd połączenia z bazą. Spróbuj ponownie póżniej.");
mysqli_query($pol, "SET NAMES 'utf8'");

//instukcje gdy błąd
function blad($tekst){
    $_SESSION['blad'] = $tekst;
    header("Location: ../rejestracja.php");
    exit();
}


//sprawdzenie czy wszytko zdefiniowane i przypisanie do zmiennych
if (isset($_POST['imie']) && $_POST['imie']!="") $imie = $_POST['imie'];
else blad("Uzupełnij wszystkie pola formularza!");

if (isset($_POST['nazwisko']) && $_POST['nazwisko']!="") $nazwisko = $_POST['nazwisko'];
else blad("Uzupełnij wszystkie pola formularza!");

if (isset($_POST['dataurodzenia']) && $_POST['dataurodzenia']!="") $dataurodzenia = $_POST['dataurodzenia'];
else blad("Uzupełnij wszystkie pola formularza!");

$plec = $_POST['plec'];

if (isset($_POST['email']) && $_POST['email']!="") $email = $_POST['email'];
else blad("Uzupełnij wszystkie pola formularza!");

if (isset($_POST['telefon']) && $_POST['telefon']!="") $telefon = $_POST['telefon'];
else blad("Uzupełnij wszystkie pola formularza!");

if (isset($_POST['miasto']) && $_POST['miasto']!="") $miasto = $_POST['miasto'];
else blad("Uzupełnij wszystkie pola formularza!");

if (isset($_POST['adres']) && $_POST['adres']!="") $adres = $_POST['adres'];
else blad("Uzupełnij wszystkie pola formularza!");

if (isset($_POST['poczta']) && $_POST['poczta']!="") $poczta = $_POST['poczta'];
else blad("Uzupełnij wszystkie pola formularza!");

if (isset($_POST['kod']) && $_POST['kod']!="") $kod = $_POST['kod'];
else blad("Uzupełnij wszystkie pola formularza!");

if (isset($_POST['haslo']) && $_POST['haslo']!="") $haslo1 = $_POST['haslo'];
else blad("Uzupełnij wszystkie pola formularza!");

if (isset($_POST['haslo2']) && $_POST['haslo2']!="") $haslo2 = $_POST['haslo2'];
else blad("Uzupełnij wszystkie pola formularza!");

if (!isset($_POST['regulamin'])){
    blad("Musisz wyrazić zgodę na przetwarzanie danych osobowych!");
}

//sprawdzenie poprawnosci adresu e-mail

$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
{
    blad("Podaj poprawny adres e-mail!");
}
else{
    $zap = "SELECT email FROM uzytkownicy WHERE email = '$email'";
    $query = mysqli_query($pol, $zap);
    if (mysqli_num_rows($query)!=0){
        blad("Podany mail jest już zajęty!");
    }
}

//sprawdzanie poprawnosci numeru telefonu

if (!preg_match('/^[0-9]{9}$/',$telefon)){
    blad("Podaj poprawny numer telefonu!");
}

//sprawdzanie poprawnosci kodu pocztowego

if (!preg_match('/^[0-9]{2}-{1}[0-9]{3}$/',$kod)){
    blad("Podaj poprawny kod pocztowy!");
}

//sprawdzanie poprawnosci hasła

if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
{
	blad("Hasło musi posiadać od 8 do 20 znaków!");
}
	
if ($haslo1!=$haslo2)
{
	blad("Podane hasła nie są identyczne!");
}

//hashowanie hasła
$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

//tworzenie uzytkownika w bazie

$zap = "INSERT INTO uzytkownicy VALUES (NULL, '$email', '$haslo_hash', 0)";

if(mysqli_multi_query($pol, $zap)){
    
    $zap2 = "INSERT INTO daneosobowe VALUES (NULL, (SELECT LAST_INSERT_ID() AS id), '$imie', '$nazwisko', '$dataurodzenia', '$plec', '$telefon', '$miasto', '$adres', '$poczta', '$kod')";
    if (mysqli_query($pol, $zap2)){
        $_SESSION['sukces'] = "Pomyślnie utworzono konto. Możesz się już zalogować ;)";
        header("Location: ../rejestracja.php");
        exit();
    }
    else{
        blad("Błąd przy tworzeniu użytkownika. Spróbuj ponownie później");
    }
}
else{
    blad("Błąd przy tworzeniu użytkownika. Spróbuj ponownie później");
}

mysqli_close($pol);

?>