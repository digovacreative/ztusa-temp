<?php
if(isset($_POST['keyword'])){
  $_POST['keyword'] = filter_var($_POST['keyword'], FILTER_SANITIZE_STRING);
  //echo 'done keyword';
}

if(isset($_POST['bdb_filter_keyword'])){
  $_POST['bdb_filter_keyword'] = filter_var($_POST['bdb_filter_keyword'], FILTER_SANITIZE_STRING);
  //echo 'done bdb_filter_keyword';
}

if(isset($_POST['bdb_filter_people_role'])){
  $_POST['bdb_filter_people_role'] = filter_var($_POST['bdb_filter_people_role'], FILTER_SANITIZE_STRING);
  //echo 'done bdb_filter_people_role';
}

if(isset($_POST['bdb_filter_service'])){
  $_POST['bdb_filter_service'] = filter_var($_POST['bdb_filter_service'], FILTER_SANITIZE_STRING);
  //echo 'done bdb_filter_service';
}

if(isset($_POST['bdb_filter_sector'])){
  $_POST['bdb_filter_sector'] = filter_var($_POST['bdb_filter_sector'], FILTER_SANITIZE_STRING);
  //echo 'done bdb_filter_sector';
}

if(isset($_POST['post-type'])){
  $_POST['post-type'] = filter_var($_POST['post-type'], FILTER_SANITIZE_STRING);
  //echo 'done post-type';
}
?>
