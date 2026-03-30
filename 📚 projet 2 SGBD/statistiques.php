<?php include("config.php"); ?> <h2>Statistiques</h2>
<h3>Nombre total de livres</h3> <?php $sql = "SELECT COUNT(*) AS total FROM livres";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                echo $row['total']; ?>
<hr>
<h3>Prix moyen des livres</h3> <?php $sql = "SELECT AVG(prix) AS moyenne FROM livres";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                echo $row['moyenne']; ?>
<hr>
<h3>Nombre d’emprunts par étudiant</h3> <?php $sql = "SELECT id_etudiant, COUNT(*) AS nb FROM emprunts GROUP BY id_etudiant";
                                        $result = $conn->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            echo "Etudiant " . $row['id_etudiant'] . " : " . $row['nb'] . " emprunts <br>";
                                        } ?>
<hr>
<h3>Etudiants ayant plus de 1 emprunt</h3> <?php $sql = "SELECT id_etudiant, COUNT(*) AS nb FROM emprunts GROUP BY id_etudiant HAVING COUNT(*) > 1";
                                            $result = $conn->query($sql);
                                            while ($row = $result->fetch_assoc()) {
                                                echo "Etudiant " . $row['id_etudiant'] . " : " . $row['nb'] . " emprunts <br>";
                                            } ?>