<?php

/**
 * Class TemplateGrid
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Layouts;

use Phoundation\Web\Html\Layouts\Grid;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateGrid extends TemplateRenderer
{
    /**
     * Grid class constructor
     */
    public function __construct(Grid $o_component)
    {
        parent::__construct($o_component);
    }


    /**
     * Render the HTML for this grid
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $class        = $this->o_component->getClass();
        $this->render = '<div class="container-fluid' . ($class ? ' ' . $class : '') . '">';

        if ($this->o_component->getForm()) {
            // Return content rendered in a form
            $render = '';

            foreach ($this->o_component->getSource() as $row) {
                $render .= $row->render();
            }

            $this->render .= $this->o_component->getForm()->setContent($render)->render();
            $this->o_component->setForm(null);
        } else {
            foreach ($this->o_component->getSource() as $row) {
                $this->render .= $row->render();
            }
        }

        $this->render .= '</div>';
        return parent::render();
    }
}
