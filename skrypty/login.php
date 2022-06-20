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

//instrukcje gdy błąd
function blad($tekst){
    $_SESSION['blad'] = $tekst;
    header("Location: ../logowanie.php");
    exit();
}

//pobieranie pól z formularza i sprawdzanie czy są uzupełnione

if (isset($_POST['mail'])) $email = $_POST['mail'];
else blad("Wypełnij wszystkie pola formularza");

if (isset($_POST['haslo'])) $haslo = $_POST['haslo'];
else blad("Wypełnij wszystkie pola formularza");

//sprawdzenie poprawnosci adresu e-mail

$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
{
    blad("Podaj poprawny adres e-mail!");
}

//pobieranie danych uzytkownika powiazanych z mailem
$zap = "SELECT * FROM uzytkownicy WHERE email = '$email'";
$query = mysqli_query($pol, $zap);

if (mysqli_num_rows($query) == 1){
    //jest konto
    //pobranie hasla z bazy
    $wynik = mysqli_fetch_array($query);
    $hash = $wynik['haslo'];
    
    //sprawdzanie poprawnosci hasla korzystajac z wbudowanej funkcji porownywania hasla do hasha
    if (password_verify($haslo, $hash)){
        //wpisanie uzytkownika w sesje
        $_SESSION['email'] = $email;
        $_SESSION['UID'] = $wynik['UID'];
        $_SESSION['admin'] = $wynik['admin'];
        $_SESSION['zalogowany'] = true;
        
        //pobranie danych osobowych do sesji
        $zap = "SELECT * FROM daneosobowe WHERE UID = ".$wynik['UID'];
        $query = mysqli_query($pol, $zap);
        $dane = mysqli_fetch_array($query);
        
        $_SESSION['imie'] = $dane['imie'];
        $_SESSION['nazwisko'] = $dane['nazwisko'];
        $_SESSION['data_ur'] = $dane['data_ur'];
        $_SESSION['plec'] = $dane['plec'];
        $_SESSION['tel'] = $dane['tel'];
        $_SESSION['miasto'] = $dane['miasto'];
        $_SESSION['adres'] = $dane['adres'];
        $_SESSION['poczta'] = $dane['poczta'];
        $_SESSION['kod_pocztowy'] = $dane['kod_pocztowy'];
        
        //przekierowanie koncowe
        header("Location: ../index.php");
        exit();
    }
    else{
        blad("Błędne dane logowania!");
    }
    
}
else{
    //brak uzytkownika w bazie
    blad("Błędne dane logowania!");
}

//zamknięcie połączenia z bazą
mysqli_close($pol);

?>