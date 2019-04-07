<?php require_once '../_tools.php'; ?>
<?php 
if(isset($_GET['category_id'])){
	$query = $db->prepare('DELETE FROM category WHERE id = ? ');
	$query->execute( array( $_GET['category_id']));
}
$queryCategory = $db->query('SELECT * FROM category');
$selectedCategory = $queryCategory->fetchAll();
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
				<?php require 'partials/head_assets.php'; ?>
				<section class="col-9">
					<header class="pb-4 d-flex justify-content-between">
						<h4>Liste des catégories</h4>
						<a class="btn btn-primary" href="category-form.php">Ajouter une catégorie</a>
					</header>
					<?php if ( isset($_GET['action'])): ?>
                       		 <div class="bg-success text-white p-2 mb-4">Suppression efféctuée.</div>
                    <?php endif; ?>
					<table class="table table-striped">
						<thead>
							<tr>
							<th>#</th>
							<th>Name</th>
							<th>Description</th>
							<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($selectedCategory as $category ): ?>
								<tr>
									<th><?php echo $category['id']; ?></th>
									<td><?php echo $category['name']; ?></td>
									<td><?php echo $category['description']; ?></td>
									<td>
										<a href="category-form.php?category_id=<?php echo $category['id'];?>&action=edit" class="btn btn-warning">Modifier</a>
										<a onclick="return confirm('Are you sure?')" href="category-list.php?category_id=<?php echo $category['id'];?>&action=delete" class="btn btn-danger">Supprimer</a>
									</td>
								</tr>
							<?php endforeach; ?>	
						</tbody>
					</table>
				</section>
			</div>
		</div>
	</body>
</html>
