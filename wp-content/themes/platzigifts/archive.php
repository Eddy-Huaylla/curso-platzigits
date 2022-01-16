<?= get_header(); ?>

<div class="container my-4">
	<div class="row">
		<div class="col-12 text-center">
			<h1><?= the_archive_title(); ?></h1>
		</div>

		<?php
		if(have_posts()) {
			while(have_posts()) {
				the_post();
				?>

				<div class="col-4 text-center-single-archive">
					<a href="<?= the_permalink(); ?>">
						<?= the_post_thumbnail('large'); ?>
						<h4><?= the_title(); ?></h4>
					</a>
				</div>

				<?php
			}
		}
		?>

	</div>
</div>

<?= get_footer(); ?>
