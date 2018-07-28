<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 05/07/2018
 * Time: 11:58 PM
 */

namespace App\Http\Controller;

class BaseController extends ViewController
{
    /**
     * Render view
     *
     * @param string      $viewFile
     * @param array       $params
     * @param string|null $layoutFile
     * @param string|null $layoutDirname
     * @param array       $layoutParams
     *
     * @return string
     */
    public function render(
            $viewFile,
            array $params = [],
            $layoutFile = null,
            $layoutDirname = null,
            array $layoutParams = []
    ) {
        // load content
        $content = $this->loadContent($viewFile, $params);

        // load layout
        return $this->loadLayout($content, $layoutFile, $layoutDirname, $layoutParams);
    }

    /**
     * redirect to url and terminate further execution of script
     *
     * @param string $url
     * @param int    $statusCode
     *
     * @return mixed|void
     */
    public function redirect($url, $statusCode = 302)
    {
        header("Location:" . $url, true, $statusCode);
        exit();
    }
}
