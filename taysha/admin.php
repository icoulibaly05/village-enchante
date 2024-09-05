<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "centre_aere";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Requête pour obtenir tous les inscrits
$sql = "SELECT id, nom, prenom, date_naissance, email, telephone, etat_paiement, date_inscription FROM inscriptions";
$result = $conn->query($sql);

// Suppression d'un inscrit
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_sql = "DELETE FROM inscriptions WHERE id=$id";
    if ($conn->query($delete_sql) === TRUE) {
        header("Location: admin.php"); // Redirection pour éviter le rafraîchissement de suppression
    }
}

// Mise à jour de l'état de paiement
if (isset($_GET['update_paiement'])) {
    $id = $_GET['update_paiement'];
    $etat_actuel = $_GET['etat_paiement'];
    $nouvel_etat = ($etat_actuel == 'Payé') ? 'Impayé' : 'Payé';
    $update_sql = "UPDATE inscriptions SET etat_paiement='$nouvel_etat' WHERE id=$id";
    if ($conn->query($update_sql) === TRUE) {
        header("Location: admin.php");
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des inscrits</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="inscription.php">Inscription</a></li>
                <li><a href="activité.php">Activités</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <h1>Liste des enfants inscrits</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Date de Naissance</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>État de Paiement</th>
            <th>Date d'Inscription</th>
            <th>Actions</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            // Affichage des données pour chaque inscrit
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["nom"] . "</td>";
                echo "<td>" . $row["prenom"] . "</td>";
                echo "<td>" . $row["date_naissance"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["telephone"] . "</td>";
                echo "<td>" . $row["etat_paiement"] . "</td>";
                echo "<td>" . $row["date_inscription"] . "</td>";
                echo "<td>";
                echo "<a href='modifier.php?id=" . $row["id"] . "'>Modifier</a> | ";
                echo "<a href='admin.php?delete=" . $row["id"] . "' onclick='return confirm(\"Voulez-vous vraiment supprimer cet inscrit ?\")'>Supprimer</a> | ";
                echo "<a href='admin.php?update_paiement=" . $row["id"] . "&etat_paiement=" . $row["etat_paiement"] . "'>" . (($row["etat_paiement"] == 'Payé') ? 'Marquer Impayé' : 'Marquer Payé') . "</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>Aucun inscrit trouvé</td></tr>";
        }
        $conn->close();
        ?>
    </table>

    <footer>
        <p>&copy; 2024 Centre Aéré. Tous droits réservés.</p>
    </footer>
</body>
</html>
