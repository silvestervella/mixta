			<!-- footer -->
			<footer>
					<?php
						$taxs = array('collection' , 'item_type');
						foreach($taxs as $tax) {
							$labels = get_taxonomy( $tax );
							echo '<div class="ft-section">';
							echo '<h3>'.$labels->label.'</h3>';
							$terms = get_terms( array(
								'taxonomy' => $tax,
								'hide_empty' => false,
							) );
							foreach($terms as $term) {
									if (isset($term)) {
										echo '<a href="'.get_term_link($term->name , $tax).'">' . $term->name . '</a>';
									}
							}
							echo '</div>'; 
						}
					?>
			</footer>
			<!-- /footer -->
		</div>
		<!-- /wrapper -->
		<div id="copy">&copy;MixtaDrama - <?php echo date("Y"); ?></div>

		<?php wp_footer(); ?>

	</body>
</html>
