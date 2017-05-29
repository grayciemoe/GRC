<?php

if(!function_exists('create_breadcrumb')){
function create_breadcrumb(){
  $ci = &get_instance();
  $i=1;
  $uri = $ci->uri->segment($i);
//  $link = '<ul style="list-style-type:none; overflow: auto;">'; 
  $link = '<em style="font-size: 11px;">';
 
  while($uri != ''){
    $prep_link = '';
  for($j=1; $j<=$i;$j++){
    $prep_link .= $ci->uri->segment($j).'/';
  }
 
  if($ci->uri->segment($i+1) == ''){
//    $link.='<li style="float:left;">»<a href="'.site_url($prep_link).'"><b>';
      $link.='»<a href="'.site_url($prep_link).'"><b>';
    $link.=$ci->uri->segment($i).'</b></a> ';
  }else{
    $link.='» <a href="'.site_url($prep_link).'">';
    $link.=$ci->uri->segment($i).'</a> ';
  }
 
  $i++;
  $uri = $ci->uri->segment($i);
  }
    $link .= '</em>';
    return $link;
  }
}