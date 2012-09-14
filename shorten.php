<?php

require 'config.php';

header('Content-Type: text/plain;charset=UTF-8');


//$url = isset($_SERVER['REQUEST_URI']) && '/s/' == mb_substr($_SERVER['REQUEST_URI'],0,3) ? mb_substr($_SERVER['REQUEST_URI'],3) : '';

$url = preg_replace('%^(/s/|/shorten.php\??)%','',$_SERVER['REQUEST_URI']);
if(mb_substr($url, 0, 10) == 'http%3A%2F'){
        $url = urldecode($url);
}elseif(mb_substr($url, 0, 11) == 'https%3A%2F'){
        $url = urldecode($url);
}



if(mb_substr($url, 0, 6) == 'http:/' && $url[6] != '/'){
	$url = 'http://' . mb_substr($url, 6);
}elseif(mb_substr($url, 0, 7) == 'https:/' && $url[7] != '/'){
        $url = 'https://' . mb_substr($url, 7);
}

if (in_array($url, $URL_BLACKLIST)) {
	die('Enter a URL.');
}

function randString($length=5, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
{
    $str = '';
    $count = strlen($charset);
    $countLen = $count - 1;
    while ($length--) {
        $str .= $charset[mt_rand(0, $countLen)];
    }
    return $str;
}

$db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
$db->set_charset('utf8');

$url = $db->real_escape_string($url);

$result = $db->query('SELECT slug FROM redirect WHERE url = "' . $url . '" LIMIT 1');
if ($result && $result->num_rows > 0) { // If there’s already a short URL for this URL
	die(SHORT_URL . $result->fetch_object()->slug);
} else {
        $rows = true;
        while ($rows){
                $slug = randString();
		$result = $db->query('SELECT NULL FROM redirect WHERE slug = "' . $slug . '" LIMIT 1');
                $rows = ($result->num_rows > 0);
        }
	if ($db->query('INSERT INTO redirect (slug, url, date, hits) VALUES ("' . $slug . '", "' . $url . '", NOW(), 0)')) {
		header('HTTP/1.1 201 Created');
		echo SHORT_URL . $slug;
	}
}
$db->close();
?>
