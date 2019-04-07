<?php require_once '../_tools.php'; ?>

<?php
$queryCategory = $db->query('SELECT * FROM user');
$selectedCategory = $queryCategory->fetchAll();

$firstname = isset ($_POST['firstname']) ? ($_POST['firstname']) : NULL;
$lastname = isset ($_POST['lastname']) ? ($_POST['lastname']) : NULL;
$email = isset ($_POST['email']) ? ($_POST['email']) : NULL;
$password = isset ($_POST['password']) ? ($_POST['password']) : NULL;
$bio = isset ($_POST['bio']) ? ($_POST['bio']) : NULL;
$is_admin = isset ($_POST['is_admin']) ? ($_POST['is_admin']) : NULL;

if(isset($_GET['user_id'])){
	$query_userId = $db->prepare('SELECT * FROM user WHERE id = ?');
	$query_userId->execute( array( $_GET['user_id']));
	$queryUserId = $query_userId->fetch();

	$firstname = $queryUserId['firstname'];
	$lastname = $queryUserId['lastname'];
	$email = $queryUserId['email'];
	$password = $queryUserId['password'];
	$bio = $queryUserId['bio'];
	$is_admin = $queryUserId['is_admin'];
	$user_id = $queryUserId['id'];
	}

$alerts=[];
$success =[];

if(isset($_POST['save']) OR isset($_POST['update'])){ //si on veut enregistrer ou modifier
	//affichage des errers
	if (empty($_POST['firstname'])){ 
		$alerts['firstname'] ="Le prénom est obligatoire";
	}
	if(empty($_POST['lastname'])){
		$alerts['lastname'] ="Le nom est obligatoire";
	}
	if(empty($_POST['email'])){
		$alerts['email'] ="L'adresse email est obligatoire";
	}
	if(empty($_POST['password'])){
		$alerts['password'] ="Le mot passe est obligatoire";
	}
	// pour les images
	if(empty($alerts)){	
		// pour modofication
		if(isset($_POST['update'])){
			$queryTitrelExiste = $db->prepare('UPDATE user SET firstname =?, lastname=?, email=?, password=?, bio=?, is_admin=? WHERE id=?');
			$queryTitrelExiste->execute( array( htmlspecialchars($_POST['firstname']), htmlspecialchars($_POST['lastname']), htmlspecialchars($_POST['email']),  htmlspecialchars($_POST['password']), htmlspecialchars($_POST['bio']), htmlspecialchars($_POST['is_admin']), $_POST['user_id']));
			$success['updated']="Modification effectué avec succés";		
		}else{ //pour enregistrement 
			// si le titre existe
			$query = $db->prepare('SELECT email FROM user WHERE email = ?');
			$query->execute( array( $_POST['email']));
			$queryEmailExiste = $query->fetch();
			if($queryEmailExiste == FALSE){
				$queryResult = $db->prepare('INSERT INTO user (firstname, lastname, email, password, bio, is_admin) VALUES (?, ?, ?, ?, ?, ?)');
				$queryResult->execute( array( htmlspecialchars($_POST['firstname']), htmlspecialchars($_POST['lastname']), htmlspecialchars($_POST['email']),  htmlspecialchars($_POST['password']), htmlspecialchars($_POST['bio']), $_POST['is_admin']));
				$success['saved']="Enregistrement effectué avec succés";		
			}else{
				$alerts['emailexiste'] ="L'adresse email existe  déjà";
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

		<title>Administration des utilisateurs - Mon premier blog !</title>
		<?php require 'partials/head_assets.php'; ?>
		
	</head>
	<body class="index-body">
		<div class="container-fluid">

        <?php require 'partials/header.php'; ?>
		
			<div class="row my-3 index-content">

			<?php require 'partials/nav.php'; ?>
			

			<section class="col-9">
				<header class="pb-3">
					<!-- Si $user existe, on affiche "Modifier" SINON on affiche "Ajouter" -->
					<?php if(isset($_GET['user_id'])):?>
						<h4>Modifier  l'utiliseteur</h4>
					<?php else:?>
						<h4>Ajouter un utiliseteur</h4>
					<?php endif;?>		

					<?php foreach ($alerts as $alert):?>
						<p class="text-danger"><?php echo $alert;?></p>
					<?php endforeach;?>
					<?php foreach ($success as $succes):?>
						<p class="text-success"><?php echo $succes;?></p>
					<?php endforeach;?>			
				</header>

				
			<!-- Si $user existe, chaque champ du formulaire sera pré-remplit avec les informations de l'utilisateur -->
				<?php if(isset($_GET['user_id'])): ?>
					<form action="user-form.php?user_id=<?php echo $user_id;?>$action=edit" method="post">
				<?php else: ?>
					<form action="user-form.php" method="post">
				<?php endif; ?>
					<div class="form-group">
						<label for="firstname">Prénom : <b class="text-danger">*</b></label>
						<input class="form-control"  type="text" placeholder="Prénom" name="firstname" id="firstname" value="<?php echo $firstname ;?>"/>
					</div>
					<div class="form-group">
						<label for="lastname">Nom de famille :  <b class="text-danger">*</b></label>
						<input class="form-control"  type="text" placeholder="Nom de famille" name="lastname" id="lastname" value="<?php echo $lastname ;?>" />
					</div>
					<div class="form-group">
						<label for="email">Email : <b class="text-danger">*</b></label>
						<input class="form-control"  type="email" placeholder="Email" name="email" id="email" value="<?php echo $email ;?>" />
					</div>
					<div class="form-group">
						<label for="password">Password : <b class="text-danger">*</b> </label>
						<input class="form-control" type="password" placeholder="Mot de passe" name="password" id="password" value="<?php echo $password ;?>" />
					</div>
					<div class="form-group">
						<label for="bio">Biographie :</label>
						<textarea class="form-control" name="bio" id="bio" placeholder="Sa vie son oeuvre..."><?php echo $bio ;?></textarea>
					</div>
					<div class="form-group">
						<label for="is_admin"> Admin ?</label>
						<select class="form-control" name="is_admin" id="is_admin">
							<?php if (isset($_GET['user_id'])): ?>
							<?php if ($queryUserId['is_admin'] == 0): ?>
								<option selected="selected" value="<?php echo $queryUserId['is_admin']; ?>">Non</option>
								<option value="1">Oui</option>
							<?php else: ?>
								<option value="0">Non</option>
								<option selected="selected" value="<?php echo $queryUserId['is_admin']; ?>">Oui</option>
							<?php endif;?>
							<?php else: ?>
								<option selected="selected" value="0" >Non</option>
								<option value="1" >Oui</option>
							<?php endif; ?>
						</select>
					</div>
					<?php if(isset($_GET['user_id'])): ?>
						<div class='form-group'>
							<input class="form-control"  type="hidden" name="user_id" id="user_id" value="<?php echo $user_id ;?>"/>
						</div>
					<?php endif; ?>
					<div class="text-right">
						<?php if(isset($_GET['user_id'])): ?>
							<input class="btn btn-success" type="submit" name="update" value="Mettre à jour" />
						<?php else: ?>
							<input class="btn btn-success" type="submit" name="save" value="Enregistrer" />
						<?php endif; ?>
					</div>
					<!-- Si $user existe, on affiche un lien de mise à jour -->
					<!-- Si $user existe, on ajoute un champ caché contenant l'id de l'utilisateur à modifier pour la requête UPDATE -->

				</form>
			</section>
			</div>
		</div>
	</body>
</html>
