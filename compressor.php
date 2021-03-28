<?php

/*
Created by Dario Passariello

The MIT License (MIT)
Copyright (c) 2016 - 2021 Dario Passariello
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

INTASTALLATION: 
PUT AS INCLUDE OR REQUIRE AT TOP OF INDEX FILE
*/

	function compression( $html ){

		$html = preg_replace( '/<!-(.*)->/Uis', '', $html );
		$html = preg_replace( '/[\r\n\t\s]+/s', ' ', $html );
		$html = preg_replace( '#/\*.*?\*/#', ' ', $html );
		$html = preg_replace( '/^\s+/', ' ', $html );
		$html = preg_replace( '/ +/', ' ', $html );
		$html = preg_replace( '/> +</', '><', $html );
		$html = preg_replace( '/[[:blank:]]+/', ' ', $html );
		$html = preg_replace( '/<!--[if IE]>/', $html, $html );
		$html = preg_replace( '/<![endif]-->/', $html, $html );

		$html = str_replace( '{!','<!', $html );
		$html = str_replace( '--}','-->', $html );
		$html = str_replace( ']}',']>', $html) ;
		$html = preg_replace_callback( '/(&#[0-9]+;)/', function( $m ){ 
      return mb_convert_encoding( $m[1], $GLOBALS['CHAR_ENCODE'], 'HTML-ENTITIES' );
    }, $html);

		clearstatcache();
    return trim( $html );

	}

	ob_start( 'compression' );
	ob_implicit_flush(1);

?>
