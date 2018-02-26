<?php
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function dirLookup($type){
  $code = '';
  switch ($type) {
    case 'Active Plus Shares':
      $code = 'PVAPST';
      break;
    case 'Australian Shares':
      $code = 'PVAUST';
      break;
    case 'Australian Shares Wholesale':
      $code = 'PVSWHT';
      break;
    case 'Microcap Opportunities':
      $code = 'PVECOT';
      break;
    case 'Shares for Income':
      $code = 'PVSFIT';
      break;
    case 'Smaller Companies':
      $code = 'PVSCOT';
      break;
    case 'Volatility Alpha':
      $code = 'PVGALT';
      break;
    case 'Wealth Defender':
      $code = 'PVWDAT';
      break;
    default:
      $code = "";
      break;
  }
  return $code;
}

function timeframeHelper($timeframe, $month){
  $code = '';
  if($timeframe = 'Monthly'){
    $code = $month;
  } else if($timeframe = 'Quarterly'){
    $code = quarterly($month);
  }
  return $code;
}

function quarterly($month){
  $tmp = 1 + intdiv($month, 4);
  settype($tmp, "string");
  $qtr = "Q".$tmp;
  return $qtr;
}


// Depreciated
function commentarySingle($type){
  $url = plugins_url();
  $month = (int)date('m');
  $year = (int)date('y');
  if($month == 1){
    $month = 12;
    $year--;
  } else {
    $month--;
  }
  $path = "/var/www/html/wp-content/plugins/commentaries/".$type."/".$year."/".$month;
  $file = array_diff(scandir($path), array('..', '.'));
  $html = "<div class='wpb_text_column wpb_content_element'><div class='wpb_wrapper'><a href='".$url."/commentaries/".$type."/".$year."/".$month."/".$file[2]."'target='_blank'><span data-type='normal' class='qode_icon_shortcode  q_font_awsome_icon fa-3x' style='margin: 0 8px 0 0; '><i class='qode_icon_font_awesome fa fa-file-pdf-o qode_icon_element' style='color: #5c315e'></i></span></a></div></div>";
  return $html;
}

function commentaryList($type){
  $html = "";
  $url = plugins_url();
  $path = "/var/www/html/wp-content/plugins/commentaries/".$type;
  $dir = array_diff(scandir($path), array('..', '.'));
  $comArray = array();
  foreach($dir as $year){
    $path2 = $path."/".$year;
    $dir2 = array_diff(scandir($path2), array('..', '.'));
    $monthArray = array($year);
    foreach ($dir2 as $month) {
      $path3 = $path2."/".$month;
      $dir3 = array_diff(scandir($path3), array('..', '.'));
      $html .= "<div class='commentaryList'><h4><a href='".$url."/commentaries/".$type."/".$year."/".$month."/".$dir3[2]."'>– ".$type." ".$month."/".$year."</a></h4></div>";
    }
  }
  return $html;
}

function latestCommentary($type){
  $file = commentaryDir($type);
  $url = plugins_url();
  $html = "<div class='wpb_text_column wpb_content_element'><div class='wpb_wrapper'><a href='".$url."/commentaries/".$file."'target='_blank'><span data-type='normal' class='qode_icon_shortcode  q_font_awsome_icon fa-3x' style='margin: 0 8px 0 0; '><i class='qode_icon_font_awesome fa fa-file-pdf-o qode_icon_element' style='color: #5c315e'></i></span></a></div></div>";
  return $html;
}

function logToConsole($log){
    echo "<div display='none'><script type='text/javascript'>console.log('".$log."')</script></div>";
}

function commentaryDir($type){
  $path = "/var/www/html/wp-content/plugins/commentaries/".$type;
  $dir = array_diff(scandir($path), array('..', '.'));
  $tmpYear = 0;
  $tmpMonth = 0;
  foreach($dir as $year){
    if((int)$year > $tmpYear){
      $tmpYear = (int)$year;
    }
  }
  $path2 = $path."/".$tmpYear;
  $dir2 = array_diff(scandir($path2), array('..', '.'));
  foreach ($dir2 as $month) {
    if((int)$month > $tmpMonth){
      $tmpMonth = $month;
    }
  }
  $comPath = $path2."/".$tmpMonth;
  $dir3 = scandir($comPath);
  foreach ($dir3 as $filename) {
      $finalfile = $filename;
  }
  // logToConsole($tmpMonth);
  // logToConsole($dir2[3]);
  $pathToFile = $type."/".$tmpYear."/".$tmpMonth."/".$finalfile;
  return $pathToFile;
}
?>
