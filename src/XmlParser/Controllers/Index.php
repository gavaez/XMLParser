<?php
/**
 * Created by PhpStorm.
 * User: Anton Ermakov
 * Date: 07.12.2016
 */

namespace XmlParser\Controllers;

use \XmlParser\Models\Image as ImageModel;
use \Swiftlet\Abstracts\Controller as ControllerAbstract;

/**
 * Main controller
 * Get attributes of the last image from XML source.
 */


class Index extends ControllerAbstract
{
	protected $title = 'XML Parser';

    /*
     * Error message (if something wrong during XML parsing process)
     * @var string
     */
    public $parsError;

	public function index(array $args = array())
	{

        $image = $this->ParseXML('https://www.reddit.com/r/pics.xml'); //https://www.redit.com/r/

        /*
         * Set properties for View data representation
         * can be set through defined public magic method __set
         * e.g. $this->view->src = $image->src;
         */
        if ($image) {
            $this->view->set('src', $image->src);
            $this->view->set('alt', $image->alt);
            $this->view->set('title', $image->title);
        } else {
            $this->view->set('parsError', $this->parsError);
        }
	}

	/*
	 * Parse XML source
	 * @param string $source
	 * @return
	 * On success returns instance of Image Class
	 * On failure returns false. $this->parsError property stores Error message
	 */
    public function ParseXML($source='') {

        if ($source) {
            try {

                $xmlContent = file_get_contents($source);

                try {
                    /*
                     * xpath cannot search through the xml without explicitly specifying a namespace.
                     * rename the 'xmlns' into something else to trick xpath into believing that no default namespace is defined.
                     * source: http://php.net/manual/en/simplexmlelement.xpath.php
                     */
                    $xmlContent = str_replace('xmlns=', 'ns=', $xmlContent);

                    //Interprets a string of XML into an object
                    $xml = simplexml_load_string($xmlContent);

                    //Get last feedback
                    $lastFeedback = $xml->xpath("(//content)[last()]");

                    //Transform data containing html code with image to XML structure
                    $xml = simplexml_load_string(reset($lastFeedback));

                    //Get last image from the XML structure
                    $imgRec = $xml->xpath("(//img)[last()]");

                    if ($imgRec) {
                        //store image attributes in Image Model instance
                        $image = new ImageModel();
                        $image->src = strval($imgRec[0]['src']);
                        $image->alt = strval($imgRec[0]['alt']);
                        $image->title = strval($imgRec[0]['title']);
                    } else {
                        $this->parsError = 'Parser cannot find any image from the last feedback.';
                    }
                } catch (\Exception $e) {
                    $this->parsError = 'Parser cannot process the file.';
                }
            } catch (\Exception $e) {
                $this->parsError = "Fail to open {$source}.";
            }
        } else {
            $this->parsError = 'XML source must be defined!';
        }

        return (!$this->parsError)?$image:false;
    }
}
