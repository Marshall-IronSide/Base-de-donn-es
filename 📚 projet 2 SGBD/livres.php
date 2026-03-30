<?php include("config.php");
$sql = "SELECT * FROM livres ORDER BY prix DESC";
$result = $conn->query($sql); ?> <h2>Liste des livres (triés par prix)</h2>
<table border="1">
    <tr>
        <th>Titre</th>
        <th>Auteur</th>
        <th>Catégorie</th>
        <th>Prix</th>
    </tr> <?php while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['titre'] . "</td>";
                echo "<td>" . $row['auteur'] . "</td>";
                echo "<td>" . $row['categorie'] . "</td>";
                echo "<td>" . $row['prix'] . "</td>";
                echo "</tr>";
            } ?>
</table>