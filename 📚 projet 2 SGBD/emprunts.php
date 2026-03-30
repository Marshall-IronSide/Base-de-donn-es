<?php include("config.php");
$sql = "SELECT etudiants.nom, livres.titre, emprunts.date_emprunt FROM emprunts INNER JOIN etudiants ON emprunts.id_etudiant = etudiants.id_etudiant INNER JOIN livres ON emprunts.id_livre = livres.id_livre";
$result = $conn->query($sql); ?> <h2>Liste des emprunts</h2>
<table border="1">
    <tr>
        <th>Etudiant</th>
        <th>Livre</th>
        <th>Date</th>
    </tr> <?php while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['nom'] . "</td>";
                echo "<td>" . $row['titre'] . "</td>";
                echo "<td>" . $row['date_emprunt'] . "</td>";
                echo "</tr>";
            } ?>
</table>