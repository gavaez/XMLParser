<?php
/**
 * Created by PhpStorm.
 * User: Anton Ermakov
 * Date: 07.12.2016
 */

namespace XmlParser\Models;

use Swiftlet\Abstracts\Model;

/**
 * Model for HTML image attributes description
 */
class Image extends Model
{
    /**
     * Image url path
     * @var string
     */
    public $src;

    /**
     * Image alternative text
     * @var string
     */
    public $alt;

    /**
     * Image title
     * @var string
     */
    public $title;

    /**
     * Image constructor.
     *
     * @param mixed[] $data [optional]
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = (string) $value;
            }
        }
    }
}
