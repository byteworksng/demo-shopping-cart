<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 28/06/2018
 * Time: 12:41 AM
 */

namespace App\Interfaces;

interface ControllerInterface
{

    /**
     * renders complete web page
     *
     * Injects options into view partials and layouts to form the page
     *
     * @param string      $viewFile
     * @param array       $params
     * @param string|null $layoutFile
     * @param string|null $layoutDirname
     * @param array       $layoutParams
     */
    function render($viewFile, array $params = [], $layoutFile = null, $layoutDirname = null, array $layoutParams = []);

    /**
     * executes method on the controller.
     *
     * @param $method
     * @param $action
     *
     * @return mixed
     */
    function callAction($method, $parameters);

    /**
     * Redirects to specified url
     *
     * @param string $url
     * @param int    $statusCode
     *
     * @return mixed
     */
    function redirect($url, $statusCode = 302);
}
