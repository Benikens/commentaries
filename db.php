<?php
global $coms_all_db_version;
global $coms_latest_db_version;
$coms_all_db_version = '1.0';
$coms_latest_db_version = '1.0';

// build table
function coms_all_install(){
  global $wpdb;
  $table_name = $wpdb->prefix . "coms_all";

  $charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    trust tinytext NOT NULL,
    type tinyint DEFAULT '0' NOT NULL,
    year mediumint(9) NOT NULL,
    month varchar(3) NOT NULL,
    filename varchar(55) NOT NULL,
    PRIMARY KEY  (id)
  ) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );

  add_option('coms_all_db_version', $coms_all_db_version);
}

function coms_latest_install(){
  global $wpdb;
  $table_name = $wpdb->prefix . "coms_latest";

  $charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE $table_name (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    trust tinytext NOT NULL,
    filename varchar(100) NOT NULL,
    PRIMARY KEY  (id)
  ) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );

  add_option('coms_latest_db_version', $coms_latest_db_version);
}

// fill table with data
function coms_all_install_data(){
  global $wpdb;
  // loop through filepaths and store in table
  //
  $wpdb-insert(
    $table_name,
    array(
      // stuff goes here
    );
    )
}

function updateComsAll($com){
  global $wpdb;
  $table_name = $wpdb->prefix . "coms_all";
  $wpdb-insert(
    $table_name,
    $com
  );
}

function comLookup($path,$array){
  if(is_dir($path)){
    $dir = array_diff(scandir($path), array('..', '.'));
    if(!dir_is_empty($dir)){
      $array = array_map(comLookup($path+$dir,$array), $dir);
    }
  } else {
    $array->push($)
  }
}

function dir_is_empty($dir){
  $handle = openir($dir);
  while ( false !== ($entry = readdir($handle))) {
    if ($entry != "." && entry != "..") {
      return FALSE;
    }
  }
  return TRUE;
}

function commentaryDir($trust){
  $path = "/var/www/html/wp-content/plugins/commentaries/".$trust;
  $dir = array_diff(scandir($path), array('..', '.'));
  foreach($dir as $year){
    $path2 = $path."/".$year;
    $dir2 = array_diff(scandir($path2), array('..', '.'));
    foreach ($dir2 as $month) {
      $type = 0;
      if(strpos($month, 'Q') !== false){
        $type=1;
      }
      $comPath = $path2."/".$month;
      $dir3 = scandir($comPath);
      foreach ($dir3 as $filename) {
        $com = (array) [
          'trust' => $trust,
          'type' => $type,
          'year' => $year,
          'month' => $moth,
          'filename' => $filename
        ];
        updateComsAll($com);
      }
    }
  }
}
