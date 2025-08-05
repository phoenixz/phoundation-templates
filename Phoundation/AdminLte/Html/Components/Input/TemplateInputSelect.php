<?php

/**
 * Class TemplateSelect
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
        $o_component->addClasses('form-control');
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
            $o_component->getAttributesObject()->add("true", 'data-mdb-clear-button');
            $o_component->getAttributesObject()->removeKeys('clear_button');

        }

        if ($o_component->getSearch()) {
            $o_component->getAttributesObject()->add("true", 'data-mdb-filter');
            $o_component->getAttributesObject()->removeKeys('search');
        }

        if ($o_component->getCustomContent()) {
            $o_component->getAttributesObject()->removeKeys('custom_content');

            $render = '<div class="select-custom-content">
                         ' . render($o_component->getCustomContent()) . '
                       </div>';
        }

        $after  = $o_component->renderAfterContent();
        $before = $o_component->renderBeforeContent();

        if ($before or $after) {
            return '<div class="input-group mb-3">' . $before . parent::render() . isset_get($render) . $after . '</div>';
        }

        return parent::render() . isset_get($render);
    }
}
