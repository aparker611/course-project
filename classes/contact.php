<?php
include 'sessions.php';
class Contact extends Session {
  //Setting the objects variables
  public function __construct() {

    //Setting input values
    $this->first_name = $_POST['first_name'];
    $this->last_name  = $_POST['last_name'];
    $this->email      = $_POST['email'];
    $this->phone      = $_POST['phone'];
    $this->message    = $_POST['message'];
    $this->human      = $_POST['human'];

    $this->build_file_name();
    $this->session = new Session;
    $this->build_session();
    if(isset($_POST['destroy'])) {
      $this->session->destroy_session();
      header('location: /?succ_msg=Successfully destroyed session!');
      die();
    }

   //Set our human validation numbers that are hidden in our index.php
   $this->validation_num_1 = $_POST['num1'];
   $this->validation_num_2 = $_POST['num2'];

    //Setting full_name
    $this->full_name = $this->first_name.' '.$this->last_name;
    $this->set_mailer_options();
  }

  //Build session array
  protected function build_session(){
    $arr = array("first_name"=>$this->first_name,
                 "last_name" =>$this->last_name,
                 "email"     =>$this->email,
                 "phone"     =>$this->phone,
                 "message"   =>$this->message,
                 "human"     =>$this->human,);
  if(empty($arr)){
    $this->write_to_file('Failed to build array in build_session()');
    header('location: /?err_msg=Internal Error please check logs');
  } else {
    $this->session->set_session_variables($arr);
    header('location: /');
  }
  }

//Set mailer options
  protected function set_mailer_options(){
    //Recipient
    $this->to = 'adam3692@hotmail.co.uk';
    //Subject
    $this->subject = 'New message from: '.$this->full_name;
    //Headers
    $fullname = $this->full_name;
    $email    = $this->email;
    $this->headers = "From: $fullname $email\r\n";
    $this->headers .= "Reply-To: $email\r\n";
    $this->headers .= "content-type: text/html\r\n";
    $this->check_all_options();
  }
  // Check that all properties exist and have been set.
  protected function check_all_options(){
    //Check if any input from the user is empty
    if(empty($this->first_name) || empty($this->last_name) || empty($this->email) || empty($this->phone) ||
       empty($this->message)) {
         //return to main page with a message
      header("location: /?err_msg=Please make sure all form details are filled out!");
      $this->write_to_file('User did not fill out form correctly');
      die();
    } elseif( empty($this->to) || empty($this->subject) || empty($this->headers)) {
      //Check if any of our set_mailer_options function failed, if they did then redirect to homepage with an error
      header("location: /err_msg=Internal error! Please contact admin for logs");
      $this->write_to_file('During checking our to, subject and headers one of these were empty.');
      die();
    } else {
      $this->check_human();
    }
  }
  //Build the main message that will be emailed to the $to email address.
  protected function build_mail_message(){
    $this->full_message = 'Received message from: ' . $this->full_name . '<br><br>'
                          . 'Contact number: '.$this->phone.'<br><br>'.'Email: '.$this->email
                          . '<br><br>' . 'Content: '.$this->message;
  // Check if the full_message we made was created if so run the send_mail function if not return to the homepage with an error.
  (!empty($this->full_message)) ? $this->send_mail() : header("location: /?err_msg=Failed to build email");
  }
  //Check that the user passed our validation by checking:
  //1. If the user input is equal to what the validation question was which has been randomised.
  //2. Check that the input is not empty.
  protected function check_human() {
    if($this->human != ($this->validation_num_1+$this->validation_num_2)) {
      header("location: /?err_msg=Human validation was wrong, please check your input!");
      $this->write_to_file('User did not enter correct human verification.');
      die();
    } elseif(empty($this->human)) {
      header("location: /?err_msg=Human validation is empty please make sure you add an input.");
      $this->write_to_file('User left human verification empty.');
      die();
    } else {
      $this->build_mail_message();
    }
  }

  protected function send_mail() {
    //Send the mail, if it fails we have done a try -> catch to redirect to the homepage with the error message returned.
    try {
      mail($this->to, $this->subject, $this->full_message, $this->headers);
    } catch (Exception $e) {
      header('location: /?err_msg=Error:'.$e->getMessage());
      $this->write_to_file("Ran into error during sending mail, error: " . $e->getMessage());
      die();
    }
    header("location: /?succ_msg=We've received your message, we'll be in contact within the next 48 hours.");
    $this->session->destroy_session();
    die();
  }
}
//Check that all input fields are filled in before we do anything, if not redirect to the homepage and tell the user to fill the form in.
  $contact = new Contact;

?>
