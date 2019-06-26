<?php
namespace App\Services\Tcpdf;

class TcpdfOutput
{
    public function __construct()
    {
    }

    public function outPut($name = 'example.pdf', $dest = 'I')
    {
        TcpdfService::$tcpdfObj->lastPage();
        TcpdfService::$tcpdfObj->Output($name, $dest);
    }
}