<?

include_once "_permissions.php";

$user = $_POST['user'];


if (cbIsKnown($user)) {
  $result = setcookie("user", $user, $COOKIE_EXPIRATION);
  if ($result) {
//    echo "REFERER:" . $_SERVER['HTTP_REFERER'];
    cbRedirect($ALL_CYCLES_URL);
  } else {
    echo cbHeader("User unknown");
    echo "Sorry, you're not allowed to post on this Web site without approval from the owner.
  <p>
  <a href='http://beust.com/perry'>Go back to the main menu</a>.
  <p>
  ";
  }
}

?>
