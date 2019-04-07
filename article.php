<?php require_once '_tools.php'; ?>
<?php
	//si j'ai reçu article_id ET que c'est un nombre
	if(isset($_GET['article_id']) AND ctype_digit($_GET['article_id'])){
		$query = $db->prepare('SELECT a.*, c.name as category_name 
		FROM  article a INNER JOIN category c
		ON a.category_id = c.id 
		WHERE a.id = ?');

		$query->execute( array( $_GET['article_id'] ) );
		$article = $query->fetch();

		//si aucun article n'a été trouvé je redirige
		if($article == false){
			header('location:index.php');
			exit;
		}
	}
	else{ //sinon je redirige
		header('location:index.php');
		exit;
	}
?>

<!DOCTYPE html>
<html>
 <head>

	<title><?php echo $article['title']; ?> - Mon premier blog !</title>

   <?php require 'partials/head_assets.php'; ?>

 </head>
 <body class="article-body">
	<div class="container-fluid">

		<?php require 'partials/header.php'; ?>

		<div class="row my-3 article-content">

			<?php require 'partials/nav.php'; ?>

			<main class="col-9">
				<article>
					<h1><?php echo $article['title']; ?></h1>
					<b class="article-category">[<?php echo $article['category_name']; ?>]</b>
					<span class="article-date">
						<!-- affichage de la date de l'article selon le format %A %e %B %Y -->
						<?php echo strftime("%A %e %B %Y", strtotime($article['published_at'])); ?>
					</span>
					<div class="article-content">
						<?php echo $article['content']; ?>
					</div>
				</article>
			</main>

		</div>

		<?php require 'partials/footer.php'; ?>

	</div>
 </body>
</html>
