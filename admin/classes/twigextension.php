<?php

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigExtension extends AbstractExtension{
    // public function getFilters()
    // {
    //   return array(
    //     new Twig_SimpleFilter('markdown', array($this, 'markdownParse'), array('is_safe' => array('html')))
    //   );
    // }
  
    public function getFunctions()
    {
      return array(
        new TwigFunction('activeClass', array($this, 'activeClass'), array('needs_context' => TRUE)),
        new TwigFunction('getUsername', array($this, 'getUsername')),
      );
    }

    public function activeClass(array $context, $page)
    {
      if (isset($context['current_page']) && $context['current_page'] === $page) {
        return 'active';
      }
    }
    public function getUsername(String $uuid){
      return Users::find_by_attribute("uuid",$uuid)->username;
    }
}