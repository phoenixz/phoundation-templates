<?php

/**
 * Class TemplateInputDateRange
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Components\Input;

use Phoundation\Exception\OutOfBoundsException;
use Phoundation\Web\Html\Components\Input\InputDateRange;


class TemplateInputDateRange extends TemplateInputText
{
    /**
     * InputText class constructor
     */
    public function __construct(InputDateRange $_component)
    {
        $_component->addClasses('form-control');
        parent::__construct($_component);
    }


    /**
     * Render and return the HTML for this object
     *
     * @return string|null
     */
    public function render(): ?string
    {
        if (!$this->_component->getName()) {
            throw new OutOfBoundsException(tr('Cannot render InputDateRange object, no HTML name attribute specified'));
        }

        // Ensure these two classes are always available
        $this->_component->addClasses(['form-control', 'float-right']);

        // TODO Move InputDateRange javascript code here
        return '    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        ' . parent::render() . '
                    </div>';
    }
}
