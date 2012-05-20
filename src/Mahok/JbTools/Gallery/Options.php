<?php

namespace Mahok\JbTools\Gallery;

/**
 * Configuration options.
 */
class Options
{
    /**
     * @var array Associative array containing gallery defaults
     * @link http://juicebox.net/support/config_options/
     */
    private $defaults = array(
        'galleryTitle'              => '',
        'galleryWidth'              => '100%',
        'galleryHeight'             => '100%',
        'backgroundColor'           => '#222222',
        'showOpenButton'            => true,
        'showExpandButton'          => true,
        'showThumbsButton'          => true,
        'useFlickr'                 => false,
        'flickrUserName'            => '',
        'flickrTags'                => '',
        // General Options (PRO)
        'screenMode'                => 'AUTO',
        'enableDirectLinks'         => false,
        'enableKeyboardControls'    => true,
        'firstImageIndex'           => 1,
        'randomizeImages'           => false,
        'enableLooping'             => false,
        'stagePadding'              => 0,
        'galleryTitlePosition'      => 'OVERLAY',
        'showPreloader'             => true,
        'forceTouchMode'            => false,
        'enableTouchZoom'           => true,
        // Color Options (PRO)
    'textColor'                 => 'rgba(255,255,255,1)',
    'captionBackColor'          => 'rgba(0,0,0,.5)',
    'buttonBarBackColor'        => 'rgba(0,0,0,.5)',
    'thumbFrameColor'           => 'rgba(255,255,255,.5)',
    'imageFrameColor'           => 'rgba(255,255,255,1)',
    'topBackColor'              => 'rgba(0,0,0,0)',
    // Main Image Options (PRO)
    'imageTransitionType'       => 'SLIDE',
    'imageClickMode'            => 'NAVIGATE',
    'imageScaleMode'            => 'SCALE_DOWN',
    'imagePreloading'           => 'PAGE',
    'imageTransitionTime'       => '.5',
    'imagePadding'              => '0',
    'showImageOverlay'          => 'AUTO',
    'showImageNav'              => true,
    'frameWidth'                => 0,
    // Thumbnail Options (PRO)
    'thumbWidth'                => 85,
    'thumbHeight'               => 85,
    'thumbPadding'              => 5,
    'showThumbPagingText'       => false,
    'showSmallThumbs'           => true,
    'showLargeThumbs'           => true,
    'useThumbDots'              => false,
    'maxThumbColumns'           => 10,
    // Button Bar Options (PRO)
    'buttonBarPosition'         => 'OVERLAY',
    'showAutoPlayButton'        => false,
    'showAudioButton'           => false,
    'showInfoButton'            => false,
    'showNavButtons'            => false,
    // Caption Options (PRO)
    'captionPosition'           => 'OVERLAY',
    'maxCaptionHeight'          => 100,
    'showImageNumber'           => true,
    // Autoplay Options (PRO)
    'enableAutoPlay'            => false,
    'autoPlayOnLoad'            => false,
    'displayTime'               => 5,
    'showAutoPlayStatus'        => false,
    'goNextOnAutoPlay'          => false,
    'autoPlayThumbs'            => true,
    // Audio Options (PRO)
    'audioUrlMp3'               => '',
    'audioUrlOgg'               => '',
    'loopAudio'                 => true,
    'playAudioOnLoad'           => false,
    'audioVolume'               => 0.8,
    // Back Button (PRO)
    'showBackButton'            => false,
    'backButtonText'            => '&lgt; Back',
    'backButtonUrl'             => '',
    'backButtonPosition'        => 'TOP',
    // Back Button (PRO)
    'showSplashPage'            => 'AUTO',
    'splashButtonText'          => 'View Gallery',
    'splashTitle'               => '',
    'splashImageUrl'            => '',
    'splashShowImageCount'      => true,
    'splashDescription'         => '',
    // Flickr Pro Options (PRO)
    'flickrUserId'              => '',
    'flickrSetId'               => '',
    'flickrGroupId'             => '',
    'flickrTagMode'             => 'ALL',
    'flickrSort'                => 'DATE-POSTED-DESC',
    'flickrImageSize'           => 'LARGE',
    'flickrImageCount'          => 50,
    'flickrExtraParams'         => '',
    'flickrShowTitle'           => true,
    'flickrShowDescription'     => false,
    'flickrShowPageLink'        => false,
    'flickrPageLinkText'        => 'View Photo Page'
    );

    /**
     * @var array Associative array containing deprecated settings which can be
     *            directly mapped to new offsets.
     */
    private $mappings = array(
        'title'                     => 'galleryTitle',
        'titlePosition'             => 'galleryTitlePosition',
        'frameColor'                => 'imageFrameColor',
        'thumbColumns'              => 'maxThumbColumns',
        'showFullscreenButton'      => 'showExpandButton',
        'stageBorder'               => 'stagePadding',
        'showOverlay'               => 'showImageOverlay',
        'showNavButtons'            => 'showImageNav',
        'captionHeight'             => 'maxCaptionHeight',
        'audioUrl'                  => 'audioUrlMp3'
    );

    /**
     * @var array Associative array containing the actual config data.
     */
    private $data = null;

    /**
     * Constructor
     * Populate data with options.
     *
     * @param array|SimpleXMLElement $options
     */
    public function __construct($options = null)
    {
        if (null !== $options) {
            foreach ($options as $offset => $value) {
                $this->set($offset, $value);
            }
        }
    }

    /**
     * Sets Option offset to specified value.
     *
     * @param string $offset
     * @param mixed $value
     * @return void
     */
    public function set($offset, $value)
    {
        if ($value instanceof \SimpleXMLElement) {
            $value = $this->getValueFromSimpleXmlElement($value);
        }
        if (array_key_exists($offset, $this->defaults)) {
            if ($value != $this->defaults[$offset]) {
                $this->data[$offset] = $value;
            }
        } else if (array_key_exists($offset, $this->mappings)) {
            $key = $this->mappings[$offset];
            if ($value != $this->defaults[$key]) {
                $this->data[$key] = $value;
            }
        }
    }

    /**
     * SimpleXML returns attributes as SimpleXMLElement. This method tries
     * to convert them into native php datatypes.
     *
     * @param SimpleXmlElement $value
     * @return mixed
     */
    private function getValueFromSimpleXmlElement($value)
    {
        $value = (string) $value;
        switch ($value) {
            case 'true':
                return true;
            case 'false':
                return false;
            default:
                if ($value !== '') {
                    if ($value === "0") {
                        return (int) $value;
                    } else if ((int) $value > 0) {
                        return (int) $value;
                    }
                    if (substr($value, 0, 2) == '0x') {
                        return "#" . substr($value, 2);
                    }
                }
        }
        return $value;
    }

    /**
     * Returns <pre>{$this->$data}</pre>.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
}