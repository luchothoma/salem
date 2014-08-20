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
				//echo auth::check('luchothoma@gmail.com','test');
				//echo auth::login('lgtg@op.com','test');
				//auth::logout();
				/*
				echo auth::id()."\r\n";
				echo auth::email()."\r\n";
				echo auth::name()."\r\n";
				echo auth::username()."\r\n";
				echo auth::type()."\r\n";
				echo auth::password()."\r\n";
				//echo auth::data()."\r\n";
				echo auth::valid()."\r\n";
				echo auth::isBanned()."b\r\n";
				if (auth::exist("luchothoma@gmail.com")){
					echo "existe";
				}else{
					echo "no existe";
				}
				print_r(auth::get('lthoma'));
				*/
				/*
				auth::update('1')
		           ->name('Lucho Gini')
		           ->type('admin')
		           ->password('test')
		           ->data('fecha','12/9/2000')
		           ->save();
				*/
		        //echo auth::name();
		        //echo auth::data('fecha');
		        //echo auth::data('altura');
		        auth::delete('lthoma');
				//print_r( $db->select('*')->execute() );?>
	<?php //print_r( db::query('SELECT * FROM casas'));//anda esto?>

	<?php /*echo '<br><br><br><br>';$db = Dingo\datab('mytable'); print_r($db);print_r( $db->select('*')->execute() );*/?>
	</body>
</html>