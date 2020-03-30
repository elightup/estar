	<footer class="footer">
		<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
			<div class="footer-widgets">
				<div class="container">
					<?php dynamic_sidebar( 'sidebar-1' ); ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="site-info">
			<?php echo wp_kses_post( EStar\Settings::get( 'footer_copyright' ) ); ?>
		</div>
	</footer>

	<?php wp_footer() ?>
</body>
</html>