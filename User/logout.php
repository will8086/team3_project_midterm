<?php
session_start();
session_destroy();
alertAndGoToIndex("您已登出系統");


function alertAndGoToIndex($msg){
  echo "<script>
    alert(\"$msg\");
    window.location.href = \"./login.php\";
  </script>";
}
