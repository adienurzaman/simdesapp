<?php
  session_start();
  session_destroy();
  echo "<script>alert('Anda telah keluar dari Simdesapp'); window.location = './index.php'</script>";
?>
