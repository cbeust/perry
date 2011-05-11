<?

include_once "_config.php";
include_once "_permissions.php";

$user = $_POST['user'];

global $MAIN_URL;

if (cbIsKnown($user)) {
  $result = setcookie("user", $user, $COOKIE_EXPIRATION);
  if ($result) {
//    echo "REFERER:" . $_SERVER['HTTP_REFERER'];
    cbRedirect($ALL_CYCLES_URL);
  } else {
    echo cbHeader("User unknown");
    echo "Sorry, you're not allowed to post on this Web site without approval from the owner.
  <p>
  <a href='" . $MAIN_URL . "'>Go back to the main menu</a>.
  <p>
  ";
  }
}

?>
