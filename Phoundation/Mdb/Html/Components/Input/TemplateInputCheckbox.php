<?php

/**
 * Class TemplateInputCheckbox
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Input;

use Phoundation\Web\Html\Components\Input\InputCheckbox;


class TemplateInputCheckbox extends TemplateInput
{
    /**
     * InputCheckbox class constructor
     */
    public function __construct(InputCheckbox $o_component)
    {
        parent::__construct($o_component);
        $o_component->getClasses()->removeKeys('form-control')->add(true, 'form-check-input');
    }


    /**
     * Render and return the HTML for this object
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $component = $this->getComponentObject();

        return '<div class="form-check' . ($component->getInline() ? ' form-check-inline' : '') . '">
                    ' . parent::render() . '
                    ' . ($component->getLabel() ? '<label for="' . $component->getId() . '" class="form-check-label">' . $component->getLabel() . '</label>' : '') . '
                </div>';
    }
}
