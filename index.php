<?php

$hash = password_hash("1234" , PASSWORD_DEFAULT);

echo $hash;
echo "<br>";
echo password_verify("1234", "$2y$10$OLfxIDX39WUxhvaUktbSZOxoQ2tMxwCLcWmLhjOQp4tGUIjSngaVW");