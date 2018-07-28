<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 28/06/2018
 * Time: 9:57 PM
 */

namespace App\Traits;

trait Logger
{
    /**
     * only error codes supported
     *
     * @param \Exception|String $error
     * @param                   $code
     *
     * @return bool
     */
    function log($error, $code = null)
    {

        $logDir = BASE_PATH . '/storage/logs/error.log';

        // we want newlines for each message
        $newLine = "\n";
        $date = date('d.m.y h:i:s');
        if ($error instanceof \Exception)
        {
            $log = "Date: $date - Code: {$error->getCode()} -  Error:  {$error->getMessage()} $newLine Trace:  {$error->getTraceAsString()} $newLine";
        } else
        {

            $log = "Date: $date - Code: $code - Error:  $error $newLine";
        }


        return error_log($log, 3, $logDir);


    }
}
