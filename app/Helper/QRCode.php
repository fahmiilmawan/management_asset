<?php

namespace App\Helper;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

class QRCode {

    public $content;
    public function __construct(string $content) {
        $this->content = $content;
    }

    public function generate(): string
    {
        $rendererStyle = new RendererStyle(300);
        $writer = new Writer(
            new ImageRenderer($rendererStyle, new SvgImageBackEnd())
        );
        $qrCodeImage = $writer->writeString($this->content);
        $base64 = base64_encode($qrCodeImage);
        return "data:image/svg+xml;base64," . $base64;
    }

}
