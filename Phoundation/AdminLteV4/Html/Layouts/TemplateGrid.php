<?php

/**
 * Class TemplateGrid
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLteV3
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV3\Html\Layouts;

use Phoundation\Web\Html\Layouts\Grid;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateGrid extends TemplateRenderer
{
    /**
     * Grid class constructor
     */
    public function __construct(Grid $_component)
    {
        parent::__construct($_component);
    }


    /**
     * Render the HTML for this grid
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $class        = $this->_component->getClass();
        $this->render = '<div class="container-fluid' . ($class ? ' ' . $class : '') . '">';

        if ($this->_component->getFormObject()) {
            // Return content rendered in a form
            $render = '';

            foreach ($this->_component->getSource() as $row) {
                $render .= $row->render();
            }

            $this->render .= $this->_component->getFormObject()->setContent($render)->render();
            $this->_component->setFormObject(null);

        } else {
            foreach ($this->_component->getSource() as $row) {
                $this->render .= $row->render();
            }
        }

        $this->render .= '</div>';
        return parent::render();
    }
}
