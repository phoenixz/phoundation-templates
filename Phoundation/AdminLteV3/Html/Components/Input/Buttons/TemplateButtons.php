<?php

/**
 * Class TemplateButtons
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLteV3
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV3\Html\Components\Input\Buttons;

use Phoundation\Web\Html\Components\Input\Buttons\Buttons;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateButtons extends TemplateRenderer
{
    /**
     * Buttons class constructor
     */
    public function __construct(Buttons $_component)
    {
        parent::__construct($_component);
    }


    /**
     * Renders and returns the buttons HTML
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $render       = [];
        $this->render = '';

        if ($this->_component->getGroup()) {
            $this->render .= '<div class="btn-group" role="group" aria-label="Button group">';
        }

        foreach ($this->_component->getSource() as $button) {
            if (is_string($button)) {
                $render[] = $button;

            } else {
                $render[] = $button->render();
            }
        }

        $this->render = implode(' ', $render);

        if ($this->_component->getGroup()) {
            $this->render .= '</div>';
        }

        return parent::render();
    }
}
