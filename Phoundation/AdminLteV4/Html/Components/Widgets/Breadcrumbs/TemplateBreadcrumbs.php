<?php

/**
 * Class TemplateBreadcrumbs
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLteV3
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV3\Html\Components\Widgets\Breadcrumbs;

use Phoundation\Utils\Strings;
use Phoundation\Web\Html\Components\Anchor;
use Phoundation\Web\Html\Components\Interfaces\AnchorInterface;
use Phoundation\Web\Html\Components\Widgets\Interfaces\BreadcrumbsInterface;
use Phoundation\Web\Html\Enums\EnumAnchorRenderRightsFail;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\Url;

class TemplateBreadcrumbs extends TemplateRenderer
{
    /**
     * Breadcrumbs class constructor
     */
    public function __construct(BreadcrumbsInterface $_component)
    {
        parent::__construct($_component);
    }


    /**
     * Renders and returns the HTML for this component
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $this->render = ' <ol class="breadcrumb float-sm-right">';

        if ($this->_component->getSource()) {
            foreach ($this->_component->getSource() as $url => $label) {
                // Limit label size for normal use
                if ($label instanceof AnchorInterface) {
                    $label->setContent(Strings::capitalize(Strings::truncate($label->getContent(), 48)));

                    $this->render .= '<li class="breadcrumb-item">' . $label->setRenderRightsFail(EnumAnchorRenderRightsFail::no_url) . '</li>';

                } else {
                    $label = Strings::capitalize(Strings::truncate($label, 48));

                    if (is_int($url) or empty($url)) {
                        $this->render .= '<li class="breadcrumb-item">' . Html::safe($label) . '</li>';

                    } else {
                        $this->render .= '<li class="breadcrumb-item">' . Anchor::new(Url::new($url), $label) . '</a></li>';
                    }
                }
            }
        }

        $this->render .= '</ol>';

        return parent::render();
    }
}
