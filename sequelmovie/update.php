<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $runtime = isset($_POST['runtime']) ? $_POST['runtime'] : '';
        $certificate = isset($_POST['certificate']) ? $_POST['certificate'] : '';
        $releaseDate = isset($_POST['release-date']) ? $_POST['release-date'] : date('Y-m-d H:i:s');
        $rating = isset($_POST['rating']) ? $_POST['rating'] : '';

        $stmt = $pdo->prepare('UPDATE movie SET movieID = ?, movieTitle = ?, movieDesc = ?, movieReleaseDate = ?, movieRuntime = ?, movieCertificate = ?, movieRating = ? WHERE movieID = ?');
        $stmt->execute([$id, $title, $description, $releaseDate, $runtime, $certificate, $rating, $_GET['id']]);

        $msg = 'Mise à jour réussie!';
    }
    $stmt = $pdo->prepare('SELECT * FROM movie WHERE movieID = ?');
    $stmt->execute([$_GET['id']]);
    $movie = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$movie) {
        die ('Ce film n\'existe pas!');
    }
} else {
    die ('Pas d\'ID!');
}
?>

<?=template_header('Film')?>

<div class="content update">
    <h2>Mettre à jour le film <?=$movie['movieTitle']?></h2>
    <form action="update.php?id=<?=$movie['movieID']?>" method="post">
    <label for="id">ID</label>
        <input type="text" name="id" placeholder="26" value="<?=$movie['movieID']?>" id="id"> <br>
        <label for="title">Titre du film</label>
        <input type="text" name="title" value="<?=$movie['movieTitle']?>" placeholder="The artist" id="title"> <br>
        <label for="description">Description</label>
        <textarea name="description" value="<?=$movie['movieDesc']?>" placeholder="Décrivez le film" id="description"> </textarea> <br>
        <label for="release-date">Date de sortie</label>
        <input type="date" name="release-date" value="<?=$movie['movieReleaseDate']?>" id="releaseDate"> <br>
        <label for="runtime">Durée du film (en min) :</label>
        <input type="number" name="runtime" value="<?=$movie['movieRuntime']?>" id="runtime"> <br>
        <label for="certificate">Nombre de prix :</label>
        <input type="number" name="certificate" value="<?=$movie['movieCertificate']?>" id="certificate"> <br>
        <label for="rating">Classement :</label>
        <input type="number" name="rating" value="<?=$movie['movieRating']?>" id="rating"> <br>
        <input type="submit" value="Mettre à jour">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>