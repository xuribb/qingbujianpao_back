<?php

return [
    'default' => 'file',
    'stores'  => [
        'file' => [
            'type'       => 'File',
            'path'       => '',
            'prefix'     => '',
            'expire'     => 3600,
            'tag_prefix' => 'tag:',
            'serialize'  => [],
        ]
    ],
];
