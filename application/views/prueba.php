<?php use Salem\db,Salem\Load;?>
<!DOCTYPE html>
<html>
	<body>
				
			<p>Boring default content</p>
			<img src="img/cosa.jpg"/>
				<?php
				echo $algo;
				$e = ( \url::isAjax() ? 'si' : 'no');
				echo $e;
				/*
				$table = db::table('users');
				$data = $table->select('*')
              ->paginate(2,2,$pag)
              ->execute();
              echo sizeof($data);
              print_r($pag);
              */
              /*
              url::redirect(url::page('int/3'));
              url::redirect('http://iglove.com.uy/');
				// Select the table
				/*$table = db::table('users');
				echo $table->total();
				// Query the database
				$count = $table->count()
               ->where('id','>','1')
               ->execute(); 
               echo $count;*/
				/* //ORM Basic
				$table = db::db('casas','houses','other')->all();
				foreach ($table as $field) {
					echo $field->info();
					echo '';
				}*/
				//db::truncate('casas');
				//db::drop('casas');
				/*
				print_r( db::connection('other')->query('Select * From casas') );
				print_r( db::db('casas',NULL,'other')->select('*')->execute() );
				*/
				/*$houses = load::model('uses');
				print_r($houses->get('a'));*/
				/*
				$table = db::table('users');
				$data = $table->select('username','id')
              ->where('username','!=','loma')
              ->clause('AND')
              ->where('id','!=',0)
              ->order_by('username','DESC')
              ->execute();
              foreach ($data as $value) {
              	echo $value[0].' '.$value[1].'<br>';
              }*/
				/*load::helper('prueba');
				doit();*/
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
	'username'=>'lthofffma',
	'name'=>'Luciano Thfffoma',
	'email'=>'luchothofffma@gmail.com',
	'password'=>'teffst',
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
		        //auth::delete('lthoma');

				//print_r( $db->select('*')->execute() );?>
	<?php //print_r( db::query('Select * FROM casas'));//anda esto?>

	<?php /*echo '<br><br><br><br>';$db = Dingo\datab('mytable'); print_r($db);print_r( $db->select('*')->execute() );*/?>
	</body>
</html>