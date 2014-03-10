<?php use Salem\View; ?>
<!DOCTYPE html>
<html>
	<body>
		<?php View::new_section('main_content', true); ?>
			
			<p>Boring default content</p>
			
		<?php View::end_new_section(); ?>

		<?php View::new_section('optional', false); ?>
			
			<p>Something that stay here.</p>
			
		<?php View::end_new_section(); ?>
	</body>
</html>