<?php
date_default_timezone_set('Europe/London');
class Logger {
  public function build_file_name(){
    $this->prefix   = '../logs/';
    $this->filename = 'log('.date('d.m.Y').').txt';
    $this->myfile;
    $this->check_if_file_exists();
  }

  public function check_if_file_exists(){
    if( file_exists($this->prefix.$this->filename) ) {
      $this->append_current_file();
    } else {
      $this->create_new_file();
    }
  }

  public function append_current_file(){
    $this->full_filename = $this->prefix.$this->filename;
    $this->myfile = fopen( $this->full_filename, 'a+' ) or die('unable to open file');
  }

  public function create_new_file(){
    $this->full_filename = $this->prefix.$this->filename;
    $this->myfile = fopen( $this->full_filename, 'w+') or die('unable to open file');
  }

  public function write_to_file($input) {
    $input = '('.date('H:i:s').'): '.$input;
      fwrite($this->myfile, $input."\n");
    $this->close_file();
  }

  public function close_file() {
    fclose($this->myfile);
  }

}

?>
