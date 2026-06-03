<?php

session_start();

session_destroy();

header("Location: /ecommerce_v2/autenticazione/index.php");

exit();

?>