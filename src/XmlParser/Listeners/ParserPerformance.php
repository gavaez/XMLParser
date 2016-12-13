<?php
/**
 * Created by PhpStorm.
 * User: Anton Ermakov
 * Date: 07.12.2016
 */

namespace XmlParser\Listeners;

use \Swiftlet\Abstracts\Controller as ControllerAbstract;
use \Swiftlet\Abstracts\Listener as ListenerAbstract;
use \Swiftlet\Abstracts\View as ViewAbstract;

/*
 * Calculate the time of XML source parsing
 */
class ParserPerformance extends ListenerAbstract
{
    /*
     * Performance is calculated in seconds.
     * It is the difference of Unix timestamp Before and After action takes place (script run).
     * @var float
     */
    static private $performance;

    public function actionBefore(ControllerAbstract $controller, ViewAbstract $view)
    {
        self::$performance = -microtime(true);
    }

	public function actionAfter(ControllerAbstract $controller, ViewAbstract $view)
    {
        self::$performance += microtime(true);
        $view->set('performance', round(self::$performance,3));
	}
}