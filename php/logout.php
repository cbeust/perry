<?

include_once "_common.php";

setcookie ("user", "", time() - 3600);

cbRedirect($_SERVER['HTTP_REFERER']);

?>

