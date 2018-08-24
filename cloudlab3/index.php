<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $number = intval(htmlspecialchars($_POST["number"]));

    $file_name = "gs://s3600396-storage/fibonacci_{$number}.txt";

    $handle = fopen("$file_name",'w');

    $f1 = 0;
    $f2 = 1;
    for($i = 1; $i <= $number; $i ++) {

        fwrite($handle, ", ".$f2);
        $next = $f1 + $f2;
        $f1 = $f2;
        $f2 = $next;
    }

    fclose($handle);
    $cookie_name = "fib_number";
    $cookie_value = $number;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

    header('Location: second.php');
}

?>
<!DOCTYPE html>
<html>
  <head>
    <!-- [START css] -->
    <link type="text/css" rel="stylesheet" href="/bootstrap/css/bootstrap.css">
    <!-- [END css] -->
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }
      blockquote {
        margin-bottom: 10px;
        border-left-color: #bbb;
      }
      form {
        margin-top: 10px;
      }
      .form-signin input[type="text"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
    </style>
  </head>
  <body>
    <form action="/" method="post">
      N: <input type="number" name="number"><br>
      <input type="submit">
    </form>

      <hr>
  </body>
</html>

