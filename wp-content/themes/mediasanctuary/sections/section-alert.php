<?php

$alertStatus = get_field('enable_alert_bar');
$alertText = get_field('alert_bar');

$alertButtonText = false;
$alertButtonLink = false;
$alertButton = get_field('button');
if($alertButton){
  $alertButtonText = $alertButton['alert_bar_button_text'];
  $alertButtonLink = $alertButton['alert_bar_button_link'];
}

$alert_begin = '<div id="alert">';
$alert_end = '</div>';

if ($alertButtonLink) {
  $alert_begin = '<a id="alert" class="link" href="'.$alertButtonLink.'">';
  $alert_end = '</a>';   
  $alertButton = $alertButtonText ? '<span class="btn">'.$alertButtonText.'</span>' : '<span class="btn">Learn More</span>'; 
} else {
  $alertButton = '';
}


if($alertStatus = 'enabled' && $alertText) {
  echo $alert_begin;
    echo '<span class="container">';
      echo '<p>'.$alertText.'</p>';
      echo $alertButton;
    echo '</span">';  
  echo $alert_end;
}

?>