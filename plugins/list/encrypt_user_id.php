<?php
	$encrypt_1 = array("v","b","c","d","u","f","g","h","z","j");
	$encrypt_2 = array("k","l","m","n","x","p","q","r","s","t");
	$decrypt_1 = array("v"=>0,"b"=>1,"c"=>2,"d"=>3,"u"=>4,"f"=>5,"g"=>6,"h"=>7,"z"=>8,"j"=>9);
	// $id = 3469;
	function simple_id_encrypt($id) {
		global $encrypt_1, $encrypt_2;
		$str = $id . "";
		$len = strlen($str);
		print "str = $str; len=$len<br/>";
		$ret = $len;
		for ($i = 0; $i < $len; $i++)
		    $ret .= $encrypt_1[intval($str[$i])];
		for ($i = 0; $i < 4; $i++) {
			$letter = $encrypt_2[rand()%10];
			if (rand()%2==1) $letter = strtoupper($letter);
			$ret .= $letter;
		}
		return $ret;
	}
	function simple_id_decrypt($str) {
		global $encrypt_1, $encrypt_2, $decrypt_1;
		$digits = intval($str[0]);
		$key_id = "";
		for ($i = 1; $i < $digits + 1; $i++)
			$key_id .= $decrypt_1[$str[$i]];
		return $key_id;
	}	
//	$ID = simple_id_encrypt($id);	
//	print "id>" . $ID . "<br/>";
//	print "id<" . simple_id_decrypt($ID) . "<br/>";

?>