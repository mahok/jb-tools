<?php

namespace Mahok\JbTools\Gallery;

/**
 * Base class defining a gallery.
 */
class Gallery
{
    /**
     * @var string Path containing config.xml.
     */
    private $path;

    /**
     * @var \Mahok\JbTools\Gallery\Options Configuration options.
     */
    private $options;

    /**
     * @var array List of images in gallery.
     */
    private $images = array();

    /**
     * Imports data from SimpleViewer's gallery.xml.
     *
     * @param string $path Path containing gallery.xml
     */
    public static function importFromSv2($path)
    {
        $gallery = new self();
        if (($gallery->path = strstr(realpath($path), 'gallery.xml', true)) === false) {
            $gallery->path = realpath($path);
            $xml = simplexml_load_file(realpath($path . '/gallery.xml'));
        } else {
            $xml = simplexml_load_file(realpath($path));
        }

        // TODO Migrate options which require some kind of conversion
        // e.g. backgroundTransparent --> changes backgroundColor to rgba()
        // e.g. firstImageIndex + 1 (starts with 1 instead of 0)!
        $gallery->options = new Options($xml->attributes());
        foreach ($xml->children() as $node) {
            $attributes = $node->attributes();
            $image = new Image();
            if (isset($attributes['thumbURL'])) {
                $image->attributes['thumbURL'] = (string) $attributes['thumbURL'];
            }
            if (isset($attributes['imageURL'])) {
                $image->attributes['imageURL'] = (string) $attributes['imageURL'];
            }
            if (isset($attributes['linkURL'])) {
                $image->attributes['linkURL'] = (string) $attributes['linkURL'];
            }
            if (isset($attributes['linkTarget'])) {
                $image->attributes['linkTarget'] = (string) $attributes['linkTarget'];
            }
            if (isset($node->title)) {
                $image->title = (string) $node->title;
            }
            if (isset($node->caption)) {
                $image->caption = (string) $node->caption;
            }
            $gallery->images[] = $image;
        }

        return $gallery;
    }

    public function save()
    {
        $out = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $out .= '<juiceboxgallery';
        foreach ($this->options->toArray() as $key => $value) {
            $out .= " {$key}=\"{$value}\"";
        }
        $out .= ">\n";
        foreach ($this->images as $image) {
            $out .= (string) $image;
        }
        $out .= '</juiceboxgallery>';
        file_put_contents($this->path . '/config.xml', $out);
    }
}