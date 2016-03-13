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

ob_start("html_compress");
ob_implicit_flush(1);

function html_compress($html){

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
}

$html = preg_replace_callback("/(&#[0-9]+;)/", function($m){return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES");}, $html); 
$html = preg_replace_callback("/([a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})/", function($m){return encode2($m[1]);}, $html); 

$HTTP_ACCEPT_ENCODING = $_SERVER["HTTP_ACCEPT_ENCODING"];
if(headers_sent()){
$encoding = false;
}elseif( strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false ){
$encoding = 'x-gzip';
}elseif( strpos($HTTP_ACCEPT_ENCODING,'gzip') !== false ){
$encoding = 'gzip';
}else{
$encoding = false;
}

return $html;
ob_end_clean();
}
?>