<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM movie WHERE movieID = ?');
    $stmt->execute([$_GET['id']]);
    $movie = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$movie) {
        die ('Ce film n\'existe pas!');
    }
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            $stmt = $pdo->prepare('DELETE FROM movie WHERE movieID = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'Le film a bien été supprimé!';
        } else {
            header('Location: read.php');
            exit;
        }
    }
} else {
    die ('Pas d\'ID!');
}
?>

<?=template_header('Film')?>

<div class="delete">
	<h2>Supprimer le film #<?=$movie['movieTitle']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Etes-vous sur de vouloir supprimer ce film : <?=$movie['movieTitle']?>?</p>
    <div class="yesno">
        <a href="delete.php?id=<?=$movie['movieID']?>&confirm=yes">Oui</a>
        <a href="delete.php?id=<?=$movie['movieID']?>&confirm=no">Non</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>