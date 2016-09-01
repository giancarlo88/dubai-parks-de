<?php
$filename = 'voucher_mexico.jpg';
header('Cache-Control: private, no-cache');
header('X-Powered-By: Influence Digital');
header('Content-Type: image/jpg');
header('Content-disposition: attachment; filename="voucher_mexico.jpg"');
readfile('assets/images/' . $filename);
@file_put_contents('count/downloads.txt', @file_get_contents('count/downloads.txt') + 1);
exit();