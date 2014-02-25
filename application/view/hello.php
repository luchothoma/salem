<?php use Salem\View; View::extend('base'); ?>


<!-- Main Content -->
<?php View::section('main_content'); ?>

	<p>Hello, World!</p>
	
<?php View::end_section(); ?>


<!-- Optional -->
<?php View::section('optional'); ?>

	<p>WOOOoooOOOooOooo</p>

<?php View::end_section(); ?>