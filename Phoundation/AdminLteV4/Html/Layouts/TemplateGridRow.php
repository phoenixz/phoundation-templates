<?php

/**
 * Class TemplateGridRow
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\AdminLteV4
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV4\Html\Layouts;

use Phoundation\Web\Html\Layouts\GridRow;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateGridRow extends TemplateRenderer
{
    /**
     * GridRow class constructor
     */
    public function __construct(GridRow $_component)
    {
        parent::__construct($_component);
    }


    /**
     * Render this grid row
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $class        = $this->_component->getClass();
        $name         = $this->_component->getName();
        $id           = $this->_component->getId();

        $this->render = '<div class="row' . ($class ? ' '       . $class      : '') . '"'
                                          . ($name  ? ' name="' . $name . '"' : '')
                                          . ($id    ? ' id="'   . $id   . '"' : '') .'>';

        if ($this->_component->getFormObject()) {
            // Return content rendered in a form
            $render = '';

            foreach ($this->_component->getSource() as $column) {
                $render .= $column->render();
            }

            $this->render .= $this->_component->getFormObject()->setContent($render)->render();
            $this->_component->setFormObject(null);

        } else {
            foreach ($this->_component->getSource() as $column) {
                $this->render .= $column->render();
            }
        }

        $this->render .= '</div>';
        return parent::render();
    }
}
