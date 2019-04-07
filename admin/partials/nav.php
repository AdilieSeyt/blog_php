<?php require_once '../_tools.php'; ?>
<?php 
	$query = $db->query('SELECT COUNT(*) FROM user');
	$user_quant = $query->fetch();

	$query = $db->query('SELECT COUNT(*) FROM category');
	$category_quant = $query->fetch();

	$query = $db->query('SELECT COUNT(*) FROM article');
	$article_quant = $query->fetch();

?>
	
	
<nav class="col-3 py-2 categories-nav">
	<a class="d-block btn btn-warning mb-4 mt-2" href="../index.php">Site</a>
	<ul>
		<li><a href="user-list.php">Gestion des utilisateurs (<?php echo $user_quant[0];  ?>)</a></li>
		<li><a href="category-list.php">Gestion des catégories (<?php echo $category_quant[0];  ?>)</a></li>
		<li><a href="article-list.php">Gestion des articles (<?php echo $article_quant[0];  ?>)</a></li>
	</ul>
</nav>