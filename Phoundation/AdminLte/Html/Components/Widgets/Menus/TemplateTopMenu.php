<?php

/**
 * Class TemplateTopMenu
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Components\Widgets\Menus;

use Phoundation\Web\Html\Components\Widgets\Menus\TopMenu;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\Url;


class TemplateTopMenu extends TemplateRenderer
{
    /**
     * TopMenu class constructor
     */
    public function __construct(TopMenu $o_component)
    {
        parent::__construct($o_component);
    }


    /**
     * Render the HTML for the AdminLte top menu
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $return = '<ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                        </li>
                        <li class="nav-item d-none d-sm-inline-block">
                            <a href="' . Html::safe(Url::newCurrent()) . '" class="nav-link">' . tr('Home') . '</a>
                        </li>';

        if ($this->o_component->getSource()) {
            foreach ($this->o_component->getSource() as $label => $entry) {
                if (is_string($entry))  {
                    $entry = ['url' => $entry];
                }

                $return .= '<li class="nav-item d-none d-sm-inline-block">
                                <a href="' . Html::safe($entry['url']) . '" class="nav-link">' . Html::safe($label) . '</a>
                            </li>';
            }
        }

        return $return . '</ul>';;
    }
}
