<?php
class Formulaire
{

    public function defInput($type, $name, $value = "")
    {
        if ($value != "" and $type == "submit") {
            ?>
            <input type="<?= $type ?>" name="<?= $name ?>" value="<?= $value ?>">
            <?php
        } else {
            ?>
            <input type="<?= $type ?>" name="<?= $name ?>" required value="<?= $value ?>">
            <?php
        }
    }
    public function defLabel($name, $for)
    {
        ?>
        <label for="<?= $for ?>">
            <?= $name ?> :
        </label>
        <?php
    }
    public function defSelect($name, $options)
    {
        ?>
        <select name="idArticle">
            <option value="">Aucun</option>
            <?php
            while ($option = mysqli_fetch_assoc($options)) {
                ?>
                <option value="<?= $option['idArticle']; ?>">
                    <?= $option['nomArticle']; ?>
                </option>
                <?php
            }
            ?>
        </select>
        <?php
    }

}
class Clients extends Formulaire
{
}
class Produit extends Formulaire
{
}
?>