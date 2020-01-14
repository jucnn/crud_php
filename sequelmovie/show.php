<?php
include 'functions.php';

$pdo = pdo_connect_mysql();

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM movie, poster, trailer, movie_genre, genre WHERE movieID = ? and p_movieID = movieID and t_movieID = movieID and g_genreID = genreID and m_movieID = movieID');
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

<h1><?= $movie['movieTitle'] ?></h1>
<a href="read.php">Retour</a>
<img src="<?= $movie['posterLink'] ?>" alt="">
<div class="description">
    <h2>Description :</h2>
    <p><?= $movie['movieDesc'] ?></p>
</div>
<div class="date">
    <h2>Date de sortie :</h2>
    <p><?= $movie['movieReleaseDate'] ?></p>
</div>
<div class="runtime">
    <h2>Durée du film :</h2>
    <p><?= $movie['movieRuntime'] ?></p>
</div>
<div class="certificate">
    <h2>Nombre de prix :</h2>
    <p><?= $movie['movieCertificate'] ?></p>
</div>
<div class="rating">
    <h2>Classement :</h2>
    <p><?= $movie['movieRating'] ?></p>
</div>
<div class="genre">
    <h2>Genre :</h2>
    <p><?= $movie['genreType'] ?></p>
</div>

<h3>Découvrer la <a target="_blank" href="<?= $movie['trailerURL'] ?>">bande-annonce</a> </h3>

<?=template_footer()?>