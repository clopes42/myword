<?php
header("Content-type:text/plain");
switch (true) {
    case strpos($_SERVER['HTTP_HOST'], 'webqamapps.com') !==false:
    case strpos($_SERVER['HTTP_HOST'], 'webqamapps.fr') !==false:
        exit("User-agent: *\nDisallow: /");
}
?>
User-agent: *

# On empêche l'indexation des dossiers sensibles
Disallow: /cgi-bin
Disallow: /wp-login.php
Disallow: /wp-admin
Disallow: /wp-includes
Disallow: /wp-content/plugins
Disallow: /wp-content/cache
Disallow: /wp-content/themes
Disallow: /trackback
Disallow: /comments
Disallow: /category/*/*
Disallow: */trackback
Disallow: */feed
Disallow: */comments
Disallow: /*?*
Disallow: /*?

# Autoriser Google Image
User-agent: Googlebot-Image
Disallow:
Allow: /*

# Autoriser Google AdSense
User-agent: Mediapartners-Google*
Disallow:
Allow: /*
