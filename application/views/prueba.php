<?php use Salem\db,Salem\Load;?>
<!DOCTYPE html>
<html>
	<body>
				
			<p>Boring default content</p>
			<img src="img/cosa.jpg"/>
				<?php 
				session::init();
				$db = db::db('casas'); 
				print_r($db->select('*')->execute());
				//print_r( $db->select('*')->execute() );?>
	<?php //print_r( db::query('SELECT * FROM casas'));?>

	<?php /*echo '<br><br><br><br>';$db = Dingo\datab('mytable'); print_r($db);print_r( $db->select('*')->execute() );*/?>
	</body>
</html>