<?php

/**
 * Class TemplateDropdownButton
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
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
    public function __construct(DropDownButton $_component)
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
        if (empty($this->render)) {
            $render        = [];
            $this->render  = '<div class="dropdown">' .
                                 Button::new()
                                       ->setWrapping($this->_component->getWrapping())
                                       ->setOutlined($this->_component->getOutlined())
                                       ->setRounded($this->_component->getRounded())
                                       ->setOutlined($this->_component->getOutlined())
                                       ->setContent($this->_component->getContent(), false)
                                       ->addClass($this->_component->getClass())
                                       ->setValue($this->_component->getValue())
                                       ->setFloatRight($this->_component->getFloatRight())
                                       ->setMode($this->_component->getMode())
                                       ->setName($this->_component->getName())
                                       ->addClasses(['dropdown-toggle'])
                                       ->addData('', 'mdb-dropdown-init') .
                                 '<ul class="dropdown-menu no-min-width" aria-labelledby="dropdownMenuButton">';

            foreach ($this->_component->getSource() as $button) {
                $render[] =      '    <li>' . $button . '</li>';
            }

            $this->render .= implode(' ', $render);
            $this->render .= '    </ul>
                              </div>';
        }

        return parent::render();
    }
}
