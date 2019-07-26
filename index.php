<?php
session_start();
  $num1 = rand(1,20);
  $num2 = rand(1, 20);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Project 1 contact form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <?= !empty($_GET['err_msg']) ? '<div style=\'text-align: center; \' class=\'p-3 mb-2 bg-danger text-white\'>'.$_GET['err_msg'].'</div>' : "" ?>
    <?= !empty($_GET['succ_msg']) ? '<div style=\'text-align: center; \' class=\'p-3 mb-2 bg-success text-white\'>'.$_GET['succ_msg'].'</div>' : "" ?>
    <div class="container" style="margin-top: 50px;">
      <div class="col-9">
        <form method="post" action="classes/contact.php">

          <div class="form-group">
            <label for="first_name">First Name:</label><br>
            <input type="text" class="form-control" name="first_name" value="<?= !empty($_SESSION['first_name']) ? $_SESSION['first_name'] : '' ?>"><br><br>
          </div>

          <div class="form-group">
            <label for="last_name">Last Name:</label><br>
            <input type="text" class="form-control"  name="last_name" value="<?= !empty($_SESSION['last_name']) ? $_SESSION['last_name'] : '' ?>"><br><br>
          </div>

          <div class="form-group">
            <label for="email">Email:</label><br>
            <input type="email" class="form-control" name="email" value="<?= !empty($_SESSION['email']) ? $_SESSION['email'] : '' ?>"><br><br>
          </div>

          <div class="form-group">
            <label for="phone">Contact number:</label><br>
            <input type="text" class="form-control" name="phone" value="<?= !empty($_SESSION['phone']) ? $_SESSION['phone'] : '' ?>"><br><br>
          </div>

          <div class="form-group">
            <label for="message">Message:</label>
            <textarea name="message" class="form-control" cols="30" rows="10"><?= !empty($_SESSION['message']) ? $_SESSION['message'] : '' ?></textarea><br>
          </div>

          <div class="form-group">
            <label for="message">What is: <?= $num1 ?> + <?= $num2 ?></label><br>
            <input type="text" class="form-control" name="human" value="<?= !empty($_SESSION['human']) ? $_SESSION['human'] : '' ?>">
            <input type="hidden" name="num1" value="<?php echo $num1 ?>">
            <input type="hidden" name="num2" value="<?php echo $num2 ?>">
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
          <button name="destroy" class="btn btn-danger">Destroy info</button>

        </form>
      </div>
    </div>
  </body>
</html>
