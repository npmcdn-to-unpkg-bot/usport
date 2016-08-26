<?php

if (!function_exists('gratavarUrl')) {
    /**
     * Gravatar URL from Email address.
     *
     * @param string $email   Email address
     * @param string $size    Size in pixels
     * @param string $default Default image [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $rating  Max rating [ g | pg | r | x ]
     *
     * @return string
     */
    function gravatarUrl($email, $size = 60, $default = 'mm', $rating = 'g')
    {
        return 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($email)))."?s={$size}&d={$default}&r={$rating}";
    }
}

/**
 * Backend menu active.
 *
 * @param $path
 * @param string $active
 *
 * @return string
 */
function setActive($path, $active = 'active')
{
    if (is_array($path)) {
        foreach ($path as $k => $v) {
            $path[$k] = getLang().'/'.$v;
        }
    } else {
        $path = getLang().'/'.$path;
    }

    return call_user_func_array('Request::is', (array) $path) ? $active : '';
}

/**
 * @return mixed
 */
function getLang()
{
    return '';
    // return LaravelLocalization::getCurrentLocale();
}

/**
 * @param null $url
 *
 * @return mixed
 */
function langURL($url = null)
{

    //return LaravelLocalization::getLocalizedURL(getLang(), $url);

    return getLang().$url;
}

/**
 * @param $route
 * @param array $parameters
 *
 * @return mixed
 */
function langRoute($route, $parameters = array())
{
    return URL::route($route, $parameters);
}

/**
 * @param $route
 *
 * @return mixed
 */
function langRedirectRoute($route)
{
    return Redirect::route($route);
}

/**
 * Get words from string...
 * @param string $str: String of words
 * @param integer $max: Maximum words
 * @param char $char: is Delimiter
 * @param string $end: Apend string if string will be cutted
 */
function subwords( $str, $max = 24, $char = ' ', $end = '...' ) {
    $str = trim( $str ) ;
    $str = $str . $char ;
    $len = strlen( $str ) ;
    $words = '' ;
    $w = '' ;
    $c = 0 ;
    for ( $i = 0; $i < $len; $i++ ) {
        if ( $str[$i] != $char ) {
            $w = $w . $str[$i] ;
        } else {
            if ( ( $w != $char ) and ( $w != '' ) ) {
                $words .= $w . $char ;
                $c++ ;
                if ( $c >= $max ) {
                    break ;
                }
                $w = '' ;
            }
        }
    }
    if ( $i+1 >= $len) {
        $end = '' ;
    }
    return trim( $words ) . $end ;
}

/**
 * file get content
 * @param  [type] $url [description]
 * @return [type]      [description]
 */
function getData ($url) {
    $result = @file_get_contents($url);
    if ($result === false) {
        \Log::error('Cannot get data from url:' . $url);
        return ['error'=>1005];//response()->json(array('error'=>1005, 'data'=>'', 'message'=>'cannot get content'));
    }
    return ['error'=>0, 'data'=>json_decode($result)];// response()->json(array('error'=>0, 'data'=>json_decode($result), 'message'=>''));
}

/**
 * postData description
 * @param  [type] $url      [description]
 * @param  [type] $postData [description]
 * @return [type]           [description]
 */
function postData ($url, $postData) {
    // use key 'http' even if you send the request to https://...
    try {
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($postData)
            )
        );
        $context  = @stream_context_create($options);
        $result = @file_get_contents($url, false, $context);

        return $result;
    } catch (Exception $e) {
        return false;
    }
    
}