<?php

return [
    'mode'                     => 'utf-8',
    'format'                   => 'A4',
    'default_font_size'        => '12',
    'default_font'             => 'notosansjp',
    // 'default_font'             => 'sans-serif',
    'margin_left'              => 20,
    'margin_right'             => 20,
    'margin_top'               => 20,
    'margin_bottom'            => 20,
    'margin_header'            => 0,
    'margin_footer'            => 0,
    'orientation'              => 'P',
    // 'font_path'                => storage_path('fonts/'), // add
    'title'                    => 'Laravel mPDF',
    'subject'                  => '',
    'author'                   => '',
    'watermark'                => '',
    'show_watermark'           => false,
    'show_watermark_image'     => false,
    'watermark_font'           => 'sans-serif',
    'display_mode'             => 'fullpage',
    'watermark_text_alpha'     => 0.1,
    'watermark_image_path'     => '',
    'watermark_image_alpha'    => 0.2,
    'watermark_image_size'     => 'D',
    'watermark_image_position' => 'P',
    'custom_font_dir'          => storage_path('fonts/'),
    'custom_font_data'         => [
        'ipagothic' => [
            'R' => 'ipag.ttf',
            'B' => 'ipag.ttf',
            'I' => 'ipag.ttf',
            'BI' => 'ipag.ttf',
            'useOTL' => 0xFF,
            'useKashida' => 75,
        ],
        'ipamincho' => [
            'R' => 'ipam.ttf',
            'B' => 'ipam.ttf',
            'I' => 'ipam.ttf',
            'BI' => 'ipam.ttf',
            'useOTL' => 0xFF,
            'useKashida' => 75,
        ],
        'notosansjp' => [
            'R' => 'NotoSansJP-VariableFont_wght.ttf',
            'B' => 'NotoSansJP-VariableFont_wght.ttf',  // ボールド版がある場合
            'I' => 'NotoSansJP-VariableFont_wght.ttf',  // イタリック版がない場合は Regular を使用
            'BI' => 'NotoSansJP-VariableFont_wght.ttf', // ボールドイタリック版がない場合は Bold を使用
            'useOTL' => 0xFF,
            'useKashida' => 75,
        ],
    ],
    'auto_language_detection'  => true,
    // 'temp_dir'                 => storage_path('app'),
    'temp_dir'                 => storage_path('storage/app/mpdf'),
    'pdfa'                     => false,
    'pdfaauto'                 => false,
    'use_active_forms'         => false,
];
