<?php // Do not put any HTML above this line

session_start();
if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}
//hash password
$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    unset($_SESSION['name']);  // clear current user
    //check if email is of required type
    if (strpos($_POST['email'], '@') === false) {
        $_SESSION["error"] = "Email must have an at sign (@).";
        header( 'Location: login.php' ) ;
        return;
      } else { //check whether all fields are filled.
        if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
            $_SESSION["error"] = "User name and password are required";
            header( 'Location: login.php' ) ;
                return;
          }  else {
            $check = hash('md5', $salt.$_POST['pass']);
            if ( $check == $stored_hash ) {
              error_log("Login success ".$_POST['email']);
              // Redirect the browser to view.php
              $_SESSION["success"] = "Logged in.";
              $_SESSION["name"] = htmlentities($_POST["email"]);
              header( 'Location: index.php' ) ;
              return;
            } else {
              error_log("Login fail ".$_POST['email']." $check");
              $_SESSION["error"] = "Incorrect password.";
              header( 'Location: login.php' ) ;
              return;
            }
        }
      }
}

// Fall through into the View
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "bootstrap.php"; ?>
        <title>Lule Moses</title>
    </head>
    <body>
        <div class="container">
            <h1>Please Log In</h1>
            <?php //show errors to the users ie hints
                if ( isset($_SESSION["error"]) ) {
                    echo('<p style="color:red">'.htmlentities($_SESSION['error'])."</p>\n");
                    unset($_SESSION["error"]);
                }
            ?>
            <form method="POST">
                <label for="nam">Email Address</label>
                <input type="text" name="email" id="nam"><br/>
                <label for="id_1723">Password</label>
                <input type="password" name="pass" id="id_1723"><br/>
                <input type="submit" value="Log In">
                <input type="submit" name="cancel" value="Cancel">
            </form>
            <p>For a password hint, view source and find a password hint in the HTML comments.</p>
            <!--password php123-->
        </div>
    </body>
</html>
