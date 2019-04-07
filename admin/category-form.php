<?php require_once '../_tools.php'; ?>
<?php

$nameCategory = isset ($_POST['name']) ? ($_POST['name']) : NULL;
$description = isset ($_POST['description']) ? ($_POST['description']) : NULL;

 // создание переменных для  UPDATE чтобы они сохранялись в форме, когда мы модифицируем
 if(isset($_GET['category_id'])){
	$query_CatId = $db->prepare('SELECT * FROM category WHERE id = ?');
	$query_CatId->execute( array( $_GET['category_id']));
	$queryCatId = $query_CatId->fetch();

	$nameCategory = $queryCatId['name'];
	$description = $queryCatId['description'];
	$image = $queryCatId['image'];
	$category_id = $queryCatId['id'];
	}
//создаем пустой обьект
$alerts=[];
$success =[];

if(isset($_POST['save']) OR isset($_POST['update'])){ //si on veut enregistrer ou modifier
	//affichage des errers
	if (empty($_POST['name'])){ 
	$alerts['name'] ="Le nom est obligatoire";
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
			$queryCategoryExiste = $db->prepare('UPDATE category SET  name=?, description=?, image=?  WHERE id=?');
			$queryCategoryExiste->execute( array( htmlspecialchars($_POST['name']), htmlspecialchars($_POST['description']), htmlspecialchars($newNameImg), $_POST['category_id']));
			$success['updated']="Modification effectué avec succés";		
		}else{ //pour enregistrement 
		// si le titre existe
			$query = $db->prepare('SELECT name FROM category WHERE name = ?');
			$query->execute( array( $_POST['name']));
			$queryCategoryExiste = $query->fetch();
				if($queryCategoryExiste == FALSE){
					$queryCategoryExiste = $db->prepare('INSERT INTO category (name, description, image) VALUES (?, ?, ?)');
					$queryCategoryExiste->execute( array( htmlspecialchars($_POST['name']), htmlspecialchars($_POST['description']), htmlspecialchars($_FILES['image']['name'])));
					$success['saved']="Enregistrement effectué avec succés";		
				}else{
					$alerts['nameexiste'] ="Ce nom était déjà utilisé";
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
		<title>Administration des catégories - Mon premier blog !</title>
		<?php require 'partials/head_assets.php'; ?>
	</head>
	<body class="index-body">
		<div class="container-fluid">

        <?php require 'partials/header.php'; ?>
		
			<div class="row my-3 index-content">

			<?php require 'partials/nav.php'; ?>
			

				<section class="col-9">
					<header class="pb-3">
						<!-- Si $category existe, on affiche "Modifier" SINON on affiche "Ajouter" -->
						<?php if(isset($_GET['category_id'])):?>
						<h4>Modifier la categorie</h4>
						<?php else:?>
						<h4>Ajouter une categorie</h4>
						<?php endif;?>					
					</header>

				<?php foreach ($alerts as $alert):?>
					<p class="text-danger"><?php echo $alert;?></p>
				<?php endforeach;?>
				<?php foreach ($success as $succes):?>
					<p class="text-success"><?php echo $succes;?></p>
				<?php endforeach;?>


				<!-- Si $category existe, chaque champ du formulaire sera pré-remplit avec les informations de la catégorie -->

				<?php if(isset($_GET['category_id'])): ?>
					<form action="category-form.php?category_id=<?php echo $category_id;?>$action=edit" method="post">
				<?php else: ?>
					<form action="category-form.php" method="post" enctype="multipart/form-data">
				<?php endif;?>
					<div class="form-group">
						<label for="name">Nom : <b class="text-danger">*</b></label>
						<input class="form-control"  type="text" placeholder="Nom" name="name" id="name" value="<?php echo $nameCategory ;?>" />
					</div>
					<div class="form-group">
						<label for="description">Description : </label>
						<input class="form-control"  type="text" placeholder="Description" name="description" id="description" value="<?php echo $description ;?>" />
					</div>
					<div class="form-group">
						<label for="image">Image :</label>
						<input class="form-control" type="file" name="image" id="image" value="<?php echo $image ?>"/>
					</div>
					<?php if(isset($_GET['category_id'])): ?>
						<div class='form-group'>
							<input class="form-control"  type="hidden" name="category_id" id="category_id" value="<?php echo $category_id ;?>"/>
						</div>
					<?php endif; ?>
					<div class="text-right">
						<?php if(isset($_GET['category_id'])): ?>
							<input class="btn btn-success" type="submit" name="update" value="Mettre à jour" />
						<?php else: ?>
							<input class="btn btn-success" type="submit" name="save" value="Enregistrer" />
						<?php endif; ?>
					</div>
					<!-- Si $category existe, on ajoute un champ caché contenant l'id de la catégorie à modifier pour la requête UPDATE -->
				</form>
				</section>
			</div>

		</div>
	</body>
</html>
