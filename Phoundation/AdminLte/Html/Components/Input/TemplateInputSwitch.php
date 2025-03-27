<?php

/**
 * Class TemplateInputSwitch
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Components\Input;

use Phoundation\Exception\UnderConstructionException;
use Phoundation\Web\Html\Components\Input\InputSwitch;


class TemplateInputSwitch extends TemplateInputCheckbox
{
    /**
     * TemplateInputRadio class constructor
     */
    public function __construct(InputSwitch $o_component)
    {
throw new UnderConstructionException('PLEASE IMPLEMENT \ADMINLTE\TEMPLATEINPUTSWITCH FIRST');
        parent::__construct($o_component);
        $o_component->getClassesObject()->removeKeys('form-control')->add(true, 'form-check-input');
    }


    /**
     * Render and return the HTML for this object
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $component = $this->getComponentObject();

        return '<div class="custom-control ' . $this->class . '">
                    ' . parent::render() . '
                    ' . ($component->getLabel() ? '<label for="' . $component->getId() . '" class="custom-control-label">' . $component->getLabel() . '</label>' : '') . '
                </div>';
    }
}
