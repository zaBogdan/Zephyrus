<?php

namespace Api\Misc;

class Render{

    public $twig;

    public function __construct(){
        $loader = new \Twig\Loader\FilesystemLoader(ROOT_DIR.'/admin/templates');
        $this->twig = new \Twig\Environment($loader, [
            // 'cache' => ROOT_DIR.'/admin/cache',
            'cache' => false,
            ]);
        $this->twig->addExtension(new \Api\Misc\TwigExtension());
    }

    
    public function render(String $name,Array $values){
        echo $this->twig->render($name.'.twig',$values);
    }
    public function load(String $name,Array $values){
        return $this->twig->render($name.'.twig',$values);
    }

    public function escape_name(String $name){
        for($i=0;$i<strlen($name);$i++)
            if(strchr("-/_+=-",$name[$i]))
                $name[$i]=' ';
        return $name;
    }
}