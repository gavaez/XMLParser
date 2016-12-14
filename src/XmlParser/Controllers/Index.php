<?php
/**
 * Created by PhpStorm.
 * User: Anton Ermakov
 * Date: 07.12.2016
 */

namespace XmlParser\Controllers;

use Swiftlet\Abstracts\Controller;
use Swiftlet\Interfaces\App;
use Swiftlet\Interfaces\View;
use XmlParser\Models\Image;

/**
 * Main controller
 * Get attributes of the last image from XML source.
 */
class Index extends Controller
{
    const DEFAULT_TITLE = 'XML Parser';
//    const SOURCE_URI = 'https://www.redit.com/r/';
    const SOURCE_URI    = 'https://www.reddit.com/r/pics.xml';


    /**
     * {@inheritdoc}
     */
    public function __construct(App $app, View $view)
    {
        parent::__construct($app, $view);

        $this->setTitle(self::DEFAULT_TITLE);
    }

    /**
     * @param array $args [optional]
     */
    public function index(array $args = [])
    {
        $result = $this->parseXML(self::SOURCE_URI);

        /**
         * Set properties for View data representation
         * can be set through defined public magic method __set
         * e.g. $this->view->image = $image;
         */
        $this->view->set($result instanceof Image ? 'image' : 'parsError', $result);
    }

    /**
     * Parse XML source
     *
     * @param string $source
     *
     * @return string|Image
     *     On success returns instance of Image Class
     *     On failure returns error message (if something wrong during XML parsing process)
     */
    private function parseXML($source)
    {
        if (!$source) {
            return 'XML source must be defined!';
        }

        $xml = @file_get_contents($source);
        if (!$xml) {
            return "Fail to open $source.";
        }

        /**
         * xpath cannot search through the xml without explicitly specifying a namespace.
         * rename the 'xmlns' into something else to trick xpath into believing that no default namespace is defined.
         * source: http://php.net/manual/en/simplexmlelement.xpath.php
         */
        $xml = str_replace('xmlns=', 'ns=', $xml);

        //Interprets a string of XML into an object
        if ($xml = simplexml_load_string($xml)) {
            //Get last feedback
            $lastFeedback = $xml->xpath('(//content)[last()]');
            //Transform data containing html code with image to XML structure
            $xml = $lastFeedback ? simplexml_load_string(reset($lastFeedback)) : false;
        }

        if (!$xml) {
            return 'Parser cannot process the file.';
        }

        //Get last image from the XML structure
        $imgRec = $xml->xpath('(//img)[last()]');
        if (!$imgRec) {
            return 'Parser cannot find any image from the last feedback.';
        }

        //store image attributes in Image Model instance
        return new Image(reset($imgRec));
    }
}
