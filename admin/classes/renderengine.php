<?php

class RenderEngine{

    public $twig;

    public function __construct(){
        $loader = new Twig\Loader\FilesystemLoader(ROOT_DIR.'/admin/templates');
        $this->twig = new \Twig\Environment($loader, [
            // 'cache' => ROOT_DIR.'/admin/cache',
            'cache' => false,
            'debug' => true,
            ]);
        $this->twig->addExtension(new TwigExtension());
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    public function render(String $name,Array $values){
        echo $this->twig->render($name.'.twig',$values);
    }
}