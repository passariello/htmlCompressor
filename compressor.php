<?
/*
The MIT License (MIT)

Copyright (c) 2016 Dario Passariello

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
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
$html = preg_replace_callback("/([a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})/", function($m){return encode2($m[1]);}, $html);

clearstatcache();
flush();

return trim($html);
}
?>
