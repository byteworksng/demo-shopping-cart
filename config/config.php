<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 27/06/2018
 * Time: 7:30 PM
 */
return [
        'siteName'           => 'My ABC Shop',
        'database'           => [
                'host'     => 'localhost',
                'dbname'   => 'abchost',
                'driver'   => 'mysql',
                'username' => 'root',
                'password' => 'root',
                'charset'  => 'utf8mb4',
                'port'     => 3306,
        ],
        'baseUri'            => '/',
        'environment'        => 'development',
        'viewsDir'           => APP_PATH . '/views',
        'assetsDir'          => BASE_PATH . '/public/assets',
        'layoutDir'          => APP_PATH . '/views/layout',
        'layoutDefaultFile'  => 'main',
        'route'              => BASE_PATH . '/config/route.php',
        'sessionStoragePath' => BASE_PATH . '/storage/session',

];
