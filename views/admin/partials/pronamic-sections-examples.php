<?php $example_post_id = get_option( 'pronamic_sections_example_post_id', 0 ); ?>
<?php if ( empty( $example_post_id ) ) : ?>
	<p><a class="button button-primary" href="<?php echo add_query_arg( array( 'example-data' => 'install' ) ); ?>"><?php _e( 'Install Example Data', 'pronamic-sections-domain' ); ?></a></p>
	<span class="howto"><?php _e( 'Install the example data to see the usages of Bootstrap, Foundation and others. All example data is removable afterwards.', 'pronamic-sections-domain' ); ?></span>
<?php else: ?>
	<h3>Bootstrap</h3>
	<h4>Horizontal Tabs</h4>
	<div class="pronamic-section-example-group-holder pronamic_section_clearfix">
		<div class="pronamic-section-example-group-code">
			<textarea style="width:100%;min-height:300px;white-space:pre;word-wrap: normal;overflow-x: scroll;">
&lt;?php if ( function_exists( 'the_pronamic_sections' ) ) : ?&gt;
	&lt;?php $sections = the_pronamic_sections( get_the_ID() ); ?&gt;
	&lt;?php if ( ! empty( $sections ) ) : ?&gt;
		&lt;ul class=&quot;nav nav-tabs pronamic_section_clearfix&quot;&gt;
			&lt;?php foreach ( $sections as $section ) : ?&gt;
			&lt;li &lt;?php if ( 1 == $section-&gt;get_position() ) : ?&gt; class=&quot;active&quot;&lt;?php endif; ?&gt;&gt;
				&lt;a data-toggle=&quot;tab&quot; href=&quot;#&lt;?php echo sanitize_title( $section-&gt;get_title() ); ?&gt;&quot;&gt;&lt;?php echo $section-&gt;get_title(); ?&gt;&lt;/a&gt;
			&lt;/li&gt;
			&lt;?php endforeach; ?&gt;
		&lt;/ul&gt;
		&lt;div class=&quot;tab-content pronamic_section_clearfix&quot;&gt;
			&lt;?php foreach ( $sections as $section ) : ?&gt;
				&lt;div id=&quot;&lt;?php echo sanitize_title( $section-&gt;get_title() ); ?&gt;&quot; class=&quot;tab-pane &lt;?php if ( 1 == $section-&gt;get_position() ) : ?&gt;active&lt;?php endif; ?&gt;&quot;&gt;
					&lt;?php echo $section-&gt;get_content(); ?&gt;
				&lt;/div&gt;
			&lt;?php endforeach; ?&gt;
		&lt;/div&gt;
	&lt;?php endif; ?&gt;
&lt;?php endif; ?&gt;
			</textarea>
		</div>
		<div class="pronamic-section-example-group-preview">
			<h5><?php _e( 'Preview', 'pronamic-sections-domain' ); ?></h5>
			<?php if ( function_exists( 'the_pronamic_sections' ) ) : ?>
				<?php $sections = the_pronamic_sections( $example_post_id ); ?>
				<?php if ( ! empty( $sections ) ) : ?>
					<ul class="nav nav-tabs pronamic_section_clearfix">
						<?php foreach ( $sections as $section ) : ?>
						<li <?php if ( 1 == $section->get_position() ) : ?> class="active"<?php endif; ?>>
							<a data-toggle="tab" href="#<?php echo sanitize_title( $section->get_title() ); ?>"><?php echo $section->get_title(); ?></a>
						</li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content pronamic_section_clearfix">
						<?php foreach ( $sections as $section ) : ?>
							<div id="<?php echo sanitize_title( $section->get_title() ); ?>" class="tab-pane <?php if ( 1 == $section->get_position() ) : ?>active<?php endif; ?>">
								<?php echo $section->get_content(); ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
	<h4>Vertical Tabs</h4>

	<hr/>
	<h3>Foundation</h3>
	<hr/>
	<p><a class="button button-primary" href="<?php echo add_query_arg( array( 'example-data' => 'uninstall' ) ); ?>"><?php _e( 'Uninstall Example Data', 'pronamic-sections-domain' ); ?></a></p>
	<span class="howto"><?php _e( 'This will remove the post and its sections used in the above examples', 'pronamic-sections-domain' ); ?></span>
<?php endif; ?>