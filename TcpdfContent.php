<?php
namespace App\Services\Tcpdf;

class TcpdfContent
{
    const WRITE_OPTIONS = [
        'h' => 0, // 行高
        'txt' => '', // 字符串(写入的内容)
        'link' => '', // AddLink()返回的URL或者唯一标志资源
        'fill' => false, // 是否重新填充背景，true表示重新填充，false表示继承父背景
        'align' => 'L', // 对齐方式，L或者为空，则表示左对齐（默认）,C表示居中，R表示右对齐，J表示justify
        'ln' => true, // 设置光标的位置，true设置光标在行的底部，否则设置在行的顶部
        'stretch' => 0, // 字体拉伸模式。0：禁用； 1：仅当文本大于单元格宽度时水平缩放； 2：强制水平缩放以适应单元格宽度； 3：仅当文本大于单元格宽度时才使用字符间距； 4：强制字符间距以适应单元格宽度； 如果可能，将保留常规字体拉伸和缩放值。
        'firstline' => false, // 如果为true，则只打印第一行并返回剩余的字符串
        'firstblock' => false, // 如果为真，则字符串是行首
        'maxh' => 0, // 最大高度。它应该大于等于$h，小于页面底部的剩余空间，或者0表示禁用此功能
        'wadj' => 0, // 第一行宽度将减少这个数量（在HTML模式中使用）。
        'margin' => '', // 父容器的参数$Margin（数组）Margin数组
    ];

    const WRITEHTMLCELL_OPTIONS = [
        'w' => 0, // （浮动）单元格宽度。如果为0，则单元格将延伸到右边距。
        'h' => 0, // （浮动）单元格最小高度。如果需要，单元格将自动扩展。
        'x' => '', // （浮动）左上角X坐标
        'y' => '', // （浮动）左上角Y坐标
        'html' => '', // 要打印的参数$html（字符串）html文本。默认值：空字符串。
        'border' => 0, // 指示是否必须在单元格周围绘制边框。该值可以是一个数字：0(没有边界，默认值)、1（框架）、或包含以下部分或全部字符的字符串（按任意顺序）：L=>left,T=>top,R=>right,B=>bottom、或每个边框组的一组线条样式-例如：array（“LTRB”=>array（“width”=>2，“cap”=>“butt”，“join”=>“miter”，“dash”=>0，“color”=>array（0，0，0）））
        'ln' => 1, // （int）指示调用后的当前位置。可能的值为：0:右边（或左边，对于RTL语言）1:到下一行的开头 2:以下。设置为1等于放置0并在其后调用ln（）。默认值：0。
        'fill' => 0, // （布尔值）指示单元格背景必须绘制（true）还是透明（false）
        'reseth' => true, // （布尔值）如果为真，则重置最后一个单元格高度（默认为真）。
        'align' => 'L', //（字符串）允许文本居中或对齐。可能的值为：L:Left-Align | C:Center | R:Right-Align' | 空字符串：Left表示LTR，Right表示RTL
        'autopadding' => true, //（布尔值）如果为真，则使用内部填充并自动调整以说明行宽。
    ];

    const WRITETHML_OPTIONS = [
        'html' => '', //（字符串）文本
        'ln' => true, // （布尔值），如果为真，则在文本后添加新行（默认值=真）
        'fill' => false, // （布尔值）指示背景必须绘制（true）还是透明（false）。
        'reseth' => false, // （布尔值）如果为true，则重置最后一个单元格高度（默认为false）。
        'cell' => false, // （布尔值）如果为true，则在每次写入时添加当前的左（或右）填充（默认为false）。
        'align' => '', //（字符串）允许文本居中或对齐。可能的值为：L:Left-Align | C:Center | R:Right-Align' | 空字符串：Left表示LTR，Right表示RTL
    ];

    protected static $options = [];

    public function __construct()
    {
    }

    /**
     *允许保留某些HTML格式（有限支持）。
     *重要提示：HTML必须格式良好-在提交之前，请尝试使用HTML之类的应用程序清理它。
     *支持的标签有：a、b、blockquote、br、dd、del、div、dl、dt、em、font、h1、h2、h3、h4、h5、h6、hr、i、img、li、ol、p、pre、small、span、strong、sub、sup、table、tcpdf、td、th、thead、tr、tt、u、ul
     *注意：所有HTML属性必须用双引号括起来。
     * @param $options
     *
     */
    public static function writeHTML($options)
    {
        $options = self::getWriteHTMLOptions($options);
        return TcpdfService::$tcpdfObj->writeHTML($options['html'], $options['ln'], $options['fill'], $options['reseth'], $options['cell'], $options['align']);
    }

    public static function getWriteHTMLOptions($options)
    {
        foreach (self::WRITETHML_OPTIONS as $key => $item){
            $options[$key] = $options[$key] ?? $item;
        }
        self::$options['WRITETHML_OPTIONS'] = $options;
        return $options;
    }

    /**
     *打印带有可选边框、背景色和HTML文本字符串的单元格（矩形区域）。
     *单元格的左上角与当前位置相对应。呼叫后，当前位置移到右边或下一行。<br/>
     *如果启用了自动分页符，并且单元格超出了限制，则在输出前将完成分页符。
     *重要提示：HTML必须格式良好-在提交之前，请尝试使用HTML之类的应用程序清理它。
         *支持的标签有：a、b、blockquote、br、dd、del、div、dl、dt、em、font、h1、h2、h3、h4、h5、h6、hr、i、img、li、ol、p、pre、small、span、strong、sub、sup、table、tcpdf、td、th、thead、tr、tt、u、ul
     *注意：所有HTML属性必须用双引号括起来。
     * @请参见multicell（）、writehtml（）。
     * @param $options
     * @return int
     */
    public static function writeTHMLCell($options)
    {
        $options = self::getWriteHtmlCellOptions($options);
        // Print text using writeHTMLCell()
        return TcpdfService::$tcpdfObj->writeHTMLCell($options['w'], $options['h'], $options['x'], $options['y'], $options['html'], $options['border'], $options['ln'], $options['fill'], $options['reseth'], $http_response_header['align'],$options['autopadding']);
    }



    /**
     * @param $options
     * @return mixed
     */
    public static function getWriteHtmlCellOptions($options)
    {
        foreach (self::WRITEHTMLCELL_OPTIONS as $key => $item) {
            $options[$key] = $options[$key] ?? $item;
        }
        self::$options['WRITEHTMLCELL_OPTIONS'] = $options;
        return $options;
    }

    /**
     *此方法从当前位置打印文本。
     * @param $options
     * @return mixed
     */
    public static function write($options)
    {
        $options = self::getWriteOptions($options);
        // print a block of text using Write()
        return TcpdfService::$tcpdfObj->Write($options['h'], $options['txt'], $options['link'], $options['fill'], $options['align'], $options['ln'], $options['stretch'], $options['firstline'], $options['firstblock'], $options['maxh'], $options['wadj'], $options['margin']);
    }

    /**
     * @param $options
     * @return mixed
     */
    public static function getWriteOptions($options)
    {
        foreach (self::WRITE_OPTIONS as $key => $item) {
            $options[$key] = $options[$key] ?? $item;
        }
        self::$options["WRITE_OPTIONS"] = $options;
        return $options;
    }



    public function __get($name)
    {
        // TODO: Implement __get() method.
        try{
          return  self::$options[$name];
        }catch (\Exception $e){
            throw new \Exception('Can not found the options!');
        }
    }

    public static function formatHtml($html){
        $tags = [
            a,b,blockquote,br,dd,del,div,dl,dt,em,font,h1,h2,h3,h4,h5,h6,hr,i,img,li,ol,p,pre,small,span,strong,sub,sup,table,tcpdf,td,th,thead,tr,tt,u,ul
        ];

    }

}