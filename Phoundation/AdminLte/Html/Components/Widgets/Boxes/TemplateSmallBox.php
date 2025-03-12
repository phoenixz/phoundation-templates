<?php

/**
 * Class TemplateSmallBox
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Components\Widgets\Boxes;

use Phoundation\Web\Html\Components\Widgets\Boxes\SmallBox;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateSmallBox extends TemplateRenderer
{
    /**
     * SmallBox class constructor
     */
    public function __construct(SmallBox $o_component)
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
        $this->render = '   <div class="small-box bg-' . Html::safe($this->o_component->getMode()->value) . ($this->o_component->getShadow() ? ' ' . Html::safe($this->o_component->getShadow()) : '') . '">
                              <div class="inner">
                                <h3>' . Html::safe($this->o_component->get()) . '</h3>       
                                <p>' . Html::safe($this->o_component->getTitle()) . '</p>
                              </div>
                              ' . (($this->o_component->getProgress() !== null) ? '   <div class="progress">
                                                                                    <div class="progress-bar" style="width: ' . $this->o_component->getProgress() . '%"></div>
                                                                                  </div>' : '') . '
                              ' . ($this->o_component->getDescription() ? '<p>' . Html::safe($this->o_component->getDescription()) . '</p>' : '') . '                        
                              ' . ($this->o_component->getIcon() ? '  <div class="icon">
                                                        <i class="fas ' . Html::safe($this->o_component->getIcon()) . '"></i>
                                                    </div>' : '') . '
                              ' . ($this->o_component->getUrl() ? ' <a href="' . Html::safe($this->o_component->getUrl()) . '" class="small-box-footer">
                                                    ' . tr('More info') . ' <i class="fas fa-arrow-circle-right"></i>
                                                  </a>' : '') . '                        
                            </div>';

        return parent::render();
    }
}
