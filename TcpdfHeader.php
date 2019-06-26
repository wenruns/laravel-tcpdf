<?php
namespace App\Services\Tcpdf;

class TcpdfHeader
{
    // 页头参数
    protected $options = [];

    protected $rm_default_head = false;

    // 默认的页头参数
    const PDF_HEADER = [
        'src' => PDF_HEADER_LOGO, // 设置页头logo的src地址
        'width' => PDF_HEADER_LOGO_WIDTH, // 设置页头logo宽度
        'title' => PDF_HEADER_TITLE, // 设置页头标题
        'description' => PDF_HEADER_STRING, // 设置页头描述文字
        'textColor' => [255, 64, 0], // RGB(彩色表)，设置页头文字的颜色
        'lineColor' => [255, 64, 128], // 设置页头下划线的颜色,
        'font'  => [
            PDF_FONT_NAME_MAIN, // 字体
            '', // style
            PDF_FONT_SIZE_MAIN, // 大小
        ],
        'margin' => PDF_MARGIN_HEADER, //页头边距
    ];

    /**
     * TcpdfHeader constructor.
     */
    public function __construct($rm_defalt_head = false)
    {
        $this->rm_default_head = $rm_defalt_head;
        $this->setHeader();
    }


    /**
     * 设置页头样式
     */
    public function setHeader(){
        if($this->rm_default_head){
            // remove default header
            TcpdfService::$tcpdfObj->setPrintHeader(false);
        }else{
            $options = $this->getOptions();
            // set default header data
            TcpdfService::$tcpdfObj->SetHeaderData($options['src'], $options['width'], $options['title'], $options['description'], $options['textColor'], $options['lineColor']);
            // set header fonts
            TcpdfService::$tcpdfObj->setHeaderFont($options['font']);
            // set margins
            TcpdfService::$tcpdfObj->SetHeaderMargin($options['margin']);
        }
    }

    /**
     * 获取页头参数
     * @return array
     */
    public function getOptions(){
        if(!empty($this->options)){
            return $this->options;
        }
        if(isset(TcpdfService::$options['PDF_HEADER'])){
            foreach (self::PDF_HEADER as $key => $val){
                $this->options[$key] = TcpdfService::$options['PDF_HEADER'][$key] ?? $val;
            }
        }else{
            $this->options = self::PDF_HEADER;
        }
        return $this->options;
    }
}