<?= get_header(); ?>

<main class='container'>
	<?php if(have_posts()){
			while(have_posts()){
				the_post(); ?>
				<h1 class='my-3'><?= the_title(); ?></h1>

				<?= the_content(); ?>

			<?php
			}
	}
	?>
</main>

<?= get_footer(); ?>
