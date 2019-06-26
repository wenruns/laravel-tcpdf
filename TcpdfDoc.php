<?php
namespace App\Services\Tcpdf;

class TcpdfDoc
{
    protected $options = [];

    /**
     *  if(!$title && isset($this->options['title'])){
    $title = $this->options['title'];
    }

     */
    const PDF_DOC_INFO = [
        'title' => 'PDF_EXAMPLE', // 文档标题
        'creator' => PDF_CREATOR, // 文档创建者
        'author' => 'Nicola Asuni', // 作者
        'subject' => 'TCPDF Tutorial', //
        'keywords' => 'TCPDF, PDF, example, test, guide', // 关键词
        'monospaced' => PDF_FONT_MONOSPACED,
        'margin' => [
            'left' => PDF_MARGIN_LEFT,
            'top' => PDF_MARGIN_TOP,
            'right' => PDF_MARGIN_RIGHT,
            'keepmargins' => false, // 如果为true，则覆盖默认页边距
        ],
        'auto_page_break' => [ // 设置自动分页符
            'auto' => true, // 布尔值，指示模式应该是打开还是关闭
            'margin' => PDF_MARGIN_BOTTOM,
        ],
        'image_scale' => PDF_IMAGE_SCALE_RATIO, // 设置图像比例因子
        'lang_file' => __DIR__.'/lang/eng.php', // 设置一些语言相关的字符串（可选）
        'font_sub_setting' => true, // 设置默认字体子集设置模式
        'font' => [
            'family' => 'helvetica', // 系列字体
            'style' => '', // 字体样式
            'size' => 14, // 字体大小（以磅为单位）
            'fontfile' => '',  //  字体定义文件
            'subset' => 'default', //如果为true，则仅嵌入字体的一个子集（仅存储与所用字符相关的信息）；如果为false，则嵌入完整字体；如果为'default'，则使用setfontsubset（）设置的默认值。此选项仅对TrueTypeUnicode字体有效。如果要允许用户更改文档，请将此参数设置为false。如果您对字体进行了子集设置，则接收您的PDF的人将需要具有相同的字体才能对您的PDF进行更改。PDF的文件大小也会更小，因为您只嵌入了部分字体。
            'out' => true, // 如果为true，则输出字体大小命令，否则只设置字体属性。
        ],
        'text_shadow' => [
            'enabled'=>true,
            'depth_w'=>0.2,
            'depth_h'=>0.2,
            'color'=>array(196,196,196),
            'opacity'=>1,
            'blend_mode'=>'Normal'
        ],
    ];

    public function __construct()
    {
        $this->setDoc();
    }

    /**
     *
     */
    public function setDoc()
    {
        $options = $this->getOptions();
        // set document information
        TcpdfService::$tcpdfObj->SetCreator($options['creator']);
        TcpdfService::$tcpdfObj->SetAuthor($options['author']);
        TcpdfService::$tcpdfObj->SetTitle($options['title']);
        TcpdfService::$tcpdfObj->SetSubject($options['subject']);
        TcpdfService::$tcpdfObj->SetKeywords($options['keywords']);
        // set default monospaced font
        TcpdfService::$tcpdfObj->SetDefaultMonospacedFont($options['monospaced']);
        // set margins
        TcpdfService::$tcpdfObj->SetMargins($options['margin']['left'], $options['margin']['top'], $options['margin']['right'], $options['margin']['keepmargins']);
        // set auto page breaks
        TcpdfService::$tcpdfObj->SetAutoPageBreak($options['auto_page_break']['auto'], $options['auto_page_break']['margin']);
        // set image scale factor
        TcpdfService::$tcpdfObj->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists($options['lang_file'])) {
            $lan = require_once($options['lang_file']);
            TcpdfService::$tcpdfObj->setLanguageArray($lan);
        }

        // set default font subsetting mode
        TcpdfService::$tcpdfObj->setFontSubsetting($options['font_sub_setting']);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        TcpdfService::$tcpdfObj->SetFont($options['font']['family'], $options['font']['style'], $options['font']['size'], $options['font']['fontfile'], $options['font']['subset'], $options['font']['out']);

        // set text shadow effect
        TcpdfService::$tcpdfObj->setTextShadow($options['text_shadow']);
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        if(!empty($this->options)){
            return $this->options;
        }
        if(isset(TcpdfService::$options['PDF_DOC_INFO'])){
            foreach (self::PDF_DOC_INFO as $key => $item){
                $this->options[$key] = TcpdfService::$options['PDF_DOC_INFO'][$key] ?? $item;
            }
        }else{
            $this->options = self::PDF_DOC_INFO;
        }
        return $this->options;
    }


}