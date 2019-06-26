<?php
namespace App\Services\Tcpdf;

class TcpdfImage
{
    const IAMGE_OPTIONS = [
        'file' => '', //包含图像的文件的名称或后跟图像数据字符串的“@”字符。若要链接图像而不将其嵌入文档，请在URL之前设置一个星号字符（即“*http://www.example.com/image.jpg”）
        'x' => '', //（浮动）左上角（LTR）或右上角（RTL）的横坐标。
        'y' => '', //（浮动）左上角（LTR）或右上角（RTL）的纵坐标。
        'w' => 0, //（float）页面中图像的宽度。如果未指定或等于零，则自动计算。
        'h' => 0, //（float）高度。如果未指定或等于零，则自动计算。
        'type' => '', //（字符串）图像格式。可能的值包括（不区分大小写）：jpeg和png（whitout gd库）以及gd支持的所有图像：gd、gd2、gd2part、gif、jpeg、png、bmp、xbm、xpm；。如果未指定，则从文件扩展名推断类型。
        'link' => '', //addlink（）返回的参数$link（混合）url或标识符。
        'align' => '', //（string）指示相对于图像高度图像插入旁边指针的对齐方式。T:ltr的右上角或rtl的左上角；M:ltr的右中角或rtl的左中角；B:ltr的右下角或rtl的左下角；N:next line。
        'resize' => false, //（mixed）如果真的调整（减少）图像大小以适应$w和$h（需要gd或imagemagick库）；如果真的调整（减少），则不调整大小；如果2在所有情况下强制调整大小（向上调整和向下调整）。
        'dpi' => 300, //（int）调整大小时使用的每英寸分辨率点
        'palign' => '', //（字符串）允许将图像居中或对齐到当前行。可能的值为：L:Left-Align； C:Center；R:Right-Align；“”：空字符串：Left表示LTR，Right表示RTL。
        'ismask' => false, //（布尔值）如果此图像是一个掩码，则为true，否则为false
        'imgmask' => false, //此函数返回的param$imgmask（mixed）image对象或false
        'border' => 0, //（混合）指示是否必须在单元格周围绘制边框。该值可以是一个数字：0:无边框（默认）1:框或包含以下部分或全部字符的字符串（按任意顺序）：L:左、T:上、R:右、B:下或每个边框组的一组线条样式-例如：array（'LTRB'=>array（'width'=>2，'cap'=>'butt'、'join'=>'miter'、'dash'=>0，'color'=>array（0，0，0）））
        'fitbox' => false, //（混合）如果不是假比例图像尺寸，则按比例匹配（$w，$h）框。$fitbox可以是真的，也可以是2个字符的字符串，指示框内的图像对齐方式。第一个字符表示水平对齐（L=左，C=中，R=右），第二个字符表示垂直对齐（T=上，M=中，B=下）。
        'hidden' => false, //如果为真，则不显示图像。
        'fitonpage' => false, //（布尔值），如果为真，则图像的大小将调整为不超过页面尺寸。
        'alt' => false, //（布尔值）如果为真，则图像将作为替代项添加，而不是直接打印（将返回图像的ID）。
        'altimgs' => array(), //（array）备用图像ID数组。每个可选图像必须是一个具有两个值的数组：一个表示图像ID的整数（图像方法返回的值）和一个用于指示图像是否为默认打印图像的布尔值。
    ];

    public function __construct()
    {
    }

    /**
     *在页面中放置图像。
     *必须给出左上角。
     *可以用不同的方式指定尺寸：<ul>
     *<li>显式宽度和高度（以用户单位表示）</li>
     *<li>一个明确的尺寸，另一个自动计算以保持原始比例</li>
     *<li>无明确尺寸，在这种情况下，图像被置于72 dpi
     *支持的格式为jpeg和png图像，其中gd库和gd支持的所有图像：gd、gd2、gd2part、gif、jpeg、png、bmp、xbm、xpm；
     *可以从文件扩展名显式指定或推断格式。<br/>
     *可以在图像上放置链接。<br/>
     *备注：如果一个图像被多次使用，文件中只会嵌入一个副本。
     * @param $options
     */
    public static function image($options)
    {
        $options = self::getImageOptions($options);
        TcpdfService::$tcpdfObj->Image($options['file'], $options['x'], $options['y'], $options['w'], $options['h'], $options['type'], $options['link'], $options['align'], $options['resize'], $options['dpi'], $options['palign'], $options['ismask'], $options['imgmask'], $options['border'], $options['fitbox'], $options['hidden'], $options['fitonpage'], $options['alt'], $options['altimgs']);
    }

    public static function getImageOptions($options)
    {
        foreach (self::IAMGE_OPTIONS as $key => $item) {
            $options[$key] = $options[$key] ?? $item;
        }
        return $options;
    }

}