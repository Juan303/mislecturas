<?php

$target = '../storage/app/public';
$shortcut = 'storage';


if(symlink($target, $shortcut)){
    echo "creado bien en teoria";
}
else{
    echo "algun error";
    print_r(error_get_last());
}

?>
