<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<div class="flexible-page">
	<div class="block block--hero">
		<div class="container">
			<?php if ( get_field("nadpis_stitek") ): ?>
				<span class="label"><?php echo get_field("nadpis_stitek"); ?></span>
			<?php endif ?>
			<div class="inner">
				<div class="inner__left">
					<h1 class="h2"><?php echo get_field("nadpis_nadpis"); ?></h1>
				</div>
				
				<?php if( have_rows('polozky') ): ?>
					<div class="inner__right">
						<div class="grid">
							<?php while( have_rows('polozky') ) : the_row(); ?>
								<div class="grid__item">
									<?php echo get_sub_field("polozka"); ?>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
				<?php endif; ?>
				
				<?php if ( get_field("kotva_sipky") ): ?>
					<div class="inner__footer">
						<a href="#<?php echo get_field("kotva_sipky"); ?>" class="button button--sticky">
							<span class="circle">
								<i class="fa-light fa-arrow-down"></i>
							</span>
						</a>
					</div>
				<?php endif ?>
		    </div>
		</div>
	</div>

	<?php if ( get_field("obrazek_video_video") || get_field("obrazek_video_obrazek") ): ?>
		<div class="block block--video-or-image">
			<div class="video-wrapper">
				<?php if ( get_field("obrazek_video_vyberte") == "video" ): ?>
					<video src="<?php echo get_field('obrazek_video_video')['url']; ?>" width="1920" height="1000" playsinline="" autoplay="" muted="" loop="" loading="lazy"></video>
				<?php elseif ( get_field("obrazek_video_vyberte") == "obrazek" ): ?>
					<?php echo Img::img(get_field("obrazek_video_obrazek")["id"], [ 1920, 1000 ], false, ['alt' => false, 'class' => false]); ?>
				<?php endif ?>
				<div id="service-hero" class="trigger"></div>
			</div>
		</div>
	<?php endif ?>

	<?php get_template_part("components/flexible-blocks"); ?>

</div>

<?php endwhile; ?>

<?php get_footer(); ?>