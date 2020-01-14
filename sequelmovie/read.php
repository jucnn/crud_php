<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;

$stmt = $pdo->prepare('SELECT * FROM movie ORDER BY movieID LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

$num_movies = $pdo->query('SELECT COUNT(*) FROM movie')->fetchColumn();
?>

<?=template_header('Liste des films')?>

	<h2>Liste des films</h2>
	<a href="create.php" class="create-client">Ajouter un film</a>

            <?php foreach ($movies as $movie): ?>
            <ul>
                <li><?=$movie['movieTitle']?></li>
                <li><?=$movie['movieDesc']?></li>
                <li><a href="show.php?id=<?= $movie['movieID'] ?>">En savoir plus</a></li>
                <li>
                    <a href="update.php?id=<?=$movie['movieID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$movie['movieID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </li>
            </ul>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_movies): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>