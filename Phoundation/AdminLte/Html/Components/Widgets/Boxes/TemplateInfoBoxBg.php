<?php

/**
 * Class TemplateInfoBoxBg
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Components\Widgets\Boxes;

use Phoundation\Web\Html\Components\Widgets\Boxes\InfoBoxBg;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateInfoBoxBg extends TemplateRenderer
{
    /**
     * InfoBoxBg class constructor
     */
    public function __construct(InfoBoxBg $_component)
    {
        parent::__construct($_component);
    }


    /**
     * Renders and returns the HTML for this SmallBox object
     *
     * @inheritDoc
     */
    public function render(): ?string
    {
        $this->render = '   <div class="info-box bg-' . Html::safe($this->_component->getMode()->value) . '">
                              <span class="info-box-icon"><i class="far ' . Html::safe($this->_component->getIcon()) . '"></i></span>
                
                              <div class="info-box-content">
                                <span class="info-box-text">' . Html::safe($this->_component->getTitle()) . '</span>
                                <span class="info-box-number">' . Html::safe($this->_component->get()) . '</span>
                
                                ' . (($this->_component->getProgress() !== null) ? ' <div class="progress">
                                                                                    <div class="progress-bar" style="width: ' . Html::safe($this->_component->getProgress()) . '%"></div>
                                                                                  </div>' : '') . '
                                <span class="progress-description">
                                  ' . Html::safe($this->_component->getDescription()) . '
                                </span>
                              </div>
                              <!-- /.info-box-content -->
                            </div>';

        return parent::render();
    }
}
