<?php
header('Content-Type: application/pdf');

header('Content-Disposition: attachment; filename="receipt.pdf"');

readfile('receipt.pdf');
?>