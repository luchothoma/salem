<?php use Salem\db,Salem\Load;?>
<!DOCTYPE html>
<html>
	<body>
				
			<p>Boring default content</p>
			<img src="img/cosa.jpg"/>
				<?php 
				/*
				$db = db::db('casas'); 
				print_r($db->select('*')->execute());

				$values=array(
					'nombre' => 'ho',
					'edad' => '12'
				);
				$rules=array(
					'nombre' => array('required','length:2to4'),
					'edad' => array('required','int','range:0to12')
				);

				//$result = valid::test($values,$rules);
				//print_r($result);
				valid::test($values,$rules);
				if ( valid::success() ){
					echo 'bien';
				}else{
					echo 'mal';
				}*/
				/*auth::create(array(
	'username'=>'lthoma',
	'name'=>'Luciano Thoma',
	'email'=>'luchothoma@gmail.com',
	'password'=>'test',
	'type'=>'admin'
));*/
				//echo auth::check('luchothoma@gmail.com',auth::hash('test'));
				//echo auth::login('luchothoma@gmail.com','test');
				//auth::logout();


				//print_r( $db->select('*')->execute() );?>
	<?php //print_r( db::query('SELECT * FROM casas'));//anda esto?>

	<?php /*echo '<br><br><br><br>';$db = Dingo\datab('mytable'); print_r($db);print_r( $db->select('*')->execute() );*/?>
	</body>
</html>