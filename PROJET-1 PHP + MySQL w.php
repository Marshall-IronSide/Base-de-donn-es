<?php

/*************************************************
MINI APPLICATION PHP + MariaDB (CRUD + DDL)
Auteur : Junior GODEVI (exemple pédagogique)
 **************************************************/
// CONFIGURATION
$host = "localhost";
$port = 3377;
$dbname = "gestion_vente";
$user = "root";
$pass = getenv('DB_PASSWORD') ?: '';  // Set DB_PASSWORD environment variable
try {
    $pdo = new PDO("mysql:host=$host;port=$port", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur connexion : " . $e->getMessage());
}
/*************************************************
CREATION BASE DE DONNEES
 **************************************************/
$pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
$pdo->exec("USE $dbname");
/*************************************************
CREATION TABLE CLIENT
 **************************************************/
$pdo->exec("CREATE TABLE IF NOT EXISTS client (
id_client INT AUTO_INCREMENT PRIMARY KEY,
nom VARCHAR(50) NOT NULL,
prenom VARCHAR(50) NOT NULL,
email VARCHAR(100) UNIQUE,
telephone VARCHAR(20) NOT NULL,
date_inscrip DATE NOT NULL
)");
/*************************************************
CREATION TABLE COMMANDE
 **************************************************/
$pdo->exec("CREATE TABLE IF NOT EXISTS commande (
id_commande INT AUTO_INCREMENT PRIMARY KEY,
date_cmd DATE NOT NULL,
montant DECIMAL(10,2) NOT NULL CHECK (montant > 0),
id_client INT,
FOREIGN KEY (id_client) REFERENCES client(id_client)
)");
/*************************************************
ALTER TABLE (AJOUT COLONNE)
 **************************************************/
try {
    $pdo->exec("ALTER TABLE client ADD adresse VARCHAR(100)");
} catch (Exception $e) {
}
/*************************************************
INSERTION CLIENT
 **************************************************/
if (isset($_POST['ajouter'])) {
    $sql = "INSERT INTO client(nom,prenom,email,telephone,date_inscrip,adresse)
VALUES (?,?,?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['email'],
        $_POST['telephone'],
        $_POST['date'],
        $_POST['adresse']
    ]);
}
/*************************************************
SUPPRESSION
 **************************************************/
if (isset($_GET['supprimer'])) {
    $id = $_GET['supprimer'];
    $pdo->exec("DELETE FROM client WHERE id_client=$id");
}
/*************************************************
MODIFICATION
 **************************************************/
if (isset($_POST['modifier'])) {
    $sql = "UPDATE client SET
nom=?, prenom=?, email=?, telephone=?, adresse=?
WHERE id_client=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['email'],
        $_POST['telephone'],
        $_POST['adresse'],
        $_POST['id']
    ]);
}
/*************************************************
RECUPERATION DONNEES
 **************************************************/
$clients = $pdo->query("SELECT * FROM client")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Vente - Clients</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 30px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            color: white;
            margin-bottom: 10px;
            font-size: 2.5em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .subtitle {
            text-align: center;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 30px;
            font-size: 1.1em;
        }

        form {
            background: white;
            padding: 30px;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        form h3 {
            color: #667eea;
            margin-bottom: 20px;
            font-size: 1.5em;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .form-grid input[type="hidden"] {
            display: none;
        }

        input {
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 1em;
            transition: all 0.3s ease;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        input[type="date"] {
            grid-column: auto;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        button {
            padding: 12px 30px;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            flex: 1;
        }

        button[name="ajouter"] {
            background: #4C63D2;
            color: white;
        }

        button[name="ajouter"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 99, 210, 0.4);
        }

        button[name="modifier"] {
            background: #4C63D2;
            color: white;
        }

        button[name="modifier"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 99, 210, 0.4);
        }

        .table-wrapper {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #4C63D2;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 1em;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        tr:hover {
            background: #f8f9ff;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        a {
            color: white;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 4px;
            font-size: 0.85em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-block;
            border: none;
        }

        a:first-child {
            background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
        }

        a:first-child:hover {
            box-shadow: 0 4px 12px rgba(245, 87, 108, 0.4);
            transform: translateY(-2px);
        }

        a:last-child {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        a:last-child:hover {
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            transform: translateY(-2px);
        }

        .no-data {
            text-align: center;
            color: #999;
            padding: 40px;
            font-size: 1.1em;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2em;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .button-group {
                flex-direction: column;
            }

            table {
                font-size: 0.9em;
            }

            th, td {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>📊 Gestion Vente</h1>
        <p class="subtitle">Gestionnaire professionnel de clients et commandes</p>

        <!-- FORMULAIRE -->
        <form method="POST">
            <h3>➕ Ajouter / Modifier Client</h3>
            <input type="hidden" name="id" id="id">
            <div class="form-grid">
                <input type="text" name="nom" id="nom" placeholder="Nom" required>
                <input type="text" name="prenom" id="prenom" placeholder="Prénom" required>
                <input type="email" name="email" id="email" placeholder="Email">
                <input type="text" name="telephone" id="telephone" placeholder="Téléphone" required>
                <input type="date" name="date" required>
                <input type="text" name="adresse" id="adresse" placeholder="Adresse">
            </div>
            <div class="button-group">
                <button type="submit" name="ajouter">✅ Ajouter Client</button>
                <button type="submit" name="modifier">🔄 Modifier Client</button>
            </div>
        </form>

        <!-- LISTE CLIENTS -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Adresse</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($clients) > 0): ?>
                        <?php foreach ($clients as $c): ?>
                            <tr>
                                <td><?= $c['id_client'] ?? '' ?></td>
                                <td><?= $c['nom'] ?? '' ?></td>
                                <td><?= $c['prenom'] ?? '' ?></td>
                                <td><?= $c['email'] ?? '' ?></td>
                                <td><?= $c['telephone'] ?? '' ?></td>
                                <td><?= $c['adresse'] ?? '' ?></td>
                                <td>
                                    <div class="actions">
                                        <a href="?supprimer=<?= $c['id_client'] ?? '' ?>" onclick="return confirm('Êtes-vous sûr ?')">🗑️ Supprimer</a>
                                        <a href="#" onclick="remplir('<?= $c['id_client'] ?? '' ?>','<?= addslashes($c['nom'] ?? '') ?>','<?= addslashes($c['prenom'] ?? '') ?>','<?= addslashes($c['email'] ?? '') ?>','<?= addslashes($c['telephone'] ?? '') ?>','<?= addslashes($c['adresse'] ?? '') ?>'); return false;">✏️ Modifier</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="no-data">Aucun client enregistré</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function remplir(id, nom, prenom, email, tel, adr) {
            document.getElementById('id').value = id;
            document.getElementById('nom').value = nom;
            document.getElementById('prenom').value = prenom;
            document.getElementById('email').value = email;
            document.getElementById('telephone').value = tel;
            document.getElementById('adresse').value = adr;
        }
    </script>
</body>

</html>