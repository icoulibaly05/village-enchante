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

// Récupérer les informations actuelles de l'inscription
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM inscriptions WHERE id=$id";
    $result = $conn->query($sql);
    $inscription = $result->fetch_assoc();
}

// Mise à jour de l'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];

    $update_sql = "UPDATE inscriptions SET nom='$nom', prenom='$prenom', date_naissance='$date_naissance', email='$email', telephone='$telephone' WHERE id=$id";
    
    if ($conn->query($update_sql) === TRUE) {
        header("Location: admin.php");
    } else {
        echo "Erreur lors de la mise à jour : " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Inscription</title>
</head>
<body>
    <h1>Modifier l'inscription</h1>
    <form action="" method="POST">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo $inscription['nom']; ?>" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo $inscription['prenom']; ?>" required><br>

        <label for="date_naissance">Date de Naissance :</label>
        <input type="date" id="date_naissance" name="date_naissance" value="<?php echo $inscription['date_naissance']; ?>" required><br>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?php echo $inscription['email']; ?>"><br>

        <label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone" value="<?php echo $inscription['telephone']; ?>"><br>

        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>
