<?php

$headers = "From: summerlove@ahouhpuc.fr\r\n" .
"Reply-To: summerlove@ahouhpuc.fr\r\n" .
'Content-type: text/plain; charset=utf-8' . "\r\n";
'X-Mailer: PHP/' . phpversion();


mail('unicorn777@gmail.com', "Test mail .ahouhpuc.fr", 'Ce mail est un test de SPF', $headers, '-fsummerlove@ahouhpuc.fr');

?>
