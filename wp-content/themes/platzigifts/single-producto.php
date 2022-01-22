<?php get_header(); ?>

<main class='container my-3'>
	<?php if(have_posts()){
			while(have_posts()){
				the_post();

				// obtener todas las taxonomias con referente al post y categoria
				$taxonomy = get_the_terms($ID_producto_actual, 'categoria-productos');

				?>

				<h1 class='my-5'><?= the_title() ?></h1>
				<div class="row">
					<div class="col-md-6 col-12">
						<?= the_post_thumbnail('large'); ?>
					</div>
					<div class="col-md-6 col-12">
						<?= do_shortcode('[contact-form-7 id="33" title="Formulario de Contacto"]'); ?>
					</div>
					<div class="col-12">
						<?= the_content(); ?>
					</div>
				</div>

				<!-- Productos Relacionados -->
				<?php
				$ID_producto_actual = get_the_ID();
				$args = array(
					'post_type'      => 'producto',
					'posts_per_page' => 6,
					'post__not_in'   => array($ID_producto_actual),
					'order'          => 'ASC',
					'orderby'        => 'title',
					'tax_query'		=> [
						// indica que el query es para una taxonomia en particular
						[
							'taxonomy' => 'categoria-productos',
							'field' => 'slug',
							'terms' => $taxonomy[0]->slug
						]
					]
				);
				// En la siguiente variable se define el contenido
				// que vamos a solicitar a la base de datos, a través
				// del array de argumentos previamente definidos.
				// Ahora la variable $productos es un objeto con la configuración
				// necesaria para solicitar contenido.
				$productos = new WP_Query($args);
				?>

				<!-- Ejecutar el loop con el objeto $productos -->
				<?php
				if($productos->have_posts()) { ?>

					<div class="row justify-content-center productos-relacionados">
						<div class="col-12">
							<h3 class="my-3 text-center">Productos relacionados</h3>
						</div>
						<?php
						while($productos->have_posts()) {
							$productos->the_post();

							if(get_the_ID() != $ID_producto_actual) { ?>

								<div class="col-2 my-3 text-center">
									<?= the_post_thumbnail('thumbnail'); ?>
									<h4>
										<a href="<?= the_permalink(); ?>">
											<?= the_title(); ?>
										</a>
									</h4>
								</div>

							<?php
							}
						} ?>
					</div>

				<?php
				}
			}
	} ?>

</main>
<?php get_footer(); ?>
