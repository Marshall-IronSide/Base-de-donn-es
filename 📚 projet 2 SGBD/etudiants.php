<?php include("config.php");
$sql = "SELECT * FROM etudiants";
$result = $conn->query($sql); ?> <h2>Liste des étudiants</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Filière</th>
    </tr> <?php while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id_etudiant'] . "</td>";
                echo "<td>" . $row['nom'] . "</td>";
                echo "<td>" . $row['prenom'] . "</td>";
                echo "<td>" . $row['filiere'] . "</td>";
                echo "</tr>";
            } ?>
</table>