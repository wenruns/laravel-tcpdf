<?php
return [
    'orientation' => 'P',   // 页面方向，可选值：P(portrait|默认值) | L(landscape) | 空字符串表示自动（automatic orientation）
    'unit' => 'mm',         // 用户度量单位，可选值：pt(point) | mm(millimeter|默认值) | cm(centimeter) | in(inch)
    'format' => 'A4',       // 页面的格式，它可以是：在getpagesizefromformat（）中指定的字符串值之一，也可以是在setpageformat（）中指定的参数数组
    'unicode' => true,      // （布尔值）true表示输入文本为unicode（默认值=true）
    'encoding' => 'UTF-8',  // （string）字符集编码（仅在转换回HTML实体时使用）；默认值为utf-8。
    'diskcache' => false,   // 已弃用功能
    'pdfa' => false,        // 如果为真，则将文档设置为PDF/A模式。

    'PDF_HEADER' => [
        'src' => 'http://xxx/logo.png', // 设置页头logo的src地址
        'width' => 0, // 设置页头logo宽度
        'title' => 'Example', // 设置页头标题
        'description' => 'This is an Example!', // 设置页头描述文字
        'textColor' => [255, 64, 0], // RGB(彩色表)，设置页头文字的颜色
        'lineColor' => [255, 64, 128], // 设置页头下划线的颜色,
        'font'  => [
            'stsongstdlight', // 字体
//            'helvetica', // 字体
            '', // style
            10 // 大小
        ],
        'margin' => 5, //页头边距
    ],

    'PDF_FOOTER' => [
        'text_color' => [255, 64, 0], // 页脚文本颜色
        'line_color' => [255, 64, 128], // 页脚横线颜色
        'font'  => [
            'stsongstdlight', // 字体
//            'helvetica', // 字体
            '', // style
            8, // 大小
        ],
        'margin' => 10, //
    ],

    'PDF_DOC_INFO' => [
        'title' => 'wenruns', // 文档标题
        'creator' => 'wenruns', // 文档创建者
        'author' => 'wenruns', // 作者
        'subject' => 'wenruns', //
        'keywords' => 'wenruns', // 关键词
        'monospaced' => 'courier', // 设置默认空格字体
        'margin' => [
            'left' => 15,
            'top' => 27,
            'right' => 15,
            'keepmargins' => false, // 如果为true，则覆盖默认页边距
        ],
        'auto_page_break' => [ //设置自动分页符
            'auto' => true,  // 布尔值，指示模式应该是打开还是关闭
            'margin' => 25,
        ],
        'image_scale' => 1.25, // 设置图像比例因子，
        'lang_file' => __DIR__.'/lang/eng.php', // 设置一些语言相关的字符串（可选）
        'font' => [
            'family' => 'stsongstdlight', // 系列字体
//            'family' => 'helvetica', // 系列字体
            'style' => '', // 字体样式
            'size' => 14, // 字体大小（以磅为单位）
            'fontfile' => '',  //  字体定义文件
            'subset' => 'default', //如果为true，则仅嵌入字体的一个子集（仅存储与所用字符相关的信息）；如果为false，则嵌入完整字体；如果为'default'，则使用setfontsubset（）设置的默认值。此选项仅对TrueTypeUnicode字体有效。如果要允许用户更改文档，请将此参数设置为false。如果您对字体进行了子集设置，则接收您的PDF的人将需要具有相同的字体才能对您的PDF进行更改。PDF的文件大小也会更小，因为您只嵌入了部分字体。
            'out' => true, // 如果为true，则输出字体大小命令，否则只设置字体属性。
        ],
    ],
];