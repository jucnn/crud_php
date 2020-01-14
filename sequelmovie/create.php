<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
if (!empty($_POST)) {
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $runtime = isset($_POST['runtime']) ? $_POST['runtime'] : '';
    $certificate = isset($_POST['certificate']) ? $_POST['certificate'] : '';
    $releaseDate = isset($_POST['release-date']) ? $_POST['release-date'] : date('Y-m-d H:i:s');
    $rating = isset($_POST['rating']) ? $_POST['rating'] : '';
    
    $stmt = $pdo->prepare('INSERT INTO movie VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $title, $description, $releaseDate, $runtime, $certificate, $rating]);
    
    $msg = 'Ajout réussi!';
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Ajout d'un client</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" placeholder="26" id="id"> <br>
        <label for="title">Titre du film</label>
        <input type="text" name="title" placeholder="The artist" id="title"> <br>
        <label for="description">Description</label>
        <textarea name="description" placeholder="Décrivez le film" id="description"> </textarea> <br>
        <label for="release-date">Date de sortie</label>
        <input type="date" name="release-date" id="releaseDate"> <br>
        <label for="runtime">Durée du film (en min) :</label>
        <input type="number" name="runtime" id="runtime"> <br>
        <label for="certificate">Nombre de prix :</label>
        <input type="number" name="certificate" id="certificate"> <br>
        <label for="rating">Classement :</label>
        <input type="number" name="rating" id="rating"> <br>
        <!-- <fieldset>
            <legend>Genres :</legend>
            <div>
                <input type="checkbox" id="drama" name="gender" value="drame">
                <label for="drama">Drame</label>
            </div>
            <div>
                <input type="checkbox" id="action" name="gender" value="action">
                <label for="action">Action</label>
            </div>
            <div>
                <input type="checkbox" id="crime" name="gender" value="crime">
                <label for="crime">Crime</label>
            </div>
        </fieldset> -->
         <br>

        <input type="submit" value="Créer">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>