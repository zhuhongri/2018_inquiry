<?php  // init_admin_auth.php
//
require_once('init.php');
// ”F‰Âˆ—
if (false === isset($_SESSION['admin_auth'])) {
    // ƒƒOƒCƒ“î•ñ‚ª‚È‚¢‚Ì‚Åindex‚É‚·‚Á”ò‚Î‚·
    header('Location: ./admin_index.php');
    exit;
}