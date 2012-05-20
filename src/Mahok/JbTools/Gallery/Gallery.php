<?php

namespace Mahok\JbTools\Gallery;

use Symfony\Component\DomCrawler\Crawler;

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
     * @var array Associative array containing gallery-options.
     */
    private $options = array();

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
            $crawler = new Crawler(realpath($path . '/gallery.xml'));
        } else {
            $crawler = new Crawler(realpath($path));
        }

        // Get options and images using Crawler

        return $gallery;
    }

    public function save()
    {
        // Store info as config.xml
    }
}