<?php

return [
    /**
     * Automatic installation of a short link.
     *
     * The length parameter is responsible for the length of the characters of the short link. Default: 4
     * The chars parameters are responsible for the selection of symbols when selecting a short link.
     *
     * Default chars parametrs:
     *
     * 'global' => '0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ',
     * 'numeric' => '0123456789',
     * 'small' => 'abcdefghijklmnopqrstuvwxyz',
     * 'small_alphanumeric' => '0123456789abcdefghijklmnopqrstuvwxyz',
     * 'big' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
     * 'big_alphanumeric' => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
     * 'special' => '!@#$%^&*()',
     *
     */
    'generator' => [
        'length' => 4,
        'chars' => 'small',
    ],
];
