<?php

namespace yidas;

use Yii;

/**
 * Yii 2 Navigation Locator
 * 
 * Yii 2 Navigation Locator for active menu identification
 *
 * @author      Nick Tsai <myintaer@gmail.com>
 * @version     1.0.0
 */
class NavLocator
{
    /**
     * @var string $routeCache
     */
    protected static $routeCache;

    /**
     * Prefix
     *
     * @var string
     */
    protected static $prefix = '';

    /**
     * Get controller route
     *
     * @param int $depth Depth number separated by slash
     * @return string Current controller route of Yii2
     */
    public static function get($depth=0)
    {
        // Depth option
        if ($depth) {

            $routeArray = explode('/', self::get());
            $maxLevel = count($routeArray);
            $depth = ($depth>=1 && $depth<=$maxLevel) ? (int)$depth : $maxLevel;
            array_splice($routeArray, $depth);

            return implode('/', $routeArray);
        }
         
        // If there is no cache, build a new one
        if (!self::$routeCache) {
            
            self::$routeCache = Yii::$app->controller->getRoute();
        }

        return self::$routeCache;
    }

    /**
     * Set prefix route for simplifying declaring next locator routes 
     *
     * @param string $prefix
     * @return self
     */
    public static function setPrefix($prefix='')
    {
        static::$prefix = ($prefix) ? self::stripRoute($prefix) . '/' : '';

        return new static;
    }

    /**
     * Get prefix route 
     *
     * @return string
     */
    public static function getPrefix()
    {
        return (static::$prefix) ? static::$prefix : '';
    }

    /**
     * Validate current controller is completely matched giving controller route
     *
     * @param string $route Comparative controller route
     * @return boolean
     */
    public static function is($route)
    {
        $route = self::$prefix . self::stripRoute($route);

        return self::get()==$route ? true : false;
    }

    /**
     * Validate current controller is under giving controller route
     *
     * @param string $route Comparative controller route
     * @return boolean
     */
    public static function in($route)
    {
        // Route handler
        $route = self::stripRoute($route);
        $route = ($route) ? $route . '/' : '';
        $route = self::$prefix . $route;

        return strpos(self::get() . '/', $route)===0 ? true : false;
    }

    /**
     * Validate current controller is included in giving controller route
     *
     * @param string $route Comparative controller route
     * @return boolean
     */
    // public static function match($route)
    // {
    //     $route = self::$prefix . self::stripRoute($route);

    //     return strpos(self::get(), $route)!==false ? true : false;
    // }

    /**
     * Strip Locator string
     *
     * @param string $route
     * @return string Standard route string
     */
    public function stripRoute($route)
    {
        if (!is_string($route))
            return '';

        $route = trim($route);
        // Strip slash both asides
        $route = ltrim($route, '/');
        $route = rtrim($route, '/');

        return $route;
    }
}
