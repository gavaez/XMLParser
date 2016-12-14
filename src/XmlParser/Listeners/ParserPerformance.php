<?php
/**
 * Created by PhpStorm.
 * User: Anton Ermakov
 * Date: 07.12.2016
 */

namespace XmlParser\Listeners;

use Swiftlet\Abstracts\Controller;
use Swiftlet\Abstracts\Listener;
use Swiftlet\Abstracts\View;

/**
 * Calculate the time of XML source parsing
 */
class ParserPerformance extends Listener
{
    /**
     * Performance is calculated in seconds.
     * It is the difference of Unix timestamp Before and After action takes place (script run).
     * @var float
     */
    static private $performance;

    public function actionBefore()
    {
        self::$performance = -microtime(true);
    }

	public function actionAfter(Controller $controller, View $view)
    {
        $view->set('performance', round(self::$performance += microtime(true), 3));
	}
}
