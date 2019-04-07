<?php
	//récupération de la liste des catégories pour générer le menu
	$query = $db->prepare('SELECT  name, id FROM category ');
	$query->execute();
	$categoriesList = $query->fetchAll();
?>

<nav class="col-3 py-2 categories-nav">
	<?php if(isset($_SESSION) AND $_SESSION['logged']): ?>
	<p class="h2 text-center">Salut <?php echo $_SESSION['firstname']; ?> !</p>
	<p>
		<a class="d-block btn btn-danger mb-4 mt-2" href="index.php?logout">Déconnexion</a>
		<?php if ($_SESSION['is_admin'] == 1): ?>
			<a class="d-block btn btn-warning mb-4 mt-2" href="admin/index.php">Administration</a>
		<?php endif; ?>
     </p>
    <!-- Sinon afficher un boutton de connexion -->
    <?php else: ?>
        <a class="d-block btn btn-primary mb-4 mt-2" href="login_register.php">Connexion / inscription</a>
    <?php endif; ?>
	<b>Catégories :</b>
	<ul>
		<li><a href="article_list.php">Tous les articles</a></li>
		<!-- liste des catégories -->
		<?php foreach($categoriesList as $key => $category): ?>
		<li><a href="article_list.php?category_id=<?php echo $category['id']; ?>"><?php echo $category['name']; ?></a></li>
		<?php endforeach; ?>
	</ul>
</nav>
