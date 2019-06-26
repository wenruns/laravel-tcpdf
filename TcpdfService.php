<?php
namespace App\Services\Tcpdf;

use TCPDF;


class TcpdfService
{
    public static $tcpdfObj = null;

    public static $options = [];

    public static $instances = [];

    const METHOD_INSTANCE = [
        'write' => '\App\Services\Tcpdf\TcpdfContent',
        'writeHTMLCell' => '\App\Services\Tcpdf\TcpdfContent',
        'writeHTML' => '\App\Services\Tcpdf\TcpdfContent',
        'outPut' => '\App\Services\Tcpdf\TcpdfOutput',
        'image' => '\App\Services\Tcpdf\TcpdfImage',
    ];

    const PDF_CONFIGS = [
        'orientation' => 'P',   // 页面方向，可选值：P(portrait|默认值) | L(landscape) | 空字符串表示自动（automatic orientation）
        'unit' => 'mm',         // 用户度量单位，可选值：pt(point) | mm(millimeter|默认值) | cm(centimeter) | in(inch)
        'format' => 'A4',       // 页面的格式，它可以是：在getpagesizefromformat（）中指定的字符串值之一，也可以是在setpageformat（）中指定的参数数组
        'unicode' => true,      // （布尔值）true表示输入文本为unicode（默认值=true）
        'encoding' => 'UTF-8',  // （string）字符集编码（仅在转换回HTML实体时使用）；默认值为utf-8。
        'diskcache' => false,   // 已弃用功能
        'pdfa' => false,        // 如果为真，则将文档设置为PDF/A模式。
    ];

    public function __construct($options = [])
    {
//        dd(config('tcpdf', self::PDF_CONFIGS));
        self::$options = array_merge(config('tcpdf', self::PDF_CONFIGS), $options);
        // create new PDF document
        self::$tcpdfObj = new TCPDF(self::$options['orientation'], self::$options['unit'], self::$options['format'], self::$options['unicode'], self::$options['encoding'], self::$options['diskcache'], self::$options['pdfa']);
        $this->initTcpdf();
    }


    public function initTcpdf()
    {
        // set header and footer fonts
        self::$instances['document'] = new TcpdfDoc();
        self::$instances['header'] = new TcpdfHeader();
        self::$instances['footer'] = new TcpdfFooter();
        // add a page
        self::$tcpdfObj->AddPage();
    }



    public function getInstance($method, $params = [])
    {
        if(isset(self::METHOD_INSTANCE[$method])){
            $class = self::METHOD_INSTANCE[$method];
            if(!isset(self::$instances[$class]) || !self::$instances[$class]){
                self::$instances[$class] = new $class;
            }
            return self::$instances[$class];
        }
        return false;
    }

    public function getOptions($name, $arguments)
    {
        $pattern = '/get(\S+)Options/';
        preg_match($pattern, $name, $matches);
        if(!empty($matches)){
            $method = lcfirst($matches[1]);
            $instance = $this->getInstance($method);
            if($instance){
                $const = strtoupper($method).'_OPTIONS';
                return $instance->$const;
            }else{
                throw new \Exception("Can not get the options of $method , the instance is not found!");
            }
        }
        return false;
    }

    public static function addPage($orientation='', $format='', $keepmargins=false, $tocpage=false){
        self::$tcpdfObj->AddPage($orientation, $format, $keepmargins, $tocpage);
    }


    public function __call($name, $arguments)
    {
        $res = $this->getOptions($name, $arguments);
        if($res){
            return $res;
        }
        // TODO: Implement __call() method.
        $instance = $this->getInstance($name);
        if($instance){
            $instance->$name(...$arguments);
        }else{
            throw new \Exception("The method $name is not found!");
        }
    }
}