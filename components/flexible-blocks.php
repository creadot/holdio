<?php $current_language = pll_current_language(); ?>

<!-- FLEXIBLE BLOCKS -->

<?php if ( have_rows('sekce') ): ?>
    <?php while ( have_rows('sekce') ): the_row(); ?>

        <?php if ( get_row_layout() == 'rozcestnik' ): ?>

        	<?php $items = get_sub_field("polozky"); ?>
        	<div id="<?php echo get_sub_field("kotva"); ?>" class="block block--anchors">
				<div class="container">
					<h2 class="h2"><?php echo strip_tags(get_sub_field("nadpis"), '<strong>'); ?></h2>
					<div class="anchors">
						<?php foreach ($items as $key => $value): ?>
							<a href="<?php echo $value["polozka"]["url"]; ?>" target="<?php echo $value["polozka"]["target"]; ?>"><?php echo $value["polozka"]["title"]; ?></a>
						<?php endforeach ?>
					</div>
				</div>
			</div>

        <?php elseif ( get_row_layout() == 'textovy_obsah' ): ?>

        	<div class="block block--text-content">
        		<div class="container">
        			<div class="inner">
        				<?php echo get_sub_field("obsah"); ?>
        			</div>
        		</div>
        	</div>

        <?php elseif ( get_row_layout() == 'textove_sekce' ): ?>

        	<?php $items = get_sub_field("radky"); ?>
        	<div class="block block--sections">
        		<?php foreach ($items as $key => $value): ?>
					<div id="<?php echo $value["kotva"]; ?>" class="row">
						<div class="container">
							<div class="inner">
								<div class="inner__left">
									<h3 class="h3"><?php echo $value["obsah_vlevo"]["nadpis"]; ?></h3>
								</div>
								<div class="inner__right">
									<?php if ( $value["obsah_vpravo"]["vyberte_typ_obsahu"] == "text" ): ?>
										<?php echo $value["obsah_vpravo"]["text"]; ?>
									<?php elseif ( $value["obsah_vpravo"]["vyberte_typ_obsahu"] == "loga" ): ?>
										<?php $logos = $value["obsah_vpravo"]["loga"]; ?>
										<div class="logos">
											<?php foreach ($logos as $key => $logo): ?>
												<div class="logos__item">
													<?php echo Img::img($logo["id"], [ $logo["width"], $logo["height"] ], false, ['alt' => false, 'class' => false]); ?>
												</div>
											<?php endforeach ?>
										</div>
									<?php elseif ( $value["obsah_vpravo"]["vyberte_typ_obsahu"] == "accordion" ): ?>
										<?php $accordions = $value["obsah_vpravo"]["rozbalovaci_obsah"]; ?>
										<?php foreach ($accordions as $key => $accordion): ?>
											<div class="accordion">
												<div class="accordion__title"><span><?php echo $accordion["nadpis"]; ?></span></div>
												<div class="accordion__content">
													<?php echo $accordion["obsah"]; ?>
												</div>
											</div>
										<?php endforeach ?>
									<?php elseif ( $value["obsah_vpravo"]["vyberte_typ_obsahu"] == "services" ): ?>
										<?php $rel_services = get_field('sluzby'); ?>
										<?php if( $rel_services ): ?>
											<?php foreach ($rel_services as $post): ?>
												<?php setup_postdata($post); ?>
												<div class="accordion">
													<div class="accordion__title"><span><?php the_title(); ?></span></div>
													<div class="accordion__content">
														<?php if (get_field("rozsireny_popis")): ?>
															<p><?php echo get_field("rozsireny_popis"); ?></p>
														<?php endif ?>
														<p><a href="<?php the_permalink(); ?>" class="button button--primary"><?php pll_e("Více o službě"); ?></a></p>
													</div>
												</div>
											<?php endforeach ?>
											<?php wp_reset_postdata(); ?>
										<?php endif; ?>
									<?php endif ?>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			</div>

		<?php elseif ( get_row_layout() == 'fullscreen' ): ?>

			<div id="<?php echo get_sub_field("kotva"); ?>" class="block block--fullscreen "> <!-- underscroll -->
				<?php echo Img::img(get_sub_field("pozadi")["id"], [ get_sub_field("pozadi")["width"], get_sub_field("pozadi")["height"] ], false, ['alt' => false, 'class' => false]); ?>
				<div class="container">
					<h2 class="h1"><?php echo get_sub_field("nadpis"); ?></h2>
				</div>
			</div>
			<!-- <div class="underscroll-placeholder"></div> -->

		<?php elseif ( get_row_layout() == 'divider' ): ?>
		
			<div class="block block--divider"></div>

		<?php elseif ( get_row_layout() == 'big_text' ): ?>

			<div id="<?php echo get_sub_field("kotva"); ?>" class="block block--text">
				<div class="container">
					<h2><?php echo get_sub_field("text"); ?></h2>
				</div>
			</div>

		<?php elseif ( get_row_layout() == 'cta' ): ?>

			<div id="<?php echo get_sub_field("kotva"); ?>" class="block block--cta">
				<div class="container">
					<div class="inner">
						<?php echo Img::img(get_sub_field("pozadi")["id"], [ get_sub_field("pozadi")["width"], get_sub_field("pozadi")["height"] ], false, ['alt' => false, 'class' => false]); ?>
						<h2 class="h3"><?php echo get_sub_field("text"); ?></h2>
						<a href="<?php echo get_sub_field("tlacitko")["url"]; ?>" target="<?php echo get_sub_field("tlacitko")["target"]; ?>" class="button button--sticky big">
							<span class="circle">
								<span class="text"><?php echo get_sub_field("tlacitko")["title"]; ?></span>
							</span>
						</a>
					</div>
				</div>
			</div>

		<?php elseif ( get_row_layout() == 'services' ): ?>
			<?php 
				// Nastavení dotazu pro služby
			    $_services = array(
			        'post_type'      => 'service_cpt',
			        'post_status'    => 'publish',
			        'posts_per_page' => -1,
			        'lang'           => $current_language,
			    );

			    if (is_singular('service_cpt')) {
			        $_services['post__not_in'] = array(get_the_ID());
			    }

			    $services = new WP_Query($_services);
			    $service_terms = get_terms([
			        'taxonomy'   => 'service_cat',
			        'hide_empty' => true,
			        'lang'       => $current_language
			    ]);
			?>
			<div id="<?php echo get_sub_field("kotva"); ?>" class="block services-list">
				<div class="container">
					<div class="inner">
						<h2 class="h2"><?php echo get_sub_field("nadpis") ? get_sub_field("nadpis") : pll__("Další služby holdio"); ?></h2>

						<?php if (!empty($service_terms) && !is_wp_error($service_terms)) : ?>
						    <div class="categories">
						        <span class="categories__item filter" data-filter="all"><?php pll_e("Všechny"); ?></span>
						        <?php foreach ($service_terms as $term) : ?>
						            <span class="categories__item filter" data-filter=".<?php echo esc_attr($term->slug); ?>">
						                <?php echo esc_html($term->name); ?>
						            </span>
						        <?php endforeach; ?>
						    </div>
						<?php endif; ?>
					</div>

					<?php if ( $services->have_posts() ) : $i = 0; ?>
						<div id="mixitup-services" class="grid">
					        <?php while ( $services->have_posts() ) : $services->the_post(); ?>
					        	<?php 
					                $terms = get_the_terms(get_the_ID(), 'service_cat');
					                $term_names = $terms && !is_wp_error($terms) ? wp_list_pluck($terms, 'name') : [];
					                $term_slugs = $terms && !is_wp_error($terms) ? wp_list_pluck($terms, 'slug') : [];
					                $category_classes = !empty($term_slugs) ? implode(' ', $term_slugs) : 'no-category';
					                $label_text = !empty($term_names) ? implode(', ', $term_names) : 'Bez kategorie';
				                ?>
								<a href="<?php the_permalink(); ?>" class="mix grid__item <?php echo esc_attr($category_classes); ?>" aria-label="<?php echo get_the_title(); ?>">
									<span class="content">
										<span class="top">
											<span class="label"><?php echo esc_html($label_text); ?></span>
											<h2 class="h3 alt"><?php echo get_field("nadpis_nadpis"); ?></h2>
											<?php if ( get_field("logo") ): ?>
												<?php echo Img::img(get_field("logo")["id"], [ get_field("logo")["width"], get_field("logo")["height"] ], false, ['alt' => false, 'class' => false]); ?>
											<?php endif ?>
										</span>
										<span class="button button--primary"><?php pll_e("Více o službě"); ?></span>
									</span>
								</a>
								
					        <?php endwhile; ?>
					        <?php wp_reset_postdata(); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>

		<?php elseif ( get_row_layout() == 'numbers' ): ?>

			<?php $numbers = get_sub_field("cisla"); ?>
			<div id="<?php echo get_sub_field("kotva"); ?>" class="block block--numbers">
				<div class="container">
					<div class="grid">
						<?php foreach ($numbers as $key => $number): ?>
							<div class="grid__item">
								<span class="label"><?php echo $number["stitek"]; ?></span>
								<span class="h2"><?php echo $number["cislo"]; ?></span>
							</div>
						<?php endforeach; ?>
						<div class="trigger trigger--1-05"></div>
					</div>

				</div>
			</div>

		<?php elseif ( get_row_layout() == 'references' ): ?>
			<?php 
				$_references = array(
				    'post_type' => 'post',
				    'post_status'    => 'publish',
				    'posts_per_page' => 6,
				    'lang' => $current_language
				);
				$references = new WP_Query($_references);
				$uncategorized_id = get_cat_ID('Nezařazené');
				$references_terms = get_terms([
				    'taxonomy'   => 'category',
				    'hide_empty' => false,
				    'exclude' => array($uncategorized_id),
				    'lang'       => $current_language
				]);
			?>
			<div id="<?php echo get_sub_field("kotva"); ?>" class="block block--references-list">
				<div class="container">
					<h1 class="h2"><?php echo get_sub_field("nadpis") ? get_sub_field("nadpis") : pll__("Reference"); ?></h1>

					<?php if (!empty($references_terms) && !is_wp_error($references_terms)) : ?>
						<div class="categories">

							<?php foreach ($references_terms as $category) : ?>
							    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
							        <?php echo esc_html($category->name); ?>
							    </a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<?php if ( $references->have_posts() ) : $i = 0; ?>
					    <div class="references-list">
					        <?php while ( $references->have_posts() ) : $references->the_post(); ?>
					            <div class="references-list__item<?php if ( get_field("velikost_dlazdice_na_vypisu") == "medium" ): ?> references-list__item--half<?php elseif ( get_field("velikost_dlazdice_na_vypisu") == "big" ) : ?> references-list__item--big<?php endif; ?>">
					                <a href="<?php the_permalink(); ?>" class="content">
					                	<span class="top">
					                		<?php $categories = get_the_category(); ?>
						                    <?php if (!empty($categories)) : ?>
						                        <span class="label"><?php echo esc_html($categories[0]->name); ?></span>
						                    <?php endif; ?>
						                    <h2 class="h3 alt"><?php the_field("nahled_text"); ?></h2>
						                    
						                    <?php if ( get_field("nahled_logo") ) : ?>
						                        <?php echo Img::img(get_field("nahled_logo")["id"], [ 0,0 ], false, ['alt' => false, 'class' => false]); ?>
						                    <?php endif; ?>
					                	</span>
					                    <span class="date"><?php echo get_the_date('d. m. Y'); ?></span>
					                </a>
					                
					                <?php 
										$velikost = get_field("velikost_dlazdice_na_vypisu");
										$nahled_obrazek = get_field("nahled_obrazek");
										$nahled_video = get_field("nahled_video");
										$obrazek_nebo_video = get_field("nahled_obrazek_nebo_video");
									?>

								 	<?php if ( ($velikost == "medium" || $velikost == "big") && $obrazek_nebo_video == "obrazek" && $nahled_obrazek ): ?>
									    <a href="<?php the_permalink(); ?>" class="image">
									        <img src="<?php echo $nahled_obrazek['url']; ?>" alt="" loading="lazy">
									    </a>
									<?php elseif ( ($velikost == "medium" || $velikost == "big") && $obrazek_nebo_video == "video" && $nahled_video ): ?>
									    <a data-fancybox href="<?php echo $nahled_video['url']; ?>" class="image">
									        <img src="<?php echo $nahled_obrazek['url']; ?>" alt="" loading="lazy">
									        <span class="play-icon"><i class="fa-solid fa-play"></i></span>
									    </a>
									<?php endif; ?>
					                
					            </div>

					        <?php endwhile; ?>
					        <?php wp_reset_postdata(); ?>
					    </div>
					<?php endif; ?>
					<div class="more">
						<?php 
							if (function_exists('pll_get_post_type_archive_link')) {
							    $archive_url = pll_get_post_type_archive_link('post'); 
							} else {
							    $archive_url = get_post_type_archive_link('post');
							}
						?>
						<a href="<?php echo $archive_url; ?>" class="button button--sticky big">
							<span class="circle">
								<span class="text">Zobrazit další</span>
							</span>
						</a>
					</div>
				</div>
			</div>

		<?php elseif ( get_row_layout() == 'testimonial' ): ?>

			<div id="<?php echo get_sub_field("kotva"); ?>" class="block block--testimonial">
				<div class="container">
					<div class="inner">
						<div class="inner__left">
							<?php echo Img::img(get_sub_field("obrazek")["id"], [ get_sub_field("obrazek")["width"], get_sub_field("obrazek")["height"] ], false, ['alt' => false, 'class' => false]); ?>
						</div>
						<div class="inner__right">
							<h2 class="h3 alt"><?php echo get_sub_field("obsah")["text"]; ?></h2>
							<?php if ( get_sub_field("obsah")["autor"] ): ?>
								<span class="author"><?php echo get_sub_field("obsah")["autor"]; ?></span>
							<?php endif ?>
							<?php if ( get_sub_field("obsah")["pozice"] ): ?>
								<span class="position"><?php echo get_sub_field("obsah")["pozice"]; ?></span>
							<?php endif ?>
						</div>
					</div>
				</div>
			</div>

		<?php elseif ( get_row_layout() == 'team' ): ?>

			<?php $team = get_sub_field("lide"); ?>
			<div id="<?php echo get_sub_field("kotva"); ?>" class="block block--team">
				<div class="container">
					<h2 class="h2"><?php echo get_sub_field("nadpis"); ?></h2>
					<div class="grid">
						<?php foreach ($team as $key => $member): ?>
							<div class="grid__item" data-fancybox data-src="#<?php echo sanitize_string($member["jmeno"]); ?>">
								<div class="content">
				                	<div class="top">
					                    <h3 class="h3 alt"><?php echo $member["jmeno"]; ?></h3>
					                    <p><?php echo $member["kratky_popis"]; ?></p>
					                    <?php echo Img::img($member["avatar"]["id"], [ 200, 200 ], true, ['alt' => false, 'class' => false]); ?>
				                	</div>
				                    <div class="button button--primary">Více</div>
				                </div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>

			<?php foreach ($team as $key => $member): ?>
				<?php $accordions = $member["rozbalovaci_obsah"]; ?>
				<div class="modal modal--member" id="<?php echo sanitize_string($member["jmeno"]); ?>">
				    <div class="inner">
				        <div class="image">
				        	<?php echo Img::img($member["avatar"]["id"], [ 650, 640 ], true, ['alt' => false, 'class' => false]); ?>
				        </div>
				        <div class="content">
				        	<p class="h2"><?php echo $member["jmeno"]; ?></p>
				        	<p><?php echo $member["dlouhy_popis"]; ?></p>
				        	<?php foreach ($accordions as $key => $accordion): ?>
					        	<div class="accordion">
									<div class="accordion__title"><?php echo $accordion["nadpis"]; ?></div>
									<div class="accordion__content">
										<?php echo $accordion["obsah"]; ?>
									</div>
								</div>
								<!-- <div class="accordion">
									<div class="accordion__title">KONTAKT</div>
									<div class="accordion__content">
										<div class="people">
											<div class="people__item">
												<p>Lorem ipsum</p>
												<a href="#">lorem@holdio.cz</a>
											</div>
											<div class="people__item">
												<p>Lorem ipsum</p>
												<a href="#">lorem@holdio.cz</a>
											</div>
											<div class="people__item">
												<p>Lorem ipsum</p>
												<a href="#">lorem@holdio.cz</a>
											</div>
										</div>
									</div>
								</div> -->
							<?php endforeach; ?>
				        </div>
				    </div>
				</div>
			<?php endforeach; ?>

		<?php elseif ( get_row_layout() == 'companies' ): ?>
			<?php 
				$_companies = array(
				    'post_type' => 'company_cpt',
				    'post_status'    => 'publish',
				    'posts_per_page' => -1,
				    'lang' => $current_language
				);
				$companies = new WP_Query($_companies);
			?>
			<div id="<?php echo get_sub_field("kotva"); ?>" class="block block--companies">
				<div class="container">
					<h2 class="h2"><?php echo get_sub_field("nadpis") ? get_sub_field("nadpis") : pll__("Firmy holdio"); ?></h2>
				</div>
				<div class="table">
					<table>
			    		<thead>
							<tr>
								<th><?php pll_e("Firma"); ?></th>
								<th></th>
								<th><?php pll_e("Popi"); ?>s</th>
								<th><?php pll_e("Služby"); ?></th>
								<th><?php pll_e("Klienti"); ?></th>
								<th></th>
							</tr>
						</thead>
			    		<tbody>
			    			<?php if ( $companies->have_posts() ) : $i = 0; ?>
						        <?php while ( $companies->have_posts() ) : $companies->the_post(); ?>
						        	<?php 
									    global $post;
									    $current_post = $post;
									?>
						        	<?php $services = get_field('sluzby'); ?>
						        	<?php $logos = get_field('klienti'); ?>
						            <tr>
					    				<td>
					    					<a href="<?php the_permalink(); ?>">
					    						<?php echo Img::img(get_field("logo")["id"], [ get_field("logo")["width"], get_field("logo")["height"] ], false, ['alt' => false, 'class' => false]); ?>
					    					</a>
					    				</td>
					    				<td>
					    					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					    				</td>
					    				<td><?php echo get_field("popisek"); ?></td>
					    				<td>
					    					<ul>
					    						<?php foreach( $services as $post ): ?>
					    							<?php setup_postdata($post); ?>
						    						<li>
						    							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						    						</li>
						    					<?php endforeach; ?>
					    					</ul>
					    					<?php 
						    					$post = $current_post;
						    					setup_postdata($post);
					    					?>
					    				</td>
					    				<td>
					    					<div class="grid">
					    						<?php 
													$max_visible = 3;
													$total_logos = count($logos);
													$hidden_count = $total_logos - $max_visible;
													$displayed_logos = array_slice($logos, 0, $max_visible);
												?>

												<?php foreach ($displayed_logos as $logo): ?>
												    <div class="grid__item">
												        <?php echo Img::img($logo["id"], [ $logo["width"], $logo["height"] ], false, ['alt' => false, 'class' => false]); ?>
												    </div>
												<?php endforeach; ?>

												<?php if ($hidden_count > 0): ?>
												    <div class="grid__item grid__item--more">
												        <span>+<?php echo $hidden_count; ?></span>
												    </div>
												<?php endif; ?>

												<?php 
													$items_count = min($total_logos, $max_visible) + ($hidden_count > 0 ? 1 : 0);
													$empty_items = max(0, 4 - $items_count);
												?>

												<?php for ($i = 0; $i < $empty_items; $i++): ?>
												    <div class="grid__item grid__item--empty"></div>
												<?php endfor; ?>
					    					</div>
					    				</td>
					    				<td>
					    					<a href="<?php the_permalink(); ?>" class="button button--sticky big">
												<span class="circle">
													<span class="text"><?php pll_e("Více o firmě"); ?></span>
												</span>
											</a>
					    				</td>
					    			</tr>
						        <?php endwhile; ?>
						        <?php wp_reset_postdata(); ?>
							   
							<?php endif; ?>
			    		</tbody>
			    	</table>
			    	<div class="accordions">
			    		<div class="container">
			    			<?php if ( $companies->have_posts() ) : $i = 0; ?>
						        <?php while ( $companies->have_posts() ) : $companies->the_post(); ?>
						            <?php 
						                global $post;
						                $current_post = $post;
						            ?>
						            <?php $services = get_field('sluzby'); ?>
						            <?php $logos = get_field('klienti'); ?>
						            
						            <div class="accordion">
						                <div class="accordion__title"><?php the_title(); ?></div>
						                <div class="accordion__content">
						                    <div class="inner">
						                        <div class="inner__logo">
						                        	<p class="h4"><?php pll_e("Firma"); ?></p>
						                            <a href="<?php the_permalink(); ?>">
						                                <?php echo Img::img(get_field("logo")["id"], [ get_field("logo")["width"], get_field("logo")["height"] ], false, ['alt' => false, 'class' => false]); ?>
						                            </a>
						                        </div>
						                        
						                        <div class="inner__description">
						                        	<p class="h4"><?php pll_e("Popis"); ?></p>
						                            <?php echo get_field("popisek"); ?>
						                        </div>
						                        
						                        <div class="inner__services">
						                            <p class="h4"><?php pll_e("Služby"); ?></p>
						                            <ul>
						                                <?php foreach( $services as $post ): ?>
						                                    <?php setup_postdata($post); ?>
						                                    <li>
						                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						                                    </li>
						                                <?php endforeach; ?>
						                            </ul>
						                            <?php 
						                                $post = $current_post;
						                                setup_postdata($post);
						                            ?>
						                        </div>
						                        
						                        <div class="inner__clients">
						                            <p class="h4"><?php pll_e("Klienti"); ?></p>
						                            <div class="grid">
							    						<?php 
															$max_visible = 3;
															$total_logos = count($logos);
															$hidden_count = $total_logos - $max_visible;
															$displayed_logos = array_slice($logos, 0, $max_visible);
														?>

														<?php foreach ($displayed_logos as $logo): ?>
														    <div class="grid__item">
														        <?php echo Img::img($logo["id"], [ $logo["width"], $logo["height"] ], false, ['alt' => false, 'class' => false]); ?>
														    </div>
														<?php endforeach; ?>

														<?php if ($hidden_count > 0): ?>
														    <div class="grid__item grid__item--more">
														        <span>+<?php echo $hidden_count; ?></span>
														    </div>
														<?php endif; ?>

														<?php 
															$items_count = min($total_logos, $max_visible) + ($hidden_count > 0 ? 1 : 0);
															$empty_items = max(0, 4 - $items_count);
														?>

														<?php for ($i = 0; $i < $empty_items; $i++): ?>
														    <div class="grid__item grid__item--empty"></div>
														<?php endfor; ?>
							    					</div>
						                        </div>
						                        
						                        <div class="inner__cta">
						                            <a href="<?php the_permalink(); ?>" class="button button--sticky big">
						                                <span class="circle">
						                                    <span class="text"><?php pll_e("Více o firmě"); ?></span>
						                                </span>
						                            </a>
						                        </div>
						                    </div>
						                </div>
						            </div>
						        <?php endwhile; ?>
						        <?php wp_reset_postdata(); ?>
						    <?php endif; ?>
			    		</div>
					    
					</div>	
				</div>
			</div>

		<?php elseif ( get_row_layout() == 'bubliny' ): ?>

			<div id="<?php echo get_sub_field("kotva"); ?>" class="block block--bubbles">
				<div class="wrapper">
					<div class="container">
		        		<div class="inner">
		        			<h2 class="h1"><?php echo get_sub_field("nadpis"); ?></h2>

		        			<div class="bubbles">
		        				<div class="person-left">
		        					<?php echo Img::img(get_sub_field("beleaf")["osoba"]["avatar"]["id"], [ 100, 100 ], false, ['alt' => false, 'class' => false]); ?>
		        					<span><?php echo get_sub_field("beleaf")["osoba"]["jmeno"]; ?></span>
		        				</div>
		        				<div class="bubbles__left">
		        					<?php echo Img::img(get_sub_field("beleaf")["logo"]["id"], [ 130, 38 ], false, ['alt' => false, 'class' => false]); ?>
		        				</div>
		        				<div class="bubbles__center">
		        					<div class="star"></div>
		        					<?php echo Img::img(get_sub_field("holdio")["logo"]["id"], [ 190, 54 ], false, ['alt' => false, 'class' => false]); ?>
		        					<div class="person">
		        						<?php echo Img::img(get_sub_field("holdio")["osoba"]["avatar"]["id"], [ 155, 155 ], false, ['alt' => false, 'class' => false]); ?>
		        						<span><?php echo get_sub_field("holdio")["osoba"]["jmeno"]; ?></span>
		        					</div>
		        				</div>
		        				<div class="bubbles__right--top">
		        					<?php echo Img::img(get_sub_field("ha-soft")["logo_cz"]["id"], [ 150, 60 ], false, ['alt' => false, 'class' => false]); ?>
		        				</div>
		        				<div class="bubbles__right--bottom">
		        					<?php echo Img::img(get_sub_field("ha-soft")["logo_sk"]["id"], [ 125, 50 ], false, ['alt' => false, 'class' => false]); ?>
		        				</div>
		        				<div class="person-right">
		        					<?php echo Img::img(get_sub_field("ha-soft")["osoba"]["avatar"]["id"], [ 124, 124 ], false, ['alt' => false, 'class' => false]); ?>
	        						<span><?php echo get_sub_field("ha-soft")["osoba"]["jmeno"]; ?></span>
		        				</div>
		        			</div>
		        		</div>
		        	</div>
				</div>
	        	
	        	<div id="bubbles-trigger" class="trigger"></div>
	        </div>

       	<?php elseif ( get_row_layout() == 'kontaktni_informace' ): ?>

        	<div id="<?php echo get_sub_field("kotva"); ?>" class="block block--anchors">
				<div class="container">
					<h2 class="h2"><?php echo strip_tags(get_sub_field("nadpis"), '<strong>'); ?></h2>
					<h3 class="h4"><?php echo get_sub_field("podnadpis"); ?></h3>
					<div class="grid">
						<div class="grid__item">
							<?php echo get_sub_field("adresa"); ?>
						</div>
						<div class="grid__item">
							<?php echo get_sub_field("spojeni"); ?>
						</div>
					</div>
				</div>
			</div>

		<?php elseif ( get_row_layout() == 'video_slider' ): ?>

			<?php $videos = get_sub_field("videa"); ?>
			
			<div id="<?php echo get_sub_field("kotva"); ?>" class="block block--video-slider">
	            <div class="video-carousel">
	            	<?php foreach ($videos as $key => $video): ?>
		                <div class="video-carousel-slide" data-label="<?php echo $video["autor"]; ?>" data-title="<?php echo $video["nazev"]; ?>">
		                	<video preload="metadata" muted playsInline src="<?php echo $video["mp4_video"]["url"]; ?>"></video>
		                	<div class="overlay"></div>
		                	<div class="title-area">
		                		<span class="author"><?php echo $video["autor"]; ?></span>
		                		<span class="title"><?php echo $video["nazev"]; ?></span>
		                		<span class="progress"></span>
		                	</div>
		                    <span class="button button--sticky big" data-fancybox href="<?php echo $video["mp4_video"]["url"]; ?>">
								<span class="circle">
									<span class="text"><?php pll_e("Přehrát <br>se zvukem"); ?></span>
								</span>
							</span>
		                </div>
	               	<?php endforeach; ?>
	            </div>
	        </div>

    	<?php endif; ?>

    <?php endwhile; ?>
<?php endif; ?>