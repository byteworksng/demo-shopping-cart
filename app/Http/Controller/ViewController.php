<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 05/07/2018
 * Time: 11:53 PM
 */

namespace App\Http\Controller;

use App\Facade\Config;
use App\Interfaces\ViewInterface;

abstract class ViewController extends Controller implements ViewInterface
{
    private $params;

    /**
     * Builds content of partial views
     *
     * @param string     $viewFile
     * @param array|null $params
     *
     * @return string
     */
    protected function loadContent($viewFile, array $params = null)
    {
        $viewPath = $this->getViewPath($this->getViewDir());

        $file = implode("/", [$viewPath, $viewFile]);

        return $this->loadFile($file, $params);
    }

    /**
     * @param $dirName
     *
     * @return string
     */
    public function getViewPath($dirName)
    {
        return Config::get('viewsDir') . DIRECTORY_SEPARATOR . $dirName;
    }

    /**
     * @return string
     */
    public function getViewDir()
    {
        $class = get_called_class();
        $pos = strrpos($class, "\\");

        return strtr(strtolower(substr($class, $pos !== false ? $pos + 1 : $pos)), ['controller' => '']);
    }

    /**
     * loads and executes view file from filesystem
     *
     * @param string $file
     * @param array  $params
     *
     * @return string
     */
    public function loadFile($file, array $params = [])
    {
        if (isset($params))
        {
            extract($params);
        }

        ob_start();

        include_once $this->locateFile($file);

        return ob_get_clean();
    }

    /**
     * @param $file
     *
     * @return string|null
     */
    public function locateFile($file)
    {
        $supportedExt = ['.phtml', '.php', '.html'];
        foreach ($supportedExt as $ext)
        {
            if (file_exists($file . $ext))
            {
                return $file . $ext;
            }
        }
        return null;
    }

    /**
     * Builds the layout page by injecting contents from all partial views
     *
     * @param             $content
     * @param string|null $fileName
     * @param string|null $dirName
     * @param array|null  $params
     *
     * @return string
     */
    protected function loadLayout($content, string $fileName = null, string $dirName = null, array $params = null)
    {
        $this->setParams($content, $params);

        $fileName = isset($fileName) ? $fileName : Config::get('layoutDefaultFile');

        $layoutPath = $this->getLayoutPath($dirName);

        $layout = implode("/", [$layoutPath, $fileName]);

        return $this->loadFile($layout, $this->getParams());
    }

    /**
     * @param $dirName
     *
     * @return string
     */
    public function getLayoutPath($dirName)
    {
        $dirName = isset($dirName) ? DIRECTORY_SEPARATOR . $dirName : "";

        return Config::get('layoutDir') . $dirName;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams($content, array $params)
    {
        $params = ! empty($params) ? $params : [
                'title' => Config::get('siteName'),
        ];
        $params['content'] = $content;

        $this->params = $params;
    }
}
