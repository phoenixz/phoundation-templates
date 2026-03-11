<?php

/**
 * Class TemplateSmallBox
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\AdminLteV3
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV3\Html\Components\Widgets\Boxes;

use Phoundation\Web\Html\Components\Anchor;
use Phoundation\Web\Html\Components\Widgets\Boxes\SmallBox;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateSmallBox extends TemplateRenderer
{
    /**
     * SmallBox class constructor
     */
    public function __construct(SmallBox $_component)
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
        $this->render = '   <div class="small-box bg-' . Html::safe($this->_component->getMode()->value) . ($this->_component->getShadow() ? ' ' . Html::safe($this->_component->getShadow()) : '') . '">
                              <div class="inner">
                                <h3>' . Html::safe($this->_component->get()) . '</h3>       
                                <p>' . Html::safe($this->_component->getTitle()) . '</p>
                              </div>
                              ' . (($this->_component->getProgress() !== null) ? '   <div class="progress">
                                                                                    <div class="progress-bar" style="width: ' . $this->_component->getProgress() . '%"></div>
                                                                                  </div>' : '') . '
                              ' . ($this->_component->getDescription() ? ' <p>' . Html::safe($this->_component->getDescription()) . '</p>' : '') . '                        
                              ' . ($this->_component->getIcon()        ? ' <div class="icon"><i class="fas ' . Html::safe($this->_component->getIcon()) . '"></i></div>' : '') . '
                              ' . ($this->_component->getUrl()         ? Anchor::new($this->_component->getUrl())->setClass('small-box-footer')->setContent(tr('More info') . ' <i class="fas fa-arrow-circle-right"></i>') : null) . '                        
                            </div>';

        return parent::render();
    }
}
