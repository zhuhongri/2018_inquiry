<?php  // admin_logout.php
//
require_once('init.php');
// ”F‰Âî•ñ‚ðíœ‚·‚é
unset($_SESSION['admin_auth']);
//
header('Location: ./admin_index.php');