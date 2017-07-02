<?php

namespace Home\Controller;


use EasyWeChat\Foundation\Application;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeController extends WechatBaseController
{
    public function index()
    {
        $app = new Application($this->options);

        $qrcode = $app->qrcode;

        $result = $qrcode->temporary(56,6*24*3600);

        $ticket = $result->ticket;
        $expireSeconds = $result->expire_seconds;
        $url = $result->url;

        $qrCode = new QrCode($url);

        $qrCode->setMargin(10)->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH)->setEncoding('UTF-8');

        header('Content-Type: '.$qrCode->getContentType(PngWriter::class));
        echo $qrCode->writeString(PngWriter::class);
    }
}