<?php
$dir = '/share/www/msd/web/upload/videos/';
if ($handle = opendir($dir)) {
    echo "Gestionnaire du dossier : $handle\n";
    echo "Entr�es :\n";

    /* Ceci est la fa�on correcte de traverser un dossier. */
    while (false !== ($entry = readdir($handle))) {
        echo "<li>".$dir.$entry;
    	chmod($dir.$entry, 0777);
    }

    closedir($handle);
}

$dir = '/share/www/msd/web/upload/img/';
if ($handle = opendir($dir)) {
    echo "Gestionnaire du dossier : $handle\n";
    echo "Entr�es :\n";

    /* Ceci est la fa�on correcte de traverser un dossier. */
    while (false !== ($entry = readdir($handle))) {
        echo "<li>".$dir.$entry;
    	chmod($dir.$entry, 0777);
    }

    closedir($handle);
}
?>