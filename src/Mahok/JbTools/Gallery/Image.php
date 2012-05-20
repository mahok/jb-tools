<?php

namespace Mahok\JbTools\Gallery;

/**
 * Image node
 */
class Image
{
    /**
     * @var array Associative array containing node attributes
     */
    public $attributes = array(
        'imageURL'      => '',
        'thumbURL'      => '',
        'linkURL'       => '',
        'linkTarget'    => '_blank'
    );

    /**
     * @var string Title
     */
    public $title = "";

    /**
     * @var string Caption
     */
    public $caption = "";

    /**
     * Returns <image>-node for xml.
     */
    public function __toString()
    {
        $out = '<image';
        foreach ($this->attributes as $key => $value) {
            $out .= " {$key}=\"{$value}\"";
        }
        $out .= '>';
        if (!empty($this->title)) {
            $out .= "<title><![CDATA[{$this->title}]]></title>";
        }
        if (!empty($this->caption)) {
            $out .= "<caption><![CDATA[{$this->caption}]]></caption>";
        }
        $out .= '</image>';
        return $out ."\n";
    }
}