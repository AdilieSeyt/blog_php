<?php require_once '_tools.php'; ?>
<?php
$alerts=[];
$success =[];

if(isset($_POST['login'])){
	if(!empty($_POST['email']) AND !empty($_POST['password'])){
		$query = $db->prepare('SELECT * FROM user WHERE email = ?');
		$query->execute(array($_POST['email']));
		$selectedLogin = $query->fetch();
		if($_POST['email'] == $selectedLogin['email'] AND md5($_POST['password']) == $selectedLogin['password'] ){
			$_SESSION['firstname'] = $selectedLogin['firstname'];
			$_SESSION['logged'] = TRUE;
			$_SESSION['is_admin'] = $selectedLogin['is_admin'];
			header('location:index.php');
			exit;
		}elseif($_POST['email'] == $selectedLogin['email'] AND md5($_POST['password']) !== $selectedLogin['password']){
			$alerts['error_acces'] ="Le mot de passe n'est pas correcte";

		}else{
			$alerts['error_acces'] ="Vous n'etes pas inscris ";
		}
	}
	if(empty($_POST['email'])){
		$alerts['email'] ="L'adresse email est obligatoire";
	}
	if(empty($_POST['password'])){
		$alerts['password'] ="Le mot passe est obligatoire";
	}
}
$nameCategory = isset ($_POST['name']) ? ($_POST['name']) : NULL;
$description = isset ($_POST['description']) ? ($_POST['description']) : NULL;

if(isset($_POST['register'])){
	if(!empty($_POST['firstname']) AND !empty($_POST['email']) AND !empty($_POST['password']) AND !empty($_POST['password_confirm'])){
		$query = $db->prepare('SELECT * FROM user WHERE email = ?');
		$query->execute(array($_POST['email']));
		$mailExiste = $query->fetch();
		if(!$mailExiste AND $_POST['password'] == $_POST['password_confirm']){
			$queryCategoryExiste = $db->prepare('INSERT INTO user (firstname, lastname, email, password,  bio ) VALUES (?, ?, ?, ?, ?)');
			$queryCategoryExiste->execute( array( htmlspecialchars($_POST['firstname']), htmlspecialchars($_POST['lastname']), htmlspecialchars($_POST['email']), md5($_POST['password']), htmlspecialchars($_POST['bio'])));
			$_SESSION['firstname'] = $_POST['firstname'];
			$_SESSION['logged'] = TRUE;
			// $_SESSION['is_admin'] = false;
			header('location:index.php');
			exit;
		}elseif($mailExiste){
			$alerts['mail_existe'] ="L'adresse email est existe déjà ";
		}else{
			$alerts['error_confirm'] ="Les motes de passe ne sont pas les memmes";
		}
	}
	if (empty($_POST['firstname'])){ 
		$alerts['firstname'] ="Le prénom est obligatoire";
	}
	if(empty($_POST['email'])){
		$alerts['email'] ="L'adresse email est obligatoire";
	}
	if(empty($_POST['password'])){
		$alerts['password'] ="Le mot passe est obligatoire";
	}
	if(empty($_POST['password_confirm'])){
		$alerts['password_confirm'] ="Veuillez confirmer le mot de passe";
	}
}
?>
<!DOCTYPE html>
<html>
    <head>
		<title>Homepage - Mon premier blog !</title>
		<?php require 'partials/head_assets.php'; ?>
	</head>
 <body class="article-body">
	<div class="container-fluid">
    <?php require 'partials/header.php'; ?>
		<?php foreach ($alerts as $alert):?>
			<p class="text-danger"><?php echo $alert;?></p>
		<?php endforeach;?>
		<?php foreach ($success as $succes):?>
			<p class="text-success"><?php echo $succes;?></p>
		<?php endforeach;?>	
		<div class="row my-3 article-content">
       <?php require 'partials/nav.php'; ?>
			<main class="col-9">
				<ul class="nav nav-tabs justify-content-center nav-fill" role="tablist">
					<li class="nav-item">
						<a class="nav-link <?php if(!isset($_POST['register'])):?>active<?php endif ?>" data-toggle="tab" href="#login" role="tab">Connexion</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php if(isset($_POST['register'])):?>active<?php endif ?>" data-toggle="tab" href="#register" role="tab">Inscription</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane container-fluid <?php if(!isset($_POST['register'])):?>active<?php endif ?>" id="login" role="tabpanel">

						<form action="login_register.php" method="post" class="p-4 row flex-column">

							<h4 class="pb-4 col-sm-8 offset-sm-2">Connexion</h4>
							<div class="form-group col-sm-8 offset-sm-2">
								<label for="email">Email</label>
								<input class="form-control" value="" type="email" placeholder="Email" name="email" id="email" />
							</div>

							<div class="form-group col-sm-8 offset-sm-2">
								<label for="password">Mot de passe</label>
								<input class="form-control" value="" type="password" placeholder="Mot de passe" name="password" id="password" />
							</div>

							<div class="text-right col-sm-8 offset-sm-2">
								<input class="btn btn-success" type="submit" name="login" value="Valider" />
							</div>

						</form>
					</div>
					<div class="tab-pane container-fluid <?php if(isset($_POST['register'])):?>active<?php endif ?> " id="register" role="tabpanel">

						<form action="login_register.php" method="post" class="p-4 row flex-column">

							<h4 class="pb-4 col-sm-8 offset-sm-2">Inscription</h4>

							
							<div class="form-group col-sm-8 offset-sm-2">
								<label for="firstname">Prénom <b class="text-danger">*</b></label>
								<input class="form-control" value="" type="text" placeholder="Prénom" name="firstname" id="firstname" />
							</div>
							<div class="form-group col-sm-8 offset-sm-2">
								<label for="lastname">Nom de famille</label>
								<input class="form-control" value="" type="text" placeholder="Nom de famille" name="lastname" id="lastname" />
							</div>
							<div class="form-group col-sm-8 offset-sm-2">
								<label for="email">Email <b class="text-danger">*</b></label>
								<input class="form-control" value="" type="email" placeholder="Email" name="email" id="email" />
							</div>
							<div class="form-group col-sm-8 offset-sm-2">
								<label for="password">Mot de passe <b class="text-danger">*</b></label>
								<input class="form-control" value="" type="password" placeholder="Mot de passe" name="password" id="password" />
							</div>
							<div class="form-group col-sm-8 offset-sm-2">
								<label for="password_confirm">Confirmation du mot de passe <b class="text-danger">*</b></label>
								<input class="form-control" value="" type="password" placeholder="Confirmation du mot de passe" name="password_confirm" id="password_confirm" />
							</div>
							<div class="form-group col-sm-8 offset-sm-2">
								<label for="bio">Biographie</label>
								<textarea class="form-control" name="bio" id="bio" placeholder="Ta vie Ton oeuvre..."></textarea>
							</div>

							<div class="text-right col-sm-8 offset-sm-2">
								<p class="text-danger">* champs requis</p>
								<input class="btn btn-success" type="submit" name="register" value="Valider" />
							</div>

						</form>

					</div>
				</div>
			</main>

		</div>

		<<?php require 'partials/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.1/jquery.fancybox.min.js"></script>

<script src="js/main.js"></script>

	</div>
 </body>
</html>
