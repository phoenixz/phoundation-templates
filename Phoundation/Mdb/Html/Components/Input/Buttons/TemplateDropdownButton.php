<?php

/**
 * Class TemplateDropdownButton
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Input\Buttons;

use Phoundation\Web\Html\Components\Input\Buttons\Button;
use Phoundation\Web\Html\Components\Input\Buttons\DropdownButton;


class TemplateDropdownButton extends TemplateButtons
{
    /**
     * Buttons class constructor
     */
    public function __construct(DropDownButton $o_component)
    {
        parent::__construct($o_component);
    }


    /**
     * Renders and returns the buttons HTML
     *
     * @return string|null
     */
    public function render(): ?string
    {
        if (empty($this->render)) {
            $render        = [];
            $this->render  = '<div class="dropdown">' .
                                 Button::new()
                                       ->setWrapping($this->o_component->getWrapping())
                                       ->setOutlined($this->o_component->getOutlined())
                                       ->setRounded($this->o_component->getRounded())
                                       ->setOutlined($this->o_component->getOutlined())
                                       ->setContent($this->o_component->getContent())
                                       ->addClass($this->o_component->getClass())
                                       ->setValue($this->o_component->getValue())
                                       ->setFloatRight($this->o_component->getFloatRight())
                                       ->setMode($this->o_component->getMode())
                                       ->setName($this->o_component->getName())
                                       ->addClasses(['dropdown-toggle'])
                                       ->addData(null, 'mdb-dropdown-init') .
                                 '<ul class="dropdown-menu no-min-width" aria-labelledby="dropdownMenuButton">';

            foreach ($this->o_component->getSource() as $button) {
                $render[] =      '    <li>' . $button . '</li>';
            }

            $this->render .= implode(' ', $render);
            $this->render .= '    </ul>
                              </div>';
        }

        return parent::render();
    }
}
