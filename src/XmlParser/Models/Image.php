<?php
/**
 * Created by PhpStorm.
 * User: Anton Ermakov
 * Date: 07.12.2016
 */

namespace XmlParser\Models;

use \Swiftlet\Abstracts\Model as ModelAbstract;

/**
 * Model for HTML image attributes description
 */
class Image extends ModelAbstract
{
    /*
     * Image url path
     * @var string
     */
    public $src;

    /*
     * Image alternative text
     * @var string
     */
    public $alt;

    /*
     * Image title
     * @var string
     */
    public $title;




}