<?php

/*************************************************
APPLICATION PHP AVANCÉE : LOGIN + CLIENTS + COMMANDES
 **************************************************/
session_start();
// CONFIG
$host = "localhost";
$port = 3377;
$dbname = "gestion_vente_plus";
$user = "root";
$pass = getenv('DB_PASSWORD') ?: '';
try {
    $pdo = new PDO("mysql:host=$host;port=$port", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur connexion : " . $e->getMessage());
}
/*********************
CREATION BASE
 *********************/
$pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
$pdo->exec("USE $dbname");
/*********************
TABLE USERS
 *********************/
$pdo->exec("CREATE TABLE IF NOT EXISTS users(
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(50) UNIQUE NOT NULL,
password VARCHAR(255) NOT NULL,
role ENUM('admin','user') DEFAULT 'user'
)");
/*********************
TABLE CLIENT
 *********************/
$pdo->exec("CREATE TABLE IF NOT EXISTS client(
id_client INT AUTO_INCREMENT PRIMARY KEY,
nom VARCHAR(50) NOT NULL,
prenom VARCHAR(50) NOT NULL,
email VARCHAR(100) UNIQUE,
telephone VARCHAR(20) NOT NULL,
adresse VARCHAR(100),
date_inscrip DATE NOT NULL
)");
/*********************
TABLE COMMANDE
 *********************/
$pdo->exec("CREATE TABLE IF NOT EXISTS commande(
id_commande INT AUTO_INCREMENT PRIMARY KEY,
date_cmd DATE NOT NULL,
montant DECIMAL(12,2) CHECK(montant>0),
id_client INT,
FOREIGN KEY(id_client) REFERENCES client(id_client)
)");
/*********************
ADMIN PAR DEFAUT
 *********************/
$check = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
if ($check == 0) {
    $passHash = password_hash("admin123", PASSWORD_DEFAULT);
    $pdo->exec("INSERT INTO users(username,password,role)
VALUES('admin','$passHash','admin')");
}
/*********************
LOGIN
 *********************/
if (isset($_POST['login'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute([$_POST['username']]);
    $u = $stmt->fetch();
    if ($u && password_verify($_POST['password'], $u['password'])) {
        $_SESSION['user'] = $u;
    } else {
        $erreur = "Identifiants incorrects";
    }
}
/*********************
LOGOUT
 *********************/
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
/*********************
AJOUT CLIENT
 *********************/
if (isset($_POST['addClient'])) {
    $sql = "INSERT INTO client(nom,prenom,email,telephone,adresse,date_inscrip)
VALUES(?,?,?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['email'],
        $_POST['tel'],
        $_POST['adr'],
        $_POST['date']
    ]);
}
/*********************
AJOUT COMMANDE
 *********************/
if (isset($_POST['addCmd'])) {
    $sql = "INSERT INTO commande(date_cmd,montant,id_client)
VALUES(?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['date_cmd'],
        $_POST['montant'],
        $_POST['client']
    ]);
}
/*********************
DELETE
 *********************/
if (isset($_GET['delClient'])) {
    $pdo->exec("DELETE FROM client WHERE id_client=" . $_GET['delClient']);
}
/*********************
DATA
 *********************/
$clients = $pdo->query("SELECT * FROM client")->fetchAll();
$cmds = $pdo->query("SELECT commande.*,nom,prenom FROM commande
JOIN client USING(id_client)")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion Vente Plus</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f8f9fb;
            --surface: #ffffff;
            --surface2: #f5f7fa;
            --border: #e1e8f0;
            --accent: #4f8ef7;
            --accent2: #7c6af5;
            --danger: #f75a5a;
            --text: #1a202c;
            --muted: #718096;
            --success: #3dd6a3;
        }

        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            padding: 0;
            background-image: radial-gradient(circle, #e1e8f0 1px, transparent 1px);
            background-size: 28px 28px;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(248, 249, 251, 0.85);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 36px;
            height: 62px;
        }

        .topbar-brand {
            font-family: 'Syne', sans-serif;
            font-size: 1.2rem;
            font-weight: 800;
            letter-spacing: .02em;
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: .88rem;
            color: var(--muted);
        }

        .topbar-right b {
            color: var(--text);
            font-weight: 500;
        }

        .logout-link {
            color: var(--danger);
            text-decoration: none;
            font-weight: 500;
            font-size: .85rem;
            padding: 6px 14px;
            border: 1px solid rgba(247, 90, 90, .35);
            border-radius: 6px;
            transition: background .2s, color .2s;
        }

        .logout-link:hover {
            background: rgba(247, 90, 90, .12);
        }

        .main {
            max-width: 980px;
            margin: 0 auto;
            padding: 40px 24px 60px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        h2 {
            font-family: 'Syne', sans-serif;
            font-size: 2.1rem;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 4px;
        }

        .box {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 28px 32px;
            animation: fadeUp .35s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .box:nth-child(2) {
            animation-delay: .05s;
        }

        .box:nth-child(3) {
            animation-delay: .10s;
        }

        .box:nth-child(4) {
            animation-delay: .15s;
        }

        .box:nth-child(5) {
            animation-delay: .20s;
        }

        h3 {
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        h3::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
            margin-left: 10px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px 16px;
        }

        .form-grid .full {
            grid-column: 1 / -1;
        }

        input,
        select {
            width: 100%;
            padding: 11px 14px;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            font-family: inherit;
            font-size: .93rem;
            transition: border-color .2s, box-shadow .2s;
            appearance: none;
        }

        input::placeholder {
            color: var(--muted);
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(79, 142, 247, .15);
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(.5);
            cursor: pointer;
        }

        select option {
            background: var(--surface2);
        }

        button {
            margin-top: 14px;
            padding: 12px 20px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: #fff;
            border: none;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: .93rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity .2s, transform .15s, box-shadow .2s;
            width: 100%;
            letter-spacing: .02em;
        }

        button:hover {
            opacity: .9;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(79, 142, 247, .3);
        }

        button:active {
            transform: translateY(0);
            opacity: 1;
        }

        .table-wrap {
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: .9rem;
        }

        thead tr {
            background: var(--surface2);
        }

        th {
            padding: 12px 16px;
            text-align: left;
            font-size: .78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--muted);
            white-space: nowrap;
        }

        td {
            padding: 13px 16px;
            border-top: 1px solid var(--border);
            color: var(--text);
            font-size: .9rem;
        }

        tbody tr {
            transition: background .15s;
        }

        tbody tr:hover {
            background: var(--surface2);
        }

        a.del {
            color: var(--danger);
            text-decoration: none;
            font-size: .82rem;
            font-weight: 500;
            padding: 4px 10px;
            border: 1px solid rgba(247, 90, 90, .3);
            border-radius: 5px;
            transition: background .2s;
        }

        a.del:hover {
            background: rgba(247, 90, 90, .12);
        }

        .amount {
            display: inline-block;
            background: rgba(61, 214, 163, .1);
            color: var(--success);
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 600;
            font-size: .85rem;
            letter-spacing: .02em;
        }

        .login-wrap {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-box {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 44px 40px;
            width: 100%;
            max-width: 460px;
            animation: fadeUp .4s ease;
        }

        .login-logo {
            font-family: 'Syne', sans-serif;
            font-size: 1.45rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 6px;
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .login-sub {
            text-align: center;
            color: var(--muted);
            font-size: .88rem;
            margin-bottom: 30px;
        }

        .login-box input {
            margin-bottom: 12px;
        }

        .login-hint {
            margin-top: 18px;
            padding: 12px 16px;
            background: var(--surface2);
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: .82rem;
            color: var(--muted);
            text-align: center;
        }

        .login-hint strong {
            color: var(--text);
        }

        .error-msg {
            color: var(--danger);
            background: rgba(247, 90, 90, .1);
            border: 1px solid rgba(247, 90, 90, .25);
            padding: 10px 14px;
            border-radius: 8px;
            font-size: .87rem;
            margin-top: 12px;
            text-align: center;
        }

        @media(max-width: 600px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .topbar {
                padding: 0 18px;
            }

            .box {
                padding: 20px 18px;
            }
        }
    </style>
</head>

<body>
    <?php if (!isset($_SESSION['user'])): ?>
        <div class="login-wrap">
            <div class="login-box">
                <div class="login-logo">Application Gestion Vente</div>
                <p class="login-sub">Version Avancée — Espace sécurisé</p>
                <form method="POST">
                    <input name="username" placeholder="Identifiant" required>
                    <input type="password" name="password" placeholder="Mot de passe" required>
                    <button name="login">Se connecter</button>
                </form>
                <?php if (isset($erreur)): ?>
                    <div class="error-msg">⚠ <?= $erreur ?></div>
                <?php endif; ?>
                <div class="login-hint">Accès démo : <strong>admin</strong> / <strong>admin123</strong></div>
            </div>
        </div>
    <?php else: ?>

        <!-- TOP BAR -->
        <header class="topbar">
            <span class="topbar-brand">🛒 Application Gestion Vente <span style="font-size:.75rem;opacity:.6;font-weight:700">Version Avancée</span></span>
            <div class="topbar-right">
                <span>Connecté en tant que <b><?= htmlspecialchars($_SESSION['user']['username']) ?></b></span>
                <a href="?logout=1" class="logout-link">Déconnexion</a>
            </div>
        </header>

        <div class="main">

            <!-- AJOUTER CLIENT -->
            <div class="box">
                <h3>Nouveau client</h3>
                <form method="POST">
                    <div class="form-grid">
                        <input name="nom" placeholder="Nom" required>
                        <input name="prenom" placeholder="Prénom" required>
                        <input name="email" placeholder="Email" type="email">
                        <input name="tel" placeholder="Téléphone" required>
                        <input name="adr" placeholder="Adresse" class="full">
                        <input type="date" name="date" required class="full">
                        <button name="addClient" class="full">Ajouter le client</button>
                    </div>
                </form>
            </div>

            <!-- AJOUTER COMMANDE -->
            <div class="box">
                <h3>Nouvelle commande</h3>
                <form method="POST">
                    <div class="form-grid">
                        <input type="date" name="date_cmd" required>
                        <input name="montant" placeholder="Montant (F.CFA)" required>
                        <select name="client" class="full">
                            <?php foreach ($clients as $c): ?>
                                <option value="<?= $c['id_client'] ?>">
                                    <?= htmlspecialchars($c['nom'] . ' ' . $c['prenom']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button name="addCmd" class="full">Valider la commande</button>
                    </div>
                </form>
            </div>

            <!-- LISTE CLIENTS -->
            <div class="box">
                <h3>Clients</h3>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Téléphone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clients as $c): ?>
                                <tr>
                                    <td><?= $c['id_client'] ?></td>
                                    <td><?= htmlspecialchars($c['nom']) ?></td>
                                    <td><?= htmlspecialchars($c['prenom']) ?></td>
                                    <td><?= htmlspecialchars($c['telephone']) ?></td>
                                    <td><a class="del" href="?delClient=<?= $c['id_client'] ?>">🗑️ Supprimer</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- HISTORIQUE COMMANDES -->
            <div class="box">
                <h3>Historique des commandes</h3>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cmds as $c): ?>
                                <tr>
                                    <td><?= $c['id_commande'] ?></td>
                                    <td><?= htmlspecialchars($c['nom'] . ' ' . $c['prenom']) ?></td>
                                    <td><?= $c['date_cmd'] ?></td>
                                    <td><span class="amount"><?= number_format($c['montant'], 2, ',', ' ') ?> F.CFA</span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!-- /main -->
    <?php endif; ?>
</body>

</html>