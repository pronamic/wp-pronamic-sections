<?php $example_post_id = get_option( 'pronamic_sections_example_post_id', 0 ); ?>
<?php if ( empty( $example_post_id ) ) : ?>
	<p><a class="button button-primary" href="<?php echo add_query_arg( array( 'example-data' => 'install' ), admin_url( 'admin.php' ) ); ?>"><?php _e( 'Install Example Data', 'pronamic-sections-domain' ); ?></a></p>
	<span class="howto"><?php _e( 'Install the example data to see the usages of Bootstrap, Foundation and others. All example data is removable afterwards.', 'pronamic-sections-domain' ); ?></span>
<?php else: ?>
	<h3>Bootstrap</h3>
	<div class="form-invalid">
		<strong><?php _e( 'You MUST be using Twitter Bootstrap in your theme for it to show correctly', 'pronamic-sections-domain' ); ?></strong>
	</div>
	<p><?php printf( __( 'Twitter Bootstrap uses different class names to change the style. If you want to use one of the other examples then change the markup to match <a target="_blank" href="%s">theirs</a>', 'pronamic-sections-domain' ), 'http://getbootstrap.com/components/#nav' ); ?></p>
	<div class="pronamic-section-example-group-holder pronamic_section_clearfix">
		<div class="pronamic-section-example-group-code">
<div style="background: #ffffff; overflow:auto;width:auto;border:solid gray;border-width:.1em .1em .1em .8em;padding:.2em .6em;"><pre style="margin: 0; line-height: 125%"><span style="color: #4c8317">&lt;?php</span> <span style="color: #0000aa">if</span> ( <span style="color: #00aaaa">function_exists</span>( <span style="color: #aa5500">&#39;the_pronamic_sections&#39;</span> ) ) : <span style="color: #4c8317">?&gt;</span>
    <span style="color: #4c8317">&lt;?php</span> <span style="color: #aa0000">$sections</span> = the_pronamic_sections( <span style="color: #aa0000">$example_post_id</span> ); <span style="color: #4c8317">?&gt;</span>
    <span style="color: #4c8317">&lt;?php</span> <span style="color: #0000aa">if</span> ( ! <span style="color: #0000aa">empty</span>( <span style="color: #aa0000">$sections</span> ) ) : <span style="color: #4c8317">?&gt;</span>
        &lt;ul class=&quot;nav nav-tabs pronamic_section_clearfix&quot;&gt;
            <span style="color: #4c8317">&lt;?php</span> <span style="color: #0000aa">foreach</span> ( <span style="color: #aa0000">$sections</span> <span style="color: #0000aa">as</span> <span style="color: #aa0000">$section</span> ) : <span style="color: #4c8317">?&gt;</span>
            &lt;li <span style="color: #4c8317">&lt;?php</span> <span style="color: #0000aa">if</span> ( <span style="color: #009999">0</span> == <span style="color: #aa0000">$section</span>-&gt;<span style="color: #1e90ff">get_position</span>() ) : <span style="color: #4c8317">?&gt;</span> class=&quot;active&quot;<span style="color: #4c8317">&lt;?php</span> <span style="color: #0000aa">endif</span>; <span style="color: #4c8317">?&gt;</span>&gt;
                &lt;a data-toggle=&quot;tab&quot; href=&quot;#<span style="color: #4c8317">&lt;?php</span> <span style="color: #0000aa">echo</span> <span style="color: #aa0000">$section</span>-&gt;<span style="color: #1e90ff">get_slug</span>(); <span style="color: #4c8317">?&gt;</span>&quot;&gt;<span style="color: #4c8317">&lt;?php</span> <span style="color: #0000aa">echo</span> <span style="color: #aa0000">$section</span>-&gt;<span style="color: #1e90ff">get_title</span>(); <span style="color: #4c8317">?&gt;</span>&lt;/a&gt;
            &lt;/li&gt;
            <span style="color: #4c8317">&lt;?php</span> <span style="color: #0000aa">endforeach</span>; <span style="color: #4c8317">?&gt;</span>
        &lt;/ul&gt;
        &lt;div class=&quot;tab-content pronamic_section_clearfix&quot;&gt;
            <span style="color: #4c8317">&lt;?php</span> <span style="color: #0000aa">foreach</span> ( <span style="color: #aa0000">$sections</span> <span style="color: #0000aa">as</span> <span style="color: #aa0000">$section</span> ) : <span style="color: #4c8317">?&gt;</span>
                &lt;div id=&quot;<span style="color: #4c8317">&lt;?php</span> <span style="color: #0000aa">echo</span> <span style="color: #aa0000">$section</span>-&gt;<span style="color: #1e90ff">get_slug</span>(); <span style="color: #4c8317">?&gt;</span>&quot; class=&quot;tab-pane <span style="color: #4c8317">&lt;?php</span> <span style="color: #0000aa">if</span> ( <span style="color: #009999">0</span> == <span style="color: #aa0000">$section</span>-&gt;<span style="color: #1e90ff">get_position</span>() ) : <span style="color: #4c8317">?&gt;</span>active<span style="color: #4c8317">&lt;?php</span> <span style="color: #0000aa">endif</span>; <span style="color: #4c8317">?&gt;</span>&quot;&gt;
                    <span style="color: #4c8317">&lt;?php</span> <span style="color: #0000aa">echo</span> <span style="color: #aa0000">$section</span>-&gt;<span style="color: #1e90ff">get_content</span>(); <span style="color: #4c8317">?&gt;</span>
                &lt;/div&gt;
            <span style="color: #4c8317">&lt;?php</span> <span style="color: #0000aa">endforeach</span>; <span style="color: #4c8317">?&gt;</span>
        &lt;/div&gt;
    <span style="color: #4c8317">&lt;?php</span> <span style="color: #0000aa">endif</span>; <span style="color: #4c8317">?&gt;</span>
<span style="color: #4c8317">&lt;?php</span> <span style="color: #0000aa">endif</span>; <span style="color: #4c8317">?&gt;</span>
</pre></div>
		</div>
		<div class="pronamic-section-example-group-preview">
			<h5><?php _e( 'Preview', 'pronamic-sections-domain' ); ?></h5>
			<?php if ( function_exists( 'the_pronamic_sections' ) ) : ?>
				<?php $sections = the_pronamic_sections( $example_post_id ); ?>
				<?php if ( ! empty( $sections ) ) : ?>
					<ul class="nav nav-tabs pronamic_section_clearfix">
						<?php foreach ( $sections as $section ) : ?>
						<li <?php if ( 0 == $section->get_position() ) : ?> class="active"<?php endif; ?>>
							<a data-toggle="tab" href="#<?php echo $section->get_slug(); ?>"><?php echo $section->get_title(); ?></a>
						</li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content pronamic_section_clearfix">
						<?php foreach ( $sections as $section ) : ?>
							<div id="<?php echo $section->get_slug(); ?>" class="tab-pane <?php if ( 0 == $section->get_position() ) : ?>active<?php endif; ?>">
								<?php echo $section->get_content(); ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
	<hr/>
	<h3>Foundation</h3>
	<hr/>
	<p><a class="button button-primary" href="<?php echo add_query_arg( array( 'example-data' => 'uninstall' ), admin_url( 'admin.php' ) ); ?>"><?php _e( 'Uninstall Example Data', 'pronamic-sections-domain' ); ?></a></p>
	<span class="howto"><?php _e( 'This will remove the post and its sections used in the above examples', 'pronamic-sections-domain' ); ?></span>
<?php endif; ?>