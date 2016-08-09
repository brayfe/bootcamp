<?php

echo "<h1>Title of TPL</h1>";
echo 'This demonstrates registering a tpl.php file with an arbitrary name';

print render($content);
echo "<br />";

print ($elements['#paver']);

?>
