<?php

/**
 * Class TemplateInput
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

use Phoundation\Web\Html\Components\Input\InputHidden;
use Phoundation\Web\Html\Components\Input\Interfaces\InputInterface;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateInput extends TemplateRenderer
{

    /**
     * Input class constructor
     */
    public function __construct(InputInterface $o_component)
    {
        $o_component->addClasses('form-control');
        parent::__construct($o_component);
    }


    /**
     * Renders this input element
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $o_component = $this->o_component;

        // Hidden elements render as an <input hidden>
        if ($o_component->getHidden()) {
            return InputHidden::new()
                              ->setName($o_component->getName())
                              ->setValue($o_component->getValue())
                              ->render();
        }

        return $o_component->renderBeforeContent() . parent::render() . $o_component->renderAfterContent();
    }
}
