<?php

/**
 * Class TemplateSelect
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

use Phoundation\Utils\Arrays;
use Phoundation\Web\Html\Components\Input\InputHidden;
use Phoundation\Web\Html\Components\Input\InputSelect;


class TemplateInputSelect extends TemplateInput
{
    /**
     * Select class constructor
     */
    public function __construct(InputSelect $o_component)
    {
        $o_component->addClasses('col-sm-' . $o_component->getDefinitionObject()->getSize());
        $o_component->addClasses('form-control');
        $o_component->getAttributes()->add('', 'data-mdb-select-init');
        parent::__construct($o_component);
    }


    /**
     * @inheritDoc
     */
    public function render(): ?string
    {
        $o_component = $this->o_component;

        // Hidden elements render as an <input hidden>
        if ($o_component->getHidden()) {
            // Select input have multiple values support
            $return = null;

            foreach (Arrays::force($o_component->getSelected()) as $key => $value) {
                $return .= InputHidden::new()
                                      ->setName($o_component->getName())
                                      ->setValue($key)
                                      ->render();
            }

            return $return;
        }

        if ($o_component->getClearButton()) {
            $o_component->getAttributes()->add("true", 'data-mdb-clear-button');
            $o_component->getAttributes()->removeKeys('clear_button');
        }

        if ($o_component->getSearch()) {
            $o_component->getAttributes()->add("true", 'data-mdb-filter');
            $o_component->getAttributes()->removeKeys('search');
        }

        if ($o_component->getCustomContent()) {
            $o_component->getAttributes()->removeKeys('custom_content');

            $render = '<div class="select-custom-content">
                         ' . render($o_component->getCustomContent()) . '
                       </div>';
        }

        return $o_component->renderBeforeContent() . parent::render() . isset_get($render) . $o_component->renderAfterContent();
    }
}
