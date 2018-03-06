<?php

namespace Tinitter\Misc\TwigExt;

class CsrfExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{

    protected $csrf;

    public function __construct($token)
    {
        $this->csrf = $token;
    }

    public function getGlobals()
    {
        return [
            'csrf'   => [
                'value' => $this->csrf
            ]
        ];
    }

    public function getName()
    {
        return 'my/csrf';
    }
}