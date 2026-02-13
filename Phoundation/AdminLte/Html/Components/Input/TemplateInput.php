<?php

/**
 * Class TemplateInput
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

use Phoundation\Web\Html\Components\Input\InputHidden;
use Phoundation\Web\Html\Components\Input\Interfaces\InputInterface;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateInput extends TemplateRenderer
{
    /**
     * Input class constructor
     */
    public function __construct(InputInterface $_component)
    {
        $_component->addClasses('form-control');
        parent::__construct($_component);
    }


    /**
     * Renders this input element
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $_component = $this->_component;

        // Hidden elements render as an <input hidden>
        if ($_component->getHidden()) {
            return InputHidden::new()
                              ->setName($_component->getName())
                              ->setValue($_component->getValue())
                              ->render();
        }

        $before = $_component->renderBeforeContent();
        $after  = $_component->renderAfterContent();

        if ($before or $after) {
            return '<div class="input-group mb-3">' . $before . parent::render() . $after . '</div>';
        }

        return parent::render();
    }
}
