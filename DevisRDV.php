<?php
session_start(); // Démarrage de la session pour gérer les messages

// Fonctions pour valider les champs
function nettoyer_donnees($donnees) {
    return htmlspecialchars(stripslashes(trim($donnees)));
}

function valider_NomPrenom($NomPrenom) {
    return isset($NomPrenom) && preg_match("/^[\p{L}\p{M}'\- ]{1,40}$/u", $NomPrenom);
}

function valider_email($email) {
    return isset($email) && preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email);
}

function valider_Telephone($tel) {
    return isset($tel) && preg_match("/^0[0-9]{9}$/", $tel);
}

function valider_Immat($immat) {
    return preg_match("/^([A-Z]{2}[- ]?[0-9]{3}[- ]?[A-Z]{2}|[0-9]{4}[- ]?[A-Z]{2}[- ]?[0-9]{2})$/", $immat);
}

$info = ""; // Initialisation de la variable info

if (isset($_POST['submit'])) {
    // Vérification des champs vides
    if (empty($_POST['name2']) || empty($_POST['email2']) || empty($_POST['number2']) || empty($_POST['immat']) || empty($_POST['message2'])) {
        $_SESSION['info'] = "Veuillez remplir tous les champs !";
        header('Location: DevisRDV.php');
        exit();
    }

    // Récupérer et nettoyer les données
    $vNom = nettoyer_donnees($_POST['name2']);
    $vEmail = nettoyer_donnees($_POST['email2']);
    $vTel = nettoyer_donnees($_POST['number2']);
    $vmessage = nettoyer_donnees($_POST['message2']);
    $vimmat = nettoyer_donnees($_POST['immat']);

    // Tests de validation des champs
    if (!valider_email($vEmail) || !valider_NomPrenom($vNom) || !valider_Telephone($vTel) || !valider_Immat($vimmat)) {
        $_SESSION['info'] = "Veuillez remplir correctement tous les champs !";
        header('Location: DevisRDV.php');
        exit();
    } else {
        // Envoyer l'email
        $to = "martel.flavien@orange.fr";
        $subject = "Demande de Devis de " . $vNom;
        $message = "
            <p>Vous avez reçu un message de <strong>{$vEmail}</strong></p>
            <p><strong>Nom :</strong> {$vNom}</p>
            <p><strong>Téléphone :</strong> {$vTel}</p>
            <p><strong>Immatriculation :</strong> {$vimmat}</p>
            <p><strong>Message :</strong> {$vmessage}</p>
        ";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
        $headers .= "Cc: {$vEmail}" . "\r\n";

        if (mail($to, $subject, $message, $headers)) {
            $_SESSION['succes_message'] = "Message envoyé !";
        } else {
            $_SESSION['info'] = "Échec de l'envoi du message.";
        }

        header('Location: DevisRDV.php');
        exit();
    }
}

?>

<!Doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Main</title>
    <link rel="stylesheet" href="test.css">
</head>
<body>
<button id="btn-haut" title="Retour en haut">↑</button>
<div id="haut">
            <button id="toggle-dark-mode">🌙 Mode sombre</button>
            <p id="date-heure-actuelle"></p>
        </div>
<div class="tete">
    <div class="entete">
        <div><a href="index.html">ACCUEIL</a></div>
        <div class="hide"><a href="presentation.html">PRESENTATION</a></div>
        <div class="hide"><a href="objectifs.html">OBJECTIFS</a></div>
        <div><a href="contacter.php">CONTACTER</a></div>
    </div>
    <div class="tete2">
        <h1 class="gras">GARAGE DU COJEUL</h1>
    </div>
</div>
<div class="date">
    <h2>Du lundi au vendredi, de 9h à 12h30 et de 14h à 17h30 :</h2>
    <h2>03 21 22 55 92</h2>
</div>
<section id="rdv">
    <div class="devis">
        <div class="title2">
            <h6>Besoin d'un devis ? Des questions sur nos services ?</h6>
            <h3>Demandez votre devis personnalisé</h3>
        </div>
        
        <?php if (isset($_SESSION['info'])) { ?>
            <p class="request_message" style="color:red">
                <?= htmlspecialchars($_SESSION['info']); unset($_SESSION['info']); ?>
            </p>
        <?php } ?>

        <?php if (isset($_SESSION['succes_message'])) { ?>
            <p class="request_message" style="color:green">
                <?= htmlspecialchars($_SESSION['succes_message']); unset($_SESSION['succes_message']); ?>
            </p>
        <?php } ?>

        <form action="" method="POST">
            <input type="text" name="name2" placeholder="Entrez votre nom..." required>
            <input type="email" name="email2" placeholder="Entrez votre email..." required>
            <input type="text" name="number2" placeholder="Entrez votre numéro de téléphone" required>
            <input type="text" name="immat" placeholder="Entrez votre immatriculation" required>
            <textarea name="message2" placeholder="Entrez votre prestation" required></textarea>
            <button type="submit" name="submit">Envoyer</button>
        </form>
    </div>
</section>
<div>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12890.701978110108!2d2.8346234470858707!3d50.22520385279044!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47dd4ecbcd206975%3A0x7afde3ed99f87790!2sGARAGE%20DU%20COJEUL!5e0!3m2!1sfr!2sfr!4v1699284519762!5m2!1sfr!2sfr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
<div class="mention">
    <a href="mention.html">Mentions légales</a>
</div>
<script src="test.js"></script>
</body>
</html>
