<?php

include_once('lib.php');


$a_compis = array('Compi 1','Compi 2','Compi 3', 'Compi 4', 'Compi 5');
//shuffle($a_compis);
$a_diasst = array('Lunes','Martes','Miercoles','Jueves','Viernes');
//shuffle($a_diasst);

$i_compis = count($a_compis);

$s_options = '';
foreach($a_compis as $compi){
	$s_options .= '<option value="'.$compi.'">'.$compi.'</option>'.PHP_EOL;
}
$a_options = array();
foreach($a_diasst as $dia){
	$a_options[$dia] = $s_options;
}

$s_result = '';

if(isset($_POST['reparto'])){

	$a_dias = array();
	
	foreach($a_diasst as $dia){
		if(isset($_POST[$dia])){
			$a_dias[$dia] = array('total'=>count($_POST[$dia]),'personas'=>$_POST[$dia]);
		}else{
			$a_dias[$dia] = array('total'=>0,'personas'=>array());
		}
	}
	
	uasort($a_dias,'compare_total');

	$a_sinelegir = array();

	$a_elegidos = array();
	$a_dias_elegidos = array();

	foreach($a_dias as $dia=>$data){
		$a_options[$dia] = '';
		foreach($a_compis as $compi){
			$b_form = false;
			foreach($data['personas'] as $persona){
				if($compi == $persona){
					$a_options[$dia] .= '<option selected="selected" value="'.$compi.'">'.$compi.'</option>'.PHP_EOL;
					$b_form = true;
				}
			}
			if(!$b_form){
				$a_options[$dia] .= '<option value="'.$compi.'">'.$compi.'</option>'.PHP_EOL;
			}
		}

		if(count($data['personas'])>0){
			$b_elegido = false;
			$i_contador = count($a_compis)*3;
			srand(str_replace(' ','',str_replace('.','',microtime())));
			while(!$b_elegido && $i_contador > 0){
				$elegido = rand(0,$data['total']-1);
				if(!isset($a_elegidos[$data['personas'][$elegido]])){
					$a_elegidos[$data['personas'][$elegido]] = $dia;
					$a_dias_elegidos[$dia] = $data['personas'][$elegido];
					$b_elegido = true;
				}else{
					$i_contador--;
				}
			}
			
		}else{
			$a_sinelegir[] = $dia;
		}
	}


	foreach($a_compis as $compi){
		if(!isset($a_elegidos[$compi])){
			foreach($a_diasst as $dia){
				if(!isset($a_dias_elegidos[$dia])){
					$a_elegidos[$compi] = $dia;
					$a_dias_elegidos[$dia] = $compi;
					break;
				}
			}
		}
	}

	
	foreach($a_elegidos as $compi=>$dia){
		$s_result .= '<p/>'.$dia.' => '.$compi.'</p>'.PHP_EOL;
	}

}



$s_form = '';
foreach($a_diasst as $dia){
	$s_form .= '<div class="select_all"><p class="select_title">'.$dia.'</p><select multiple id="'.$dia.'" name="'.$dia.'[]" size="'.$i_compis.'">'.PHP_EOL.
				$a_options[$dia].'</select></div>'.PHP_EOL;
}






?><html>

<head>
	<link type="text/css" rel="stylesheet" media="all" href="style.css" />
</head>

<body>

<div class="caja">
	<form name="reparto" method="POST">
		<?=$s_form?>
		<input type="hidden" id="reparto" name="reparto" value="1"/>
		<div class="clear"></div>
		<div class="caja_centrada">
			<input type="submit" value="Repartir"/>
		</div>
	</form>
</div>

<div class="caja">
<?=$s_result?>
</div>

</body>

</html>