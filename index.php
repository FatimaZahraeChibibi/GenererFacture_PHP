<?php
include('connect.php');
session_start();
include('formulaire.php');

if (isset($_SESSION['articles']))
	$indiceArticles = count($_SESSION['articles']);
else
	$indiceArticles = 0;

if (isset($_POST['ajouterArticle'])) {
	$_SESSION['articles'][$indiceArticles]['idArticle'] = $_POST['idArticle'];
	$_SESSION['articles'][$indiceArticles]['quantity'] = $_POST['quantity'];
	$_SESSION['nomClient'] = $_POST['nomClient'];
	$_SESSION['adresseClient'] = $_POST['adresseClient'];
} else
	$idArticle = "";
if (isset($_GET['supprimerArticle'])) {
	$indiceSupprimer = $_GET['supprimerArticle'];
	array_splice($_SESSION['articles'], $indiceSupprimer, 1);
}
?>
<!doctype html>
<html lang="en">

<head>
	<title>Formulaire d'achats</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="nofollow"
		integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
	<section>

		<h2>
			Remplir les champs s'il vous plaît
		</h2>

		<form action="index.php" method="post">
			<div class="form-group">
				<?php
				if (isset($_SESSION['nomClient'])) {
					//modifier nom adresse
					$valueNom = $_SESSION['nomClient'];
					$valueAdresse = $_SESSION['adresseClient'];
				} else {
					$valueNom = "";
					$valueAdresse = "";
				}
				$client = new Clients();
				?>
			</div>
			<div class="exampleFormControlInput1" ;>
				<?php
				$client->defLabel("Nom Client ", "nomClient");
				$client->defInput("text", "nomClient", $valueNom);
				echo "<br><br>";
				?>
			</div>

			<div class="exampleFormControlInput1">
				<?php
				$client->defLabel("Adresse Client ", "adresseClient");
				$client->defInput("text", "adresseClient", $valueAdresse);
				echo "<br><br>";
				?>
			</div>
			<?php
			$sql = "SELECT *
			FROM article";
			$r = $conn->query($sql);
			if ($r->num_rows > 0) {
				while ($row = $r->fetch_assoc()) {
					$articles = mysqli_query($conn, $sql);
				}
			}
			?>
			<?php
			$articleObject = new Produit();
			?>
			<div class="exampleFormControlSelect1" ;>
				<?php
				$client->defLabel("Produit", "produit");
				$articleObject->defSelect("idArticle", $articles);
				echo "<br><br>";

				?>
			</div>
			<div class="exampleFormControlInput1">
				<?php
				$client->defLabel("Quantité", "quantity");
				$articleObject->defInput("number", "quantity");
				echo "<br><br>";

				?>
			</div>
			<?php
			$articleObject->defInput("submit", "ajouterArticle", "Ajouter");
			?>
			<?php
			echo "<br><br>";

			?>

		</form>
		<table class="table">
			<?php
			if (isset($_SESSION['articles'])) {
				?>
				<thead>
					<tr>
						<th scope="col">Produits</th>
						<th scope="col">Prix</th>
						<th scope="col">Quantité</th>
						<th scope="col">Total</th>
						<th scope="col">Supprimer</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<?php
						for ($indice = 0; $indice < count($_SESSION['articles']); $indice++) {
							$idArticle = $_SESSION['articles'][$indice]['idArticle'];

							$sql_1 = "SELECT *
								FROM article
								WHERE idArticle=$idArticle;";
							$r_1 = $conn->query($sql_1);
							if ($r_1->num_rows > 0) {
								while ($row = $r_1->fetch_assoc()) {
									$articles = mysqli_query($conn, $sql_1);
								}
							}





							$infosArticle = mysqli_query($conn, $sql_1);
							$article = mysqli_fetch_assoc($infosArticle);
							?>
							<td>
								<?= $article['nomArticle']; ?>
							</td>
							<td>
								<?= $article['prixArticle']; ?>
							</td>
							<td>
								<?= $_SESSION['articles'][$indice]['quantity']; ?>
							</td>
							<td>
								<?= $article['prixArticle'] * $_SESSION['articles'][$indice]['quantity']; ?>
							</td>
							<td class="btn btn-danger">
								<a href="?supprimerArticle=<?= $indice; ?>">Supprimer</a>
							</td>
						</tr>

					<?php
						}
						?>

				<?php
			}
			?>
			</tbody>
		</table>
		<form action="facture.php" method="post">
			<?php
			$articleObject->defInput("submit", "confirmerFacture", "Confirmer");
			?>

		</form>

	</section>
</body>

</html>