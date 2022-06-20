<?php

//pokaz statystyki
function statystyka(){
    //To be continue
}

if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == true && $_SESSION['admin'] == true){
//uzytkownik - admin
    echo'
    <div class="top-bar">
		<div class="logo">Znajdź zatrudnienie w naszej firmie</div>
        <div class="stats">Zarządarz stroną jako <b>Administrator ['.$_SESSION['imie'].' '.$_SESSION['nazwisko'].']</b></div>
        <div class="menu">
			<div class="menu-frame">
            
				<a href="/PROJEKT/index.php"><div class="button"><i class="fas fa-bullhorn"></i> Oferty </div></a>
                
				<a href="/PROJEKT/admin/podania.php"><div class="button"><i class="fas fa-id-card"></i> Podania </div></a>
                
				<a href="/PROJEKT/admin/pracownicy.php"><div class="button"><i class="fas fa-briefcase"></i> Pracownicy </div></a>
                
				<a href="/PROJEKT/admin/firma.php"><div class="button"><i class="fas fa-building"></i> Firma </div></a>
                
				<a href="/PROJEKT/admin/uzytkownicy.php"><div class="button"><i class="fas fa-users"></i> Użytkownicy </div></a>
                
                <a href="/PROJEKT/skrypty/logout.php"><div class="button"><i class="fas fa-sign-out-alt"></i> Wyloguj </div></a>
                
			</div>
		</div>
	</div>
    ';
}
else if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == true){
//uzytkownik zwykly
    echo'
    <div class="top-bar">
		<div class="logo">Znajdź zatrudnienie w naszej firmie</div>
        <div class="stats">Zalogowano jako: <b>'.$_SESSION['imie'].' '.$_SESSION['nazwisko'].'</b></div>
        <div class="menu">
			<div class="menu-frame">
            
				<a href="/PROJEKT/index.php"><div class="button"><i class="fas fa-bullhorn"></i> &nbsp; Aktualne oferty </div></a>
                
				<a href="/PROJEKT/mojepodania.php"><div class="button"><i class="fas fa-paste"></i> &nbsp; Moje podania </div></a>
                
				<a href="/PROJEKT/mojekonto.php"><div class="button"><i class="fas fa-user"></i> &nbsp; Moje konto </div></a>
                
				<a href="/PROJEKT/skrypty/logout.php"><div class="button"><i class="fas fa-sign-out-alt"></i> &nbsp; Wyloguj </div></a>
                
			</div>
		</div>
	</div>
    ';
}
else{
//niezalogowany - tworzenie statystyki
    
    //łączenie z bazą
    require_once "config/database.php";
    $pol = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    mysqli_query($pol, "SET NAMES 'utf8'");
    
    //bopieranie danych
    $k1 = "SELECT COUNT(licz) AS liczba FROM (SELECT ID AS licz FROM pracownicy GROUP BY UID) tab";
    $k2 = "SELECT COUNT(licz) AS liczba FROM (SELECT ID AS licz FROM pracownicy GROUP BY ID_stanowiska) tab";
    
    $q1 = mysqli_query($pol, $k1);
    $q2 = mysqli_query($pol, $k2);
    
    $pracownicy = mysqli_fetch_array($q1);
    $stanowiska = mysqli_fetch_array($q2);
    
    //zamykanie połączenia
    mysqli_close($pol);
    
//niezalogowany
    echo'
    <div class="top-bar">
		<div class="logo">Znajdź zatrudnienie w naszej firmie</div>
        <div class="stats">Zrekrutowaliśmy już łącznie <b>'.$pracownicy['liczba'].'</b> pracowników na <b>'.$stanowiska['liczba'].'</b> różnych stanowiskach!</div>
        <div class="menu">
			<div class="menu-frame">
            
				<a href="/PROJEKT/index.php"><div class="button"><i class="fas fa-bullhorn"></i> &nbsp; Aktualne oferty </div></a>
				
				<a href="/PROJEKT/logowanie.php"><div class="button"><i class="fas fa-sign-in-alt"></i> &nbsp; Logowanie </div></a>
				
				<a href="/PROJEKT/rejestracja.php"><div class="button"><i class="fas fa-user-plus"></i> &nbsp; Rejestracja </div></a>
                
			</div>
		</div>
	</div>
    ';
}
?>