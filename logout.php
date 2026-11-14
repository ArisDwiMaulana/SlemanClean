<?php
// TODO backend: hapus session login yang asli
session_start();
session_destroy();
header('Location: index.php');
exit;
