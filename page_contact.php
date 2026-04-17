<?php
/**
 * Template Name: Kontakt
**/

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<div class="contact">
		<div class="contact__content">
			<div class="container">
				<h1 class="h2"><?php echo get_field("nadpis"); ?></h1>
				<div class="inner">
					<div class="inner__left">
						<?php if ( get_field("popis") ): ?>
							<p class="h3"><?php echo get_field("popis"); ?></p>
						<?php endif ?>
						<div class="people">
							<div class="people__item">
								<p>E-mail</p>
								<a href="mailto:<?php echo get_field("email"); ?>"><?php echo get_field("email"); ?></a>
							</div>
							<?php $phone = get_field("telefon"); ?>
							<?php $phone_no_spaces = str_replace('&nbsp;', '', $phone); ?>
							<div class="people__item">
								<p>Telefon</p>
								<a href="tel:<?php echo $phone_no_spaces; ?>"><?php echo $phone; ?></a>
							</div>
						</div>
					</div>
					<div class="inner__right">
						<?php echo do_shortcode('[contact-form-7 id="8e428ec"]'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="contact__cta">
			<?php echo Img::img(get_field("pozadi")["id"], [ 1920, 930 ], true, ['alt' => false, 'class' => false]); ?>
			<div class="container">
				<div class="inner">
					<img src="<?php bloginfo('stylesheet_directory'); ?>/img/logo-text.svg" width="285" height="80" alt="<?php echo get_bloginfo( 'name' ); ?>">
					<?php echo get_field("text"); ?>
				</div>
			</div>
		</div>
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>
