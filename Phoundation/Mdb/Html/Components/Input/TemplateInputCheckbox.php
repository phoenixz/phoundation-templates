<?php

/**
 * Class TemplateInputCheckbox
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Input;

use Phoundation\Web\Html\Components\Input\InputCheckbox;


class TemplateInputCheckbox extends TemplateInput
{
    /**
     * Tracks the type of control to render
     *
     * @var string|null $type
     */
    protected ?string $type_class = null;


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
        $label       = $_component->getLabel() ? '<label for="' . $_component->getId() . '" class="form-check-label">' . $_component->getLabel() . '</label>'
                                                : '';

        return '<div class="form-check' . ($_component->getInline() ? ' form-check-inline' : '') . $this->type_class . '">
                    ' . ($_component->getLabelAfter() ? parent::render() . $label
                                                       : $label . parent::render()) .
               '</div>';
    }
}
