<?php if ( !defined('MITH') ) {exit;} ?>

<?php 

if (!empty($form["email"]) && (!empty($form["puk"]))){

  $users = users($form["email"]);
  
  if (($form["email"] == $users["0"]["email"]) && ($users["0"]["password"] == md5(md5($form["puk"])))) {

    $_SESSION['user'] = $users["0"]["user"];
    
  }
}

  require_once("admin/layout/head.php");


if (!empty($_SESSION['user'])){

  if ($loc["1"] == "news"){

    require_once("admin/layout/news.php");

  }elseif ($loc["1"] == "cars"){

    require_once("admin/layout/cars.php");

  }elseif ($loc["1"] == "cases"){

    require_once("admin/layout/cases.php");

  }elseif ($loc["1"] == "images"){

    require_once("admin/layout/images.php");

  }

exit;  
}


?>
