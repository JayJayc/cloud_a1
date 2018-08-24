<?php
$cookie_name = "fib_number";
if(!isset($_COOKIE[$cookie_name])) {
    echo "Cookie named '" . $cookie_name . "' is not set!";
} else {
    echo "Cookie : ". $_COOKIE[$cookie_name];
    $fib_numbers = explode(",",
        file_get_contents('gs://s3600396-storage/fibonacci_'.$_COOKIE[$cookie_name].'.txt')
    );

    $array_length=count($fib_numbers);
    $sum = 0;
    for($x=0;$x<$array_length;$x++)
    {
        $sum += $fib_numbers[$x];

    }

}
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
    header('Location: page2.php');
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
    <form id="form">
      A: <input type="number" name="a_value"><br>
      B: <input type="number" name="b_value"><br>
      C: <input type="number" name="c_value"><br>
      <input type="button" onclick="myFunction()" value="Submit">
    </form>
    <p id="total_sum"></p>
    <p id="average"></p>
      <hr>
    <script>
        function myFunction() {
            let x = document.getElementById("form");
            let fib_sum = parseInt("<?php echo $sum ?>");
            let fib_num = parseInt(getFibNumber());
            let a = parseInt(x[0].value);
            let b = parseInt(x[1].value);
            let c = parseInt(x[2].value);

            let s = a + b;
            let m = c * s;

            let total_sum = m + fib_sum;
            let average = (a + b + c + fib_sum)/(3+fib_num);

            document.getElementById("total_sum").innerHTML = "Total Sum: " + total_sum + "";
            document.getElementById("average").innerHTML = "Average: " + average +"";

            writeResult(average);
        }
        // Used code from https://www.w3schools.com/js/js_cookies.asp
        // to get the value of the cookie
        function getFibNumber () {
            let name = "fib_number=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for(let i = 0; i <ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) === 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function writeResult(average) {
            let http = new XMLHttpRequest();
            let url = 'write_result_in_bucket.php';
            let params = 'average='+average;
            http.open('POST', url, true);

            //Send the proper header information along with the request
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            http.onreadystatechange = function() {//Call a function when the state changes.
                if(http.readyState === 4 && http.status === 200) {
                    alert(http.responseText);
                }
            };
            http.send(params);
        }

    </script>
  </body>
</html>

