<?php

/**
 * Class TemplateGridColumn
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Layouts;

use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Layouts\GridColumn;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateGridColumn extends TemplateRenderer
{
    /**
     * GridColumn class constructor
     */
    public function __construct(GridColumn $o_component)
    {
        parent::__construct($o_component);
    }


    /**
     * Render this grid column
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $class        = $this->o_component->getClass();
        $this->render = '   <div class="col' . (Html::safe($this->o_component->getTier()->value) ? '-' . Html::safe($this->o_component->getTier()->value) : '') . '-' . Html::safe($this->o_component->getSize()->value) . ($class ? ' ' . $class : '') . '">';

        if ($this->o_component->getForm()) {
            // Return column content rendered in a form
            $this->render .= $this->o_component->getForm()->setContent($this->o_component->getContent())->render();
            $this->o_component->setForm(null);
        } else {
            $this->render .= $this->o_component->getContent();
        }

        $this->render .= '</div>';
        return parent::render();
    }
}
