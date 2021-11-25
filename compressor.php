<?
/*
Copyright (c) 2016 Dario Passariello
*/

ob_start("compression");
ob_implicit_flush(1);

function compression($html){

  mb_substitute_character("none");
  mb_internal_encoding($GLOBALS['CHAR_ENCODE']);
  mb_http_output($GLOBALS['CHAR_ENCODE']);
  mb_http_input($GLOBALS['CHAR_ENCODE']);
  mb_regex_encoding($GLOBALS['CHAR_ENCODE']);

  $html = mb_convert_encoding($html, $GLOBALS['CHAR_ENCODE'], $GLOBALS['CHAR_ENCODE']);
  $html = htmlspecialchars_decode(htmlspecialchars($html, ENT_SUBSTITUTE, $GLOBALS['CHAR_ENCODE']));

  $html = SpecialCharacter($html);
  $html = utf8_encode($html);

  $html = preg_replace('/<!-(.*)->/Uis', '', $html);
  $html = preg_replace('/[\r\n\t\s]+/s', ' ', $html);
  $html = preg_replace('#/\*.*?\*/#', ' ', $html);
  $html = preg_replace('/^\s+/', ' ', $html);
  $html = preg_replace('/ +/', ' ', $html);
  $html = preg_replace('/> +</', '><', $html);
  $html = preg_replace('/[[:blank:]]+/', ' ', $html);
  $html = preg_replace('/<!--[if IE]>/', $html, $html);
  $html = preg_replace('/<![endif]-->/', $html, $html);

  $html = str_replace('{!','<!', $html);
  $html = str_replace('--}','-->', $html);
  $html = str_replace(']}',']>', $html);
  $html = preg_replace_callback("/(&#[0-9]+;)/", function($m){return mb_convert_encoding($m[1], $GLOBALS['CHAR_ENCODE'], "HTML-ENTITIES");}, $html);
  $html = preg_replace_callback("/([a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})/", function($m){return mb_convert_encoding($m[1], $GLOBALS['CHAR_ENCODE'], "HTML-ENTITIES");}, $html);

  clearstatcache();
  flush();

  return trim($html);
}
?>
