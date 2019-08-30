<?php
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="abc.zip"'); # anzeige der datei
readfile('test.zip'); # lese die datei
?>