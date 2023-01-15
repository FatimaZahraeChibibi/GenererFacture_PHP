<?php
class Client
{
    private $idClient;
    private $nomClient;
    private $adresseClient;
    private $idFactures;

    public function __construct($idClient, $nomClient, $adresseClient, $idFactures)
    {
        $this->idClient = $idClient;
        $this->nomClient = $nomClient;
        $this->adresseClient = $adresseClient;
        $this->idFactures = $idFactures;
    }

    public function AfficherClient()
    {
        return $this->nomClient . "<br>" . "<br>" . $this->adresseClient;
    }



    public function __destruct()
    {
    }


}



class Article
{
    private $idArticle;
    private $nomArticle;
    private $prixArticle;
    private $qtStockArticle;

    function __construct($idArticle, $nomArticle, $prixArticle, $qtStockArticle)
    {
        $this->idArticle = $idArticle;
        $this->nomArticle = $nomArticle;
        $this->prixArticle = $prixArticle;
        $this->qtStockArticle = $qtStockArticle;

    }

    public function AfficherArticle()
    {
        return "<br>" . $this->nomArticle . "<br>" . $this->prixArticle . "<br> Quantité stock :" . $this->qtStockArticle;
    }

}

class Facture
{
    private $idFacture;
    private $idArticles;
    private $qtArticles;
    private $idClient;

    //details
    static $date;
    static $commande;
    static $echeance;
    //calcul

    static $montant;
    static $totalht;
    static $total20;
    static $total;

    //Constants
    const IBAN = "FR12 1234 5678";
    const SWIFT_BIC = "ABCDFRP1XXX";

    /*
    function __construct($idFacture, $idArticles, $qtArticles, $idClient)
    {
    $this->idFacture = $idFacture;
    $this->idArticles = $idArticles;
    $this->qtArticles = $qtArticles;
    $this->idClient = $idClient;
    }
    */


    public static function CalculerFacture($qtArticles, $prixArticle)
    {
        return $qtArticles * $prixArticle;
    }

    /*
    public static function Reclamation($echeance){
    $d1= date("Y-m-d", strtotime($echeance));
    $d2=date("Y-m-d", strtotime("now"));
    return date_diff($d1, $d2); 
    }   */



    static function statutFacture($id_Factures)
    {
        include('Connect.php');

        ?>
        <!DOCTYPE html>

        <head>
            <meta charset="UTF-8">
            <title>Facture</title>
            <link rel="stylesheet" href="style.css">


        </head>

        <body>
            <div class="container">
                <img src="logo.jpg" alt="Logo">
                <h2>facture</h2>
                <div class="Info1">
                    DE
                    <br>

                    <br>
                    Fatiha Benaboud
                    <br><br>
                    Quartier Amak 18 rue Paloma 27900 Ouejda
                </div>
                <div class="Info2">
                    <?php

                    ?>
                    FACTURE N° &nbsp;&nbsp;
                    <?php
                    $id_Factures = rand(1, 10);
                    echo $id_Factures;
                    ?>
                    <br>
                    DATE &nbsp;&nbsp;
                    <?php
                    $date = date("Y/m/d");
                    echo $date;
                    ?>
                    <br>
                    COMMANDE N° &nbsp;&nbsp;
                    <?php
                    $commande = rand(1000, 10000);
                    echo $commande
                        ?>
                    <br>
                    ÉCHÉANCE &nbsp;&nbsp;
                    <?php
                    $echeance = "2023/06/12";
                    echo $echeance;
                    ?>

                </div>
                <div class="Info3">
                    FACTURÉ À
                    <br><br><br>
                    <?php
                    $id_client = rand(1, 70);


                    $v1 = new Client($id_client, $_SESSION['nomClient'], $_SESSION['adresseClient'], $id_Factures);
                    echo $v1->AfficherClient();


                    ?>
                    <br><br>
                </div>
                <div class="Info4">
                    ENVOYÉ À
                    <br><br><br>
                    <?php
                    echo $v1->AfficherClient();
                    ?>
                    <br><br>
                </div>
                <table>
                    <thead>
                        <th>QTÉ</th>
                        <th>DÉSIGNATION</th>
                        <th>PRIX UNIT. HT</th>
                        <th>MONTANT HT</th>
                    </thead>
                    <tbody>
                        <?php
                        $totalht = 0;

                        ?>
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
                                    <?= $_SESSION['articles'][$indice]['quantity']; ?>
                                </td>
                                <td>
                                    <?= $article['nomArticle']; ?>
                                </td>
                                <td>
                                    <?= $article['prixArticle']; ?>
                                </td>

                                <td>
                                    <?= $total = self::CalculerFacture($article['prixArticle'], $_SESSION['articles'][$indice]['quantity']); ?>

                                </td>
                            </tr>

                            <?php
                            $totalht += $total;
                            }
                            ?>




                    </tbody>
                </table>
                <div class="N1">
                    Total HT
                    <?= $totalht; ?>
                    <br><br>
                    TVA 20.0%
                </div>
                <div class="cal">
                    <br>
                    <?= $total20 = $totalht * 0.2 ?>
                </div>
                <div class="tot">
                    TOTAL
                    <div class="f">
                        <?= $total = $total20 + $totalht . ".00 Dh"; ?>
                    </div>
                </div>
        </body>
        <footer>
            CONDITIONS ET MODALITÉS DE PAIEMENT
            <br><br>
            <div class="pied">
                Le paiement est dû dans 15 jours
                <br><br>
                Caisse dEpargne
                <br>
                <?php
                echo Facture::IBAN;
                ?>
                <br>
                <?php
                echo Facture::SWIFT_BIC;
                echo "<br>";

                // echo self::Reclamation($echeance);
        

                ?>
            </div>
        </footer>
        </div>

        </html>
        <?php
    }
}


?>