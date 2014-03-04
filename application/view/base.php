<?php use Salem\View; ?>
<!DOCTYPE html>
<html>
	<body>
		<?php View::new_section('main_content', true); ?>
			
			<p>Boring default content</p>
			<?php var_dump( db::query('SELECT * FROM casas'));
			
		<?php View::end_new_section(); ?>
	</body>
</html>