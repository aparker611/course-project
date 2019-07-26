<?php
include 'logger.php';
  class Session extends Logger {
    protected function __construct(){
      session_start();
      $this->build_file_name();
    }
    protected function set_session_variables($input) {
      if(is_array($input)) {
        foreach( $input as $key => $value ) {
          $_SESSION[$key] = $value;
        }
      } else {
        header('location: /?err_msg=Internal Error please see logs');
      }
    }


    public function destroy_session() {
      session_destroy();
    }

    }
?>
