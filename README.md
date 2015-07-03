Site name
=========

Short description


Installation
------------

git clone git@gitlab.webqam.fr:repo-adress.git mysite && cd mysite && git sumodule update --init

Fill wp-config.php with credentials

Import DB from prod or preprod.

Download uploads from prod or preprod : rsync -rv mysite@nfrance.webqamapps.com:public/wp-content/uploads wp-content/uploads

Dev
---

Compile css :

    cd wp-content/themes/webqam/sass
    compass watch

Deployment
----------

http://mysite-dev.webqamapps.com is currently hooked on "dev" branch
http://www.mysite.com is currently hooked on "master" branch

Migration
---------

you can use Easy Migration plugin for migration.

It will replace all occurrences of old domain by new one (also works for Types).

### Utilisation

* Activate plugin
* Go to -> Migration in admin panel
* Fill form with old and new URL.
* ...
* Profit !

### Extension

The plugin is hook based, so you can extend it.

Simply add a hook your functions.php theme file (or plugin, or whatever).


    add_action("easymigration/urlreplace", function($oldUrl, $newUrl) {
        // Do some treatments here
    }, 10, 2);

It will be executed at form validation with all other hooks.

Good to know
------------

Please specify if there is some specificities on this website, which must be known by potential future devs :)