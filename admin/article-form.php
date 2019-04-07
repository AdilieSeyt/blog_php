<?php require_once '../_tools.php'; ?>
<?php
// affichage les categories
$queryCategory = $db->query('SELECT * FROM category');
$selectedCategory = $queryCategory->fetchAll();

$title = isset ($_POST['title']) ? ($_POST['title']) : NULL;
$summary = isset ($_POST['summary']) ? ($_POST['summary']) : NULL;
$content = isset ($_POST['content']) ? ($_POST['content']) : NULL;
$published_at = isset ($_POST['published_at']) ? ($_POST['published_at']) : NULL;
$category_id = isset ($_POST['categories']) ? ($_POST['categories']) : NULL;
 // создание переменных для  UPDATE чтобы они сохранялись в форме, когда мы модифицируем
 if(isset($_GET['article_id'])){
	$query_articleId = $db->prepare('SELECT * FROM article WHERE id = ?');
	$query_articleId->execute( array( $_GET['article_id']));
	$queryArticleId = $query_articleId->fetch();

	$title = $queryArticleId['title'];
	$published_at = $queryArticleId['published_at'];
	$category_id = $queryArticleId['category_id'];
	$summary = $queryArticleId['summary'];
	$content = $queryArticleId['content'];
	$image = $queryArticleId['image'];
	$is_published = $queryArticleId['is_published'];
	$article_id = $queryArticleId['id'];
	}

//создаем пустой обьект
$alerts=[];
$success =[];


if(isset($_POST['save']) OR isset($_POST['update'])){ //si on veut enregistrer ou modifier
	//affichage des errers
	if (empty($_POST['title'])){ 
		$alerts['title'] ="Le titre est obligatoire";
	}
	if(empty($_POST['published_at'])){
		$alerts['published_at'] ="La date est obligatoire";
	}
	if(empty($_POST['categories'])){
		$alerts['categories'] ="Choisissez une categorie";
	}
	// pour les images
	if(isset($_FILES['image']) AND ($_FILES['image']['error']) === 0){
		if(pathinfo($_FILES['image']['type'])['dirname'] != 'image'){
			$alerts['incorrectTypeIng'] = "Votre fichier n'est pas en bon format";
		}
		if ($_FILES['image']['size'] > 1500000){
			$alerts['incorrectSizeIng'] = 'Votre image est trop lourd.';
		}
	}

	if(empty($alerts)){
		$newNameImg = time().$_FILES['image']['name'];
		move_uploaded_file($_FILES['image']['tmp_name'], '../img/' . basename($newNameImg));
		// pour modofication
		if(isset($_POST['update'])){
			$queryTitrelExiste = $db->prepare('UPDATE article SET category_id =?, published_at=?, title=?, summary=?, content=?, is_published=?, image=?  WHERE id=?');
			$queryTitrelExiste->execute( array( htmlspecialchars($_POST['categories']), htmlspecialchars($_POST['published_at']), htmlspecialchars($_POST['title']),  htmlspecialchars($_POST['summary']), htmlspecialchars($_POST['content']), htmlspecialchars($_POST['is_published']), htmlspecialchars($newNameImg), $_POST['article_id']));
			$success['updated']="Modification effectué avec succés";		
		}else{ //pour enregistrement 
			// si le titre existe
			$query_user = $db->prepare('SELECT title FROM article WHERE title = ?');
			$query_user->execute( array( $_POST['title']));
			$queryTitrelExiste = $query_user->fetch();

			if($queryTitrelExiste == FALSE){
				$queryTitrelExiste = $db->prepare('INSERT INTO article (category_id, published_at, title, summary, content, is_published, image) VALUES (?, ?, ?, ?, ?, ?, ?)');
				$queryTitrelExiste->execute( array( htmlspecialchars($_POST['categories']), htmlspecialchars($_POST['published_at']), htmlspecialchars($_POST['title']),  htmlspecialchars($_POST['summary']), htmlspecialchars($_POST['content']), htmlspecialchars($_POST['is_published']), htmlspecialchars($newNameImg) ));
				$success['saved']="Enregistrement effectué avec succés";		

			}else{
				$alerts['titleexiste'] ="Ce titre était déjà utilisé";
			}
		}
	}else{
		$alerts['error_save'] ="L'enregistrement n'a pas abouti";
	}
}
?>
<!DOCTYPE html>
<html>
<head>

		<title>Administration des articles - Mon premier blog !</title>
		<?php require 'partials/head_assets.php'; ?>

</head>
<body class="index-body">
	<div class="container-fluid">

        <?php require 'partials/header.php'; ?>
		
			<div class="row my-3 index-content">

			<?php require 'partials/nav.php'; ?>
			

				<section class="col-9">
					<header class="pb-3">
						<?php if(isset($_GET['article_id'])):?>
							<h4>Modifier un article</h4>
						<?php else:?>
							<h4>Ajouter un article</h4>
						<?php endif;?>
						<?php foreach ($alerts as $alert):?>
							<p class="text-danger"><?php echo $alert;?></p>
						<?php endforeach;?>
						<?php foreach ($success as $succes):?>
							<p class="text-success"><?php echo $succes;?></p>
						<?php endforeach;?>
				</header>

				<ul class="nav nav-tabs justify-content-center nav-fill" role="tablist">
				<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#infos" role="tab">Infos</a>
				</li>
				</ul>
				<div class="tab-content">
				<div class="tab-pane container-fluid active" id="infos" role="tabpanel">

				<!-- Si $article existe, chaque champ du formulaire sera pré-remplit avec les informations de l'article -->
				<?php if(isset($_GET['article_id'])): ?>
					<form action="article-form.php?article_id=<?php echo $article_id;?>$action=edit" method="post">
				<?php else: ?>
					<form action="article-form.php" method="post" enctype="multipart/form-data">
				<?php endif;?>
					<div class="form-group">
						<label for="title">Titre : <b class="text-danger">*</b></label>
						<input class="form-control"  type="text" placeholder="Titre" name="title" id="title" value="<?php echo $title ;?>" />
					</div>
						<div class="form-group">
						<label for="summary">Date : <b class="text-danger">*</b></label>
					<input class="form-control"  type="date" placeholder="date" name="published_at" id="published_at"  value="<?php echo $published_at;?>"/>
					</div>
					<div class="form-group">
						<label for="summary">Résumé :</label>
						<input class="form-control"  type="text" placeholder="Résumé" name="summary" id="summary" value="<?php echo $summary ;?>"/>
					</div>
					<div class="form-group">
						<label for="content">Contenu :</label>
						<textarea class="form-control" name="content" id="content" placeholder="Contenu"><?php echo $content; ?></textarea>
					</div>
					<div class="form-group">
						<label for="image">Image :</label>
						<input class="form-control" type="file" name="image" id="image" value="<?php echo $image ?>"/>
					</div>
					<div class="form-group">
						<label for="categories"> Catégorie <b class="text-danger">*</b></label>
						<select class="form-control" name="categories" id="categories" multiple="multiple">
							<?php foreach($selectedCategory as $category ): ?>
								<option value="<?php echo $category['id'];?>"><?php echo $category['name'];?></option>
							<?php endforeach; ?>											
						</select>
					</div>
					<div class="form-group">
						<label for="is_published"> Publié ?</label>
						<select class="form-control" name="is_published" id="is_published">
							<?php if (isset($_GET['article_id'])): ?>
								<?php if ($queryArticleId['is_published'] == 0): ?>
									<option selected="selected" value="<?php echo $queryArticleId['is_published']; ?>">Non</option>
									<option value="1">Oui</option>
								<?php else: ?>
									<option value="0">Non</option>
									<option selected="selected" value="<?php echo $queryArticleId['is_published']; ?>">Oui</option>
								<?php endif;?>
							<?php else: ?>
									<option selected="selected" value="0" >Non</option>
									<option value="1" >Oui</option>
							<?php endif; ?>
						</select>
					</div>
					<?php if(isset($_GET['article_id'])): ?>
						<div class='form-group'>
							<input class="form-control"  type="hidden" name="article_id" id="article_id" value="<?php echo $article_id ;?>"/>
						</div>
					<?php endif; ?>


					<div class="text-right">
						<?php if(isset($_GET['article_id'])): ?>
							<input class="btn btn-success" type="submit" name="update" value="Mettre à jour" />
						<?php else: ?>
							<input class="btn btn-success" type="submit" name="save" value="Enregistrer" />
						<?php endif; ?>
					</div>
					<!-- Si $article existe, on affiche un lien de mise à jour -->
					<!-- Si $article existe, on ajoute un champ caché contenant l'id de l'article à modifier pour la requête UPDATE -->
				</form>
				</div>
				</div>
				</section>
			</div>
		</div>
  </body>
</html>
