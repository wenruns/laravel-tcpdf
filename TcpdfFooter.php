<?php
namespace App\Services\Tcpdf;

class TcpdfFooter
{
    // 页脚参数
    protected $options = [];

    protected $rm_default_footer = false;

    // 默认的页脚参数
    const PDF_FOOTER = [
        'text_color' => [255, 64, 0], // 页脚文本颜色
        'line_color' => [255, 64, 128], // 页脚横线颜色
        'font'  => [
            PDF_FONT_NAME_DATA, // 字体
            '', // style
            PDF_FONT_SIZE_DATA, // 大小
        ],
        'margin' => PDF_MARGIN_FOOTER, //
    ];

    /**
     * TcpdfFooter constructor.
     * @param TcpdfService $tcpdf
     */
    public function __construct($rm_default_footer = false)
    {
        $this->rm_default_footer = $rm_default_footer;
        $this->setFooter();
    }

    /**
     *
     */
    public function setFooter()
    {
        if($this->rm_default_footer){
            // remove default footer
            TcpdfService::$tcpdfObj->setPrintFooter(false);
        }else{
            $options  = $this->getOptions();
            // set default footer data
            TcpdfService::$tcpdfObj->setFooterData($options['text_color'], $options['line_color']);
            // set footer fonts
            TcpdfService::$tcpdfObj->setFooterFont($options['font']);
            // set margins
            TcpdfService::$tcpdfObj->SetFooterMargin($options['margin']);
        }
    }

    /**
     * 获取页脚选项参数
     * @return array
     */
    public function getOptions()
    {
        if(!empty($this->options)){
            return $this->options;
        }
        if(isset(TcpdfService::$options['PDF_FOOTER'])){
            foreach (self::PDF_FOOTER as $key => $item) {
                $this->options[$key] = TcpdfService::$options['PDF_FOOTER'][$key] ?? $item;
            }
        }else{
            $this->options = self::PDF_FOOTER;
        }
        return $this->options;
    }
}