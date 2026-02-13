<?php

/**
 * Class TemplateTopMenu
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Widgets\Menus;

use Phoundation\Web\Html\Components\Anchor;
use Phoundation\Web\Html\Components\Widgets\Menus\TopMenu;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\Url;


class TemplateTopMenu extends TemplateRenderer
{
    /**
     * TopMenu class constructor
     */
    public function __construct(TopMenu $_component)
    {
        parent::__construct($_component);
    }


    /**
     * Render the HTML for the Mdb top menu
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $return = '<ul class="navbar-nav">
                        <li class="nav-item">
                            ' . Anchor::new('#')
                                      ->setClass('nav-link')
                                      ->addData('pushmenu', 'widget')
                                      ->setRole('button')
                                      ->setContent('<i class="fas fa-bars"></i>') . '
                        </li>
                        <li class="nav-item d-none d-sm-inline-block">
                            ' . Anchor::new(Url::newCurrent(), tr('Home'))->setClass('nav-link') . '
                        </li>';

        if ($this->_component->getSource()) {
            foreach ($this->_component->getSource() as $label => $entry) {
                if (is_string($entry))  {
                    $entry = ['url' => $entry];
                }

                $return .= '<li class="nav-item d-none d-sm-inline-block">
                                ' . Anchor::new($entry['url'], $label)->setContent('nav-link') . '  
                            </li>';
            }
        }

        return $return . '</ul>';;
    }
}
