<?

include_once "_orm.php";

$COOKIE_EXPIRATION = time() + 60*60*24*364;  // 1 year

/*
micmahoney micmahoney@earthlink.net
dcrowley LatCrow@aol.com
michrob2801 michrob2801@yahoo.com
mjgolden mjgolden@cox.net
Larry Eischen leisch5063@sbcglobal.net
Robert Mitchell robert.mitchel770@ntlworld.com (Ratber Tostan)
Andreas Jaeke ajaeke@jubii.de
*/
function cbIsAdmin($user) {
  $level = cbGetAdminLevel($user);
  return $level == 0;
}

function cbIsCurrentUserAdmin() {
  return isset($_COOKIE['user']) && cbIsAdmin($_COOKIE['user']);
}

function cbCanDownload($user) {
  $level = cbGetAdminLevel($user);
  return $level == 0 || $level == 1;
}

function cbCanUpload($user) {
  $level = cbGetAdminLevel($user);
  return $level == 0 || $level == 1;
}

function cbCanEdit($user) {
  $level = cbGetAdminLevel($user);
  return $level == 0 || $level == 1;
}

?>
