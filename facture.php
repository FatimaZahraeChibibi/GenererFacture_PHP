<?php
include 'index.php';
include 'connect.php';
include 'config.php';
//$idClient=$_GET['idClient'];

$sql = "SELECT DISTINCT * FROM client NATURAL JOIN facture NATURAL JOIN article;";
$r = $conn->query($sql);
if ($r->num_rows > 0) {
  while ($row = $r->fetch_assoc()) {
    $articles = mysqli_query($conn, $sql);
  }
}


$commande = mysqli_query($conn, $sql);
if (isset($_SESSION['articles']))
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Facture</title>
</head>

<body>
  <?php
  $facture = new Facture();
  echo $facture->statutFacture($commande);
  ?>
</body>

</html>