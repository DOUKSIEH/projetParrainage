<?php

namespace App\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class HtmlExtension extends AbstractExtension
{

    /**
     * Initializes the runtime environment.
     *
     * This is where you can load some file that contains filter functions for instance.
     *
     * @deprecated since 1.23 (to be removed in 2.0), implement \Twig_Extension_InitRuntimeInterface instead
     */
    public function initRuntime(Environment $environment)
    {
        // TODO: Implement initRuntime() method.
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     *
     * @deprecated since 1.23 (to be removed in 2.0), implement \Twig_Extension_GlobalsInterface instead
     */
    public function getGlobals()
    {
        // TODO: Implement getGlobals() method.
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     *
     * @deprecated since 1.26 (to be removed in 2.0), not used anymore internally
     */
    public function getName()
    {
        // TODO: Implement getName() method.
    }

    public function getFilters()
    {
        return [
            new TwigFilter('figure', [$this, 'figureFilter']),
        ];
    }

    public function figureFilter($image)
    {
        $filter = "<figure>
                         <img src=$image>
                    </figure>";


        return $filter;
    }

}
