<?php


namespace app\services;


class LoadImageFile
{
    const MAX_IMAGE_SIZE = 1500000;
    const FILE_TYPE = 'image';
    protected $imageType;
    protected $imageData;
    public $isReady = false;

    public function __construct(string $fromForm)
    {
        if (isset($_FILES[$fromForm])) {

            $pos = strpos($_FILES[$fromForm]['type'], $this::FILE_TYPE);
            if ($pos !== 0) return;
            if ($_FILES[$fromForm]['size'] > $this::MAX_IMAGE_SIZE) return;

            $this->imageType = $_FILES[$fromForm]['type'];
            $this->imageData = file_get_contents($_FILES[$fromForm]['tmp_name']);
            if ($this->imageData) $this->isReady= true;
        }
    }

    /**
     * @return mixed
     */
    public function getImageType()
    {
        return $this->imageType;
    }

    /**
     * @return false|string
     */
    public function getImageData()
    {
        return $this->imageData;
    }
}