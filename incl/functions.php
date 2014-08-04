<?php
// ====================FUNCTIONS=====================================
function startSession() {
    if ( session_id() ) return true;
    else return session_start();
}

startSession();

function language($lang){

if ((!isset($_COOKIE['lang'])) || (!is_numeric($_COOKIE['lang'])) || ($_COOKIE['lang']>3) || (empty($_SESSION['lang'])) || ($_SESSION['lang'] != $lang) )
	{
		$lang = langtcook($lang);
		setcookie('lang',$lang,time() + (86400 * 7));
		$_SESSION['lang'] = langfcook($lang);
		$lang = langfcook($lang);
	}

	return $lang;
}

function langtcook($arg) {

	if ($arg == "rus") {$flag = "2";}
	elseif ($arg == "eng") {$flag = "3";}
	else {$flag = "1";}

	return $flag;
}

function langfcook($arg) {

	if ($arg == "2") {$flag = "rus";}
	elseif ($arg == "3") {$flag = "eng";}
	else {$flag = "ukr";}

	return $flag;
}

function flags_url($lang){

$args = "";
global $site;
$i = false;
$http = "http://".$_SERVER['HTTP_HOST'];
$url = rtrim(ltrim($_SERVER['REQUEST_URI'], '/'), '/');
$url = explode('/',$url);
	foreach ($url as $val)
	{
	    $args[] = urldecode($val);

	    if ($i == false){
	    	if ((($args['0'] != "rus") AND ($args['0'] != "eng")) AND ($lang != "ukr")){
	    		$i = true; echo $site.$lang."/".substr($_SERVER['REQUEST_URI'],1);
	    	}
	    	elseif ((($args['0'] == "rus") OR ($args['0'] == "eng")) AND ($lang != "ukr")){
	    		$i = true; echo $site.$lang."/".substr($_SERVER['REQUEST_URI'],5);
	    	}
	    	elseif ((($args['0'] == "rus") OR ($args['0'] == "eng")) AND ($lang == "ukr")){
	    		$i = true; echo $site.substr($_SERVER['REQUEST_URI'],5);
	    	}
	    	else {
	    		$i = true; echo $site.substr($_SERVER['REQUEST_URI'],1);
	    	}

		}
	   // echo urldecode($val);
	}

}

function menu($lang)
{
	$database = new medoo();
    $menus = $database->select("menus", ["id", "link_item", "menu", "parent", "orders", $lang, "class"], 
        [
        "active" => "1",
        "ORDER" => ["orders ASC", "id ASC"]
        ]);
// echo $database->last_query();   
// var_dump($database->error());
    return $menus;
}

function news($lang, $lim_from, $lim_step)
{
	$database = new medoo();
    $news = $database->select("news", ["link_item", "img", $lang, "top", "pos"], 
        [
        "active" => "1",
        "ORDER" => ["top ASC", "id ASC", "pos ASC"],
        "LIMIT" => [$lim_from, $lim_step]
        ]);

    return $news;
}

function common_txt($lang)
{
	$max = array("no_text" => "ERROR");
	$database = new medoo();
    $sel = $database->select("texts", ["link_item", $lang]);
		foreach($sel as $data)
			{
				$mix = $data["link_item"];
				array_push($max[$mix] = $data[$lang]);
				
			}

    return $max;
}

function cases($lang, $sel)
{
	$database = new medoo();

	$name = "name_".$lang;
	$model = "model_".$lang;
	$about = "about_".$lang;

    $cases = $database->select("cases", ["link_item", "img", $name, $model, $about, "price", "price_old", "disc", "stock", "top", "new", "sale"], 
        [
        "AND" => [
        	"active" => "1",
        	$sel => "1"
        	],
        "ORDER" => ["id DESC"],
        "LIMIT" => ["3"]
        ]);

    return $cases;
}












function is_valid_email($email) 
    {
          $result = true;
          if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)) {
            $result = false;
          }
          return $result;
    }

function mailto($to,$subject,$message,$from,$exit)
    {
    
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= $from."\r\n";

        mail($to, $subject, $message, $headers);
        if ($exit == '1'){exit;}
    
    }
// ==================================================================





?>
