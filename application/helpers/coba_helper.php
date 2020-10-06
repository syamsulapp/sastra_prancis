<?php
function generateCode($lght) {
	$possible = '301291';
	$code = '';
	$i = 0;
	while ($i < $lght) {
		$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
	$i++;
	}return $code;
}
function ascii2hex($ascii) {
	$hex = '';
	for ($i = 0; $i < strlen($ascii); $i++) {
		$byte = strtoupper(dechex(ord($ascii{$i})));
		$byte = str_repeat('0', 2 - strlen($byte)).$byte;
		$hex.=$byte."";
	}
	$gCode = substr(md5(generateCode(6)), 0, 6);
	$rHex = $gCode.$hex;
	return strtolower($rHex);
}
function hex2ascii($hex){$ascii='';
	$hex=str_replace(" ", "", $hex);
	$lHex = strlen($hex);
	for($i=6; $i<$lHex; $i=$i+2) {
		$ascii.=chr(hexdec(substr($hex, $i, 2)));
	}
	$rGanjil = substr($ascii, -2, 1);
	$rGenap = substr($ascii, -1, 1);
	return($ascii.$rGanjil. $rGenap);
}
function returnDec($rDec){
	$r2Dec = '';
	$rDec = trim($rDec);
	$lDec = strlen($rDec)-4;
	$rGanjil = substr($rDec, -2, 1);
	$rGenap = substr($rDec, -1, 1);
	for($i=0; $i<$lDec; $i++){
		if($i%2 == 0){
			$sum = $rGanjil;
		}else{
			$sum = $rGenap;
		}
		$wDec = substr($rDec, $i, 1);
		$asDec = ord($wDec);
		$r1Dec = $asDec-$i-$sum;
		$r2Dec .= chr($r1Dec);
		//$r2Dec .= chr($r1Dec);
	}
	return $r2Dec;
}
function sdxDec($decText){
	$resDec = returnDec(hex2ascii($decText));
	return $resDec;
}
?>