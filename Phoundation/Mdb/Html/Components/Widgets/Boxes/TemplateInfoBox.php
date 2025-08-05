<?php

/**
 * Class TemplateInfoBox
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Widgets\Boxes;

use Phoundation\Web\Html\Components\Widgets\Boxes\InfoBox;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateInfoBox extends TemplateRenderer
{
    /**
     * InfoBox class constructor
     */
    public function __construct(InfoBox $o_component)
    {
        parent::__construct($o_component);
    }


    /**
     * Renders and returns the HTML for this SmallBox object
     *
     * @inheritDoc
     */
    public function render(): ?string
    {
        $this->render = '   <div class="info-box shadow-none">
                              <span class="info-box-icon bg-' . Html::safe($this->o_component->getMode()->value) . '"><i class="far ' . Html::safe($this->o_component->getIcon()) . '"></i></span>
                
                              <div class="info-box-content">
                                <span class="info-box-text">' . Html::safe($this->o_component->getTitle()) . '</span>
                                <span class="info-box-number">' . Html::safe($this->o_component->get()) . '</span>
                              </div>
                              ' . Html::safe($this->o_component->getDescription()) . '
                            </div>';

        return parent::render();
    }
}
