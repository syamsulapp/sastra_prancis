<?php
function login_check($session)
{
	if (empty($session)) redirect('cms/login/');
}

function login_member($session)
{
	if (empty($session) and $session == "2") redirect('home');
}

function notif($data)
{
	echo "<div class='alert alert-success'>" . $data . "<button type='button' class='close' data-dismiss='alert'>&times;</button></div>";
}

function warning($data)
{
	echo "<div class='alert alert-error'>" . $data . "<button type='button' class='close' data-dismiss='alert'>&times;</button></div>";
}

function get_tahun($tahun)
{
	$tahun_arr = array();
	for ($i = 0; $i < 5; $i++) {
		$tahun_arr[$tahun - $i] = $tahun - $i;
	}
	return $tahun_arr;
}
// -- Format Currency -- //

function rupiah($jumlah, $book = null)
{
	if ($jumlah <> 0 or !empty($jumlah)) {
		if ($jumlah < 0) {
			$jumlah = substr($jumlah, 1);
			if (isset($book) and $book == 1) $return = "<span class='pull-left'>Rp &nbsp;</span> <span class='pull-right'> -" . number_format($jumlah, 2, ",", ".") . '</span>';
			else if (isset($book) and $book == 2) $return = "<span class='pull-left'>Rp &nbsp;</span> <span class='pull-right'>(-" . number_format($jumlah, 2, ",", ".") . ')</span>';
			else $return = "Rp -" . number_format($jumlah, 2, ",", ".");
		} else {
			if (isset($book) and $book == 1) $return = "<span class='pull-left'>Rp &nbsp;</span> <span class='pull-right'> " . number_format($jumlah, 2, ",", ".") . '</span>';
			else if (isset($book) and $book == 2) $return = "<span class='pull-left'>Rp &nbsp;</span> <span class='pull-right'>(" . number_format($jumlah, 2, ",", ".") . ')</span>';
			else $return = "Rp " . number_format($jumlah, 2, ",", ".");
		}
	} else {
		if (isset($book)) $return = "<span class='pull-left'>Rp &nbsp;</span><span class='pull-right'>0,00</span>";
		else $return = "Rp 0,00";
	}
	return $return;
}

function numberToCurrency($a)
{
	if ($a < 0) {
		$a = substr($a, 1);
		return '-' . number_format($a, 2, ",", ".");
	} else {
		return number_format($a, 2, ",", ".");
	}
}

function currencyToNumber($a)
{
	$b = str_ireplace(".", "", $a);
	return str_replace(",", ".", $b);
}

// -- Layout -- //

function breadcrumbs($data)
{
	$print = "<div class='breadcrumbs'><p>";
	$i = 1;
	foreach ($data as $echo) {
		$print .= ($i > 1) ? ' &raquo ' . $echo : $echo;
		$i += 1;
	}
	$print .= "</p></div>";
	return $print;
}


// -- Hitungan -- //

function percentToID($data)
{
	$datacent = $data / 100;
	$percent = preg_replace('/[.]/', ',', $datacent);
	return $percent;
}

function percentToEN($data)
{
	$percent = preg_replace('/[,]/', '.', $data);
	$datacent = $percent * 100;
	return $datacent;
}

function cek($data)
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

function tanggal($data)
{
	if (!empty($data) and $data != "0000-00-00") return ' ' . date("d/m/Y", strtotime($data)) . ' ';
	else return ' ';
}

function replaceBulan($data)
{
	$bulanArr = array('1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April', '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus', '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember',);
	return $bulanArr[$data];
}

function eraseChar($data)
{
	$hilangslash = preg_replace('/\/+/', '_', $data);
	return preg_replace('/\ +/', '-', $hilangslash);
}

function addChar($data)
{
	$plus = preg_replace('/\_+/', '/', $data);
	return preg_replace('/\-+/', ' ', $plus);
}

function to_url($data)
{
	$p1 = preg_replace('/\.+/', '_', $data);
	$p2 = preg_replace('/\,+/', '~', $p1);
	return preg_replace('/\ +/', '-', $p2);
}

function from_url($data)
{
	$p1 = preg_replace('/\_+/', '.', $data);
	$p2 = preg_replace('/\~+/', ',', $p1);
	return preg_replace('/\-+/', ' ', $p2);
}


function truncate($str, $len)
{
	$tail 	= max(0, $len - 10);
	$trunk 	= substr($str, 0, $tail);
	$trunk 	.= strrev(preg_replace('~^..+?[\s,:]\b|^...~', '...', strrev(substr($str, $tail, $len - $tail))));
	return $trunk;
}

function renameFile($data)
{
	return preg_replace('/\ +/', '_', $data);
}

function in_de($data)
{
	$data_on = base64_encode(serialize($data));
	return preg_replace('/\=+/', '-', $data_on);
}

function un_de($data)
{
	$on_data = preg_replace('/\-+/', '=', $data);
	return unserialize(base64_decode($on_data));
}

function date_sql($data)
{
	$ex = explode('-', $data);
	return $ex[2] . '-' . $ex[1] . '-' . $ex[0];
}

function date_html($data)
{
	$ex = explode('-', $data);
	return $ex[2] . '-' . $ex[1] . '-' . $ex[0];
}

function konversi_tanggal($format, $tanggal = "now")
{
	$en = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
	$id = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember");
	return str_replace($en, $id, date($format, strtotime($tanggal)));
}


function getTheme()
{
	_ci()->load->database();
	_ci()->db->where('code_name', 'theme_set');
	$themes = _ci()->db->get('parameter')->row();
	define('THEME', $themes->value);
}
