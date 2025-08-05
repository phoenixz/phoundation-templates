<?php

/**
 * Class TemplateBreadCrumbs
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Widgets;

use Phoundation\Utils\Strings;
use Phoundation\Web\Html\Components\Interfaces\AnchorInterface;
use Phoundation\Web\Html\Components\Widgets\BreadCrumbs;
use Phoundation\Web\Html\Enums\EnumAnchorRenderRightsFail;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\Url;


class TemplateBreadCrumbs extends TemplateRenderer
{
    /**
     * BreadCrumbs class constructor
     */
    public function __construct(BreadCrumbs $o_component)
    {
        parent::__construct($o_component);
    }


    /**
     * Renders and returns the HTML for this component
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $this->render = ' <ol class="breadcrumb float-sm-right">';

        if ($this->o_component->getSource()) {
            $count = count($this->o_component->getSource());
            $count--;

            foreach ($this->o_component->getSource() as $url => $label) {
                // Limit label size for normal use
                if ($label instanceof AnchorInterface) {
                    $label->setContent(Strings::capitalize(Strings::truncate($label->getContent(), 48)));

                    if (!--$count) {
                        // The last item is the active item, the active item has (need) no URL
                        $this->render .= '<li class="breadcrumb-item active">' . $label->setHref(null) . '</li>';

                    } else {
                        $this->render .= '<li class="breadcrumb-item">' . $label->setRenderRightsFail(EnumAnchorRenderRightsFail::no_url) . '</li>';
                    }

                } else {
                    $label = Strings::capitalize(Strings::truncate($label, 48));

                    if (!--$count) {
                        // The last item is the active item
                        $this->render .= '<li class="breadcrumb-item active">' . Html::safe($label) . '</li>';

                    } elseif (is_int($url)) {
                        $this->render .= '<li class="breadcrumb-item">' . Html::safe($label) . '</li>';

                    } else {
                        $this->render .= '<li class="breadcrumb-item"><a href="' . Html::safe(Url::new($url)->makeWww()) . '">' . Html::safe($label) . '</a></li>';
                    }
                }
            }
        }

        $this->render .= '</ol>';

        return parent::render();
    }
}
