<?php

/**
 * Class TemplateGridRow
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Layouts;

use Phoundation\Web\Html\Layouts\GridRow;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateGridRow extends TemplateRenderer
{
    /**
     * GridRow class constructor
     */
    public function __construct(GridRow $o_component)
    {
        parent::__construct($o_component);
    }


    /**
     * Render this grid row
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $class        = $this->o_component->getClass();
        $this->render = '<div class="row' . ($class ? ' ' . $class : '') . '">';

        if ($this->o_component->getForm()) {
            // Return content rendered in a form
            $render = '';

            foreach ($this->o_component->getSource() as $column) {
                $render .= $column->render();
            }

            $this->render .= $this->o_component->getForm()->setContent($render)->render();
            $this->o_component->setForm(null);
        } else {
            foreach ($this->o_component->getSource() as $column) {
                $this->render .= $column->render();
            }
        }

        $this->render .= '</div>';
        return parent::render();
    }
}
