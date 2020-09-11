<?php


namespace diezeel\CI;


class Ci implements Contracts\CiInterface
{

    public $app;

    private $_classes = [];

    public function __construct($app)
    {
        $this->app = $app;

        $this->loadCI();
    }

    public function load_class($class, $directory = 'libraries', $param = null)
    {
        if ($this->_classes[$class]) {
            return $this->_classes[$class];
        }

        $name = false;

        // Look for the class first in the local application/libraries folder
        // then in the native system/libraries folder
        foreach ([APPPATH, BASEPATH] as $path) {
            if (file_exists($path . $directory . '/' . $class . '.php')) {
                $name = 'CI_' . $class;

                if (class_exists($name, false) === false) {
                    require_once($path . $directory . '/' . $class . '.php');
                }

                break;
            }
        }

        // Is the request a class extension? If so we load it too
        if (file_exists(APPPATH . $directory . '/' . config_item('subclass_prefix') . $class . '.php')) {
            $name = config_item('subclass_prefix') . $class;

            if (class_exists($name, false) === false) {
                require_once(APPPATH . $directory . '/' . $name . '.php');
            }
        }
    }

    private function loadCI()
    {

    }
}