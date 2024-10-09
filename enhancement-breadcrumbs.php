<?php
/**
 * Breadcrumb enhancement plugin.
 *
 * Simply adds breadcrumbs to make search engines find the enhancement
 *
 * @author William Small <webdev@willgetitdone.com>
  */

global $Wcms;

if ( ! $Wcms->loggedIn) {
    if (defined('VERSION')) {
        $Wcms->addListener('footer', 'displayEnhancements');
    }
}

function mad_breadcrumbs() {
  $pageURL = 'http';
  if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
  $pageURL .= "://";
  if ($_SERVER["SERVER_PORT"] != "80") {
   $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
  } else {
   $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
  }
  $page_URI = $_SERVER["SERVER_NAME"];
  $url_parts = explode("/", parse_url($pageURL, PHP_URL_PATH));
  $y = 0;
  $url_string = "";
  if (!is_home()) {
      echo '<ul itemscope="" itemtype="http://schema.org/BreadcrumbList" class="breadcrumb">';
      echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="https://' . $page_URI . '/" itemprop="item"><span class="" itemprop="name">Home</span><i class="fi fi-home"></i></a><meta itemprop="position" content="1" /></li>';
      $x = 1;

      foreach ($url_parts as $part){
        if($part !== ""):
          $url_string .= $part ."/";
          if($part == "category"):
            echo '<li  itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="#" itemprop="item"><span itemprop="name">'. ucwords(str_replace("-"," ", $part)) .'</span></a><meta itemprop="position" content="'. $x .'" /></li>';
          else:
            echo '<li  itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="https://' . $page_URI . '/' . $url_string. '" itemprop="item"><span itemprop="name">'. ucwords(str_replace("-"," ", $part)) .'</span></a><meta itemprop="position" content="'. $x .'" /></li>';
          endif;
        endif;
        $x += 1;
      }
      echo '</ul>';
  }
}

function displayEnhancements ($args) {
    global $Wcms;

    $args[0] .= 	mad_breadcrumbs(); /* create breadcrumbs using function */ 
    return $args;
}
