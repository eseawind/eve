<?php
//扩展全局函数库
function jiami($txt,$key){
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-=_";
	$nh = rand ( 0, 64 );
	$ch = $chars [$nh];
	$mdKey = md5 ( $key . $ch );
	$mdKey = substr ( $mdKey, $nh % 8, $nh % 8 + 7 );
	$txt = base64_encode ( $txt );
	$tmp = '';
	$i = 0;
	$j = 0;
	$k = 0;
	for($i = 0; $i < strlen ( $txt ); $i ++) {
		$k = $k == strlen ( $mdKey ) ? 0 : $k;
		$j = ($nh + strpos ( $chars, $txt [$i] ) + ord ( $mdKey [$k ++] )) % 64;
		$tmp .= $chars [$j];
	}
	return $ch . $tmp;
}

//解密函数
function jiemi($txt,$key){
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-=_";
	$ch = $txt [0];
	$nh = strpos ( $chars, $ch );
	$mdKey = md5 ( $key . $ch );
	$mdKey = substr ( $mdKey, $nh % 8, $nh % 8 + 7 );
	$txt = substr ( $txt, 1 );
	$tmp = '';
	$i = 0;
	$j = 0;
	$k = 0;
	for($i = 0; $i < strlen ( $txt ); $i ++) {
		$k = $k == strlen ( $mdKey ) ? 0 : $k;
		$j = strpos ( $chars, $txt [$i] ) - $nh - ord ( $mdKey [$k ++] );
		while ( $j < 0 )
			$j += 64;
		$tmp .= $chars [$j];
	}
	return base64_decode ( $tmp );
}

function hook($html){
}

function removeHtmlTagsWithExceptions($html, $exceptions = null){ 
    if(is_array($exceptions) && !empty($exceptions)) 
    { 
        foreach($exceptions as $exception) 
        { 
            $openTagPattern  = '/<(' . $exception . ')(\s.*?)?>/msi'; 
            $closeTagPattern = '/<\/(' . $exception . ')>/msi'; 

            $html = preg_replace( 
                array($openTagPattern, $closeTagPattern), 
                array('||l|\1\2|r||', '||l|/\1|r||'), 
                $html 
            ); 
        } 
    } 

    $html = preg_replace('/<.*?>/msi', '', $html); 

    if(is_array($exceptions)) 
    { 
        $html = str_replace('||l|', '<', $html); 
        $html = str_replace('|r||', '>', $html); 
    } 

    return $html; 
} 
