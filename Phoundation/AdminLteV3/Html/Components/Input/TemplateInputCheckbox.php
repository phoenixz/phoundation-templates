<?php

/**
 * Class TemplateInputCheckbox
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\AdminLteV3
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV3\Html\Components\Input;

use Phoundation\Web\Html\Components\Input\InputCheckbox;


class TemplateInputCheckbox extends TemplateInput
{
    /**
     * Tracks the class of the container div
     *
     * @var string $class
     */
    protected string $class = 'custom-checkbox';


    /**
     * InputCheckbox class constructor
     */
    public function __construct(InputCheckbox $_component)
    {
        parent::__construct($_component);
        $_component->removeClass('form-control')->addClass('form-check-input');
    }


    /**
     * Render and return the HTML for this object
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $_component = $this->getComponentObject();
        $label      = $_component->getLabel() ? '<label for="' . $_component->getId() . '" class="custom-control-label">' . $_component->getLabel() . '</label>'
                                               : '';

        return '<div class="custom-control ' . $this->class . '">' .
                    ($_component->getLabelAfter() ? parent::render() . $label
                                                   : $label . parent::render())
             . '</div>';
    }
}
