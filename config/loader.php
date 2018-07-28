<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 27/06/2018
 * Time: 9:59 PM
 */

/**
 * simple autoloader
 *
 * @param $config
 **/
function registerLoader()
{
    set_include_path(
            get_include_path() . PATH_SEPARATOR . BASE_PATH
    );
    spl_autoload_extensions('.php');

    // linux is case sensitive.. default autoloader uses all lowercase filenames... not what i want.

    spl_autoload_register(function ($class) {
        $rootNamespace = ucfirst(strtr(APP_ROOT, '/', ''));
        $fileNamespace = str_replace('\\', '/', $class);

        $filename = BASE_PATH . DIRECTORY_SEPARATOR . preg_replace("/$rootNamespace/", strtolower($rootNamespace),
                        $fileNamespace, 1) . '.php';
        if (file_exists($filename))
        {
            require_once $filename;
        }

    });

}

registerLoader();
