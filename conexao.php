<?php
// conexao.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "refugio_viajante";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}
?>