<?php

include_once "_common.php";

// if ((($_FILES["file"]["type"] == "image/gif")
// || ($_FILES["file"]["type"] == "image/jpeg")
// || ($_FILES["file"]["type"] == "image/pjpeg"))
// && ($_FILES["file"]["size"] < 20000))
//   {
//   if ($_FILES["file"]["error"] > 0)
//     {
//     echo "Error: " . $_FILES["file"]["error"] . "<br />";
//     }
//   else
//     {
//  echo "Upload: " . $_FILES["file"]["name"] . "<br />";
//  echo "Type: " . $_FILES["file"]["type"] . "<br />";
//  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
//  echo "Stored in: " . $_FILES["file"]["tmp_name"];

  $language = $_POST["language"];
  $number = $_POST["number"];
  $directory = "../" . $language;
  $size = round($_FILES["file"]["size"] / 1024) . " Kb";
  $from = $_FILES["file"]["tmp_name"];
  $to = $_FILES["file"]["name"];

  if (! file_exists($directory)) mkdir($directory);

  $target = $directory . "/" . $to;
  if (file_exists($target)) {
    echo $target . " already exists. ";
  } else {
    move_uploaded_file($from, $target);
    chmod($target, 0);  // protect against malicious files

    $user = $_COOKIE['user'];
    $id = cbGetUserInfo($user);
    global $MY_EMAIL_ADDRESS;
    $subject =  "New file uploaded: " . $target . " size:" . $size;
    $body = $target . " uploaded by " . $id[0] . "\n" . $id[1] . "\n";
    $success = mail($MY_EMAIL_ADDRESS, $subject, $body,
        "Reply-to: " . $id[1] . "\r\n"
    );

    if (! $success) {
      echo "Mail could not be sent";
    } else {
      $redirectUrl = $DISPLAY_SUMMARY_URL . "?number=" . $number;
      cbTrace("Stored in: " . $target . " (" . ($_FILES["file"]["size"] / 1024) . " Kb");

      cbTrace("Redirecting to " . $redirectUrl);
//      echo "Mail sent Subject:" . $subject . " Body:" . $body;
      cbRedirect($redirectUrl);
    }
  }

//     }
//   }
// else
//   {
//   echo "Invalid file";
//   }
?> 
