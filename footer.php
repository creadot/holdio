	</main>
	<footer class="footer">
		<?php if( have_rows('slova', 'options') ): ?>
			<div class="footer-animation">
				<div class="container">
					<span class="title h1">
						<span class="title-left">Hold</span>
						<span class="title-right-container">
							<?php while( have_rows('slova', 'options') ) : the_row(); ?>
								<span class="title-right"><?php echo get_sub_field("slovo"); ?></span>
							<?php endwhile; ?>
						</span>
					</span>
				</div>
				<div id="footer-text-animation" class="trigger"></div>
			</div>
		<?php endif; ?>
		<div class="footer-content">
			<?php if ( get_field("nadpis", "options") ): ?>
				<p class="h2"><?php echo get_field("nadpis", "options"); ?></p>
			<?php endif ?>
			<div class="inner">
				<?php if( have_rows("firmy", "options") ): ?>
					<div class="grid">
						<?php while( have_rows("firmy", "options") ) : the_row(); ?>
							<div class="grid__item">
								<p class="h3"><?php echo get_sub_field("nazev"); ?></p>
								<?php echo get_sub_field("kontaktni_udaje"); ?>
							</div>
						<?php endwhile; ?>
					</div>
				<?php endif ?>
				<div class="socials">
					<a href="mailto:<?php echo get_field("e-mail", "options"); ?>">E-mail</a>
					<a href="<?php echo get_field("linkedin", "options"); ?>" target="_blank" rel="noreferrer noopener">LinkedIn</a>
				</div>
			</div>
		</div>
		<div class="copyright-content">
			<div class="copyright-text">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/img/logo-text.svg" width="100" height="34" alt="<?php echo get_bloginfo( 'name' ); ?>">
				<ul>
					<?php
						wp_nav_menu( [
							"theme_location" => "primary",
							"container" => "",
							"items_wrap" => '%3$s'
						] );
					?>
				</ul>
			</div>
			<div class="copyright-created">
				<?php 
					$privacy_page_id = pll_get_post( get_option( 'wp_page_for_privacy_policy' ) ); 
					$privacy_policy_url = $privacy_page_id ? get_permalink( $privacy_page_id ) : '';
				?>
				<p>
					<span>&copy;<?php echo date("Y"); ?> <?php echo get_bloginfo( 'name' ); ?></span>
					<?php if ( $privacy_policy_url ) : ?>
						<a href="<?php echo esc_url( $privacy_policy_url ); ?>"><?php pll_e("Zásady zpracování osobních údajů"); ?></a>
						<a href="javascript:cookiedot.show();"><?php pll_e("Nastavení cookies"); ?></a>
					<?php endif; ?>
				</p>
				<a href="https://creadot.cz/" target="_blank"><?php pll_e("Vyrobil"); ?> <img src="<?php bloginfo('stylesheet_directory'); ?>/img/logo-creadot-black.svg" alt="Creadot"></a>
			</div>
		</div>
	</footer>

	<?php get_template_part("components/scripts"); ?>

</body>
</html>