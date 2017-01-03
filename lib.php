<?

function muere($s_msg = '', $b_objeto = true, $b_die = true){
	if($b_objeto){
		print_r('<pre>');
		print_r($s_msg);
		print_r('</pre>');
	}else{
		print_r($s_msg);
	}
	if($b_die){
		die;
	}
}



function compare_total($a,$b){
	if($a['total'] == $b['total']){
		return 0;
	}elseif($a['total'] < $b['total']){
		return -1;
	}else{
		return 1;
	}
}