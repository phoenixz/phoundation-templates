<?php

/**
 * Class TemplateGridColumn
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLteV4
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV4\Html\Layouts;

use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Layouts\GridColumn;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateGridColumn extends TemplateRenderer
{
    /**
     * GridColumn class constructor
     */
    public function __construct(GridColumn $_component)
    {
        parent::__construct($_component);
    }


    /**
     * Render this grid column
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $class        = $this->_component->getClass();
        $this->render = '   <div class="col' . (Html::safe($this->_component->getTier()->value) ? '-' . Html::safe($this->_component->getTier()->value) : '') . '-' . Html::safe($this->_component->getSize()->value) . ($class ? ' ' . $class : '') . '">';

        if ($this->_component->getFormObject()) {
            // Return column content rendered in a form
            $this->render .= $this->_component->getFormObject()->setContent($this->_component->getContent())->render();
            $this->_component->setFormObject(null);

        } else {
            $this->render .= $this->_component->getContent();
        }

        $this->render .= '</div>';
        return parent::render();
    }
}
