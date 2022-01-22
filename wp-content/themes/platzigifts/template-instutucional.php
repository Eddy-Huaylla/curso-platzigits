<?php
//Template Name: Página Institucional
get_header();
$fields = get_fields();
?>

<main class='container'>

	<?php
	if(have_posts()){
		while(have_posts()){
			the_post(); ?>
			<h1 class='my-3'><?= $fields['titulo']; ?></h1>
			<img src="<?= $fields['imagen']; ?>">
			<hr>

			<?= the_content(); ?>

		<?php
		}
	}
	?>

</main>

<?= get_footer(); ?>
