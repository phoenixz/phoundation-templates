<?php

/**
 * Class TemplateSelect
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

use Phoundation\Utils\Arrays;
use Phoundation\Web\Html\Components\Input\InputHidden;
use Phoundation\Web\Html\Components\Input\InputSelect;


class TemplateInputSelect extends TemplateInput
{
    /**
     * Select class constructor
     */
    public function __construct(InputSelect $_component)
    {
        $_component->addClasses('form-control');
        parent::__construct($_component);
    }


    /**
     * @inheritDoc
     */
    public function render(): ?string
    {
        $_component = $this->_component;

        // Hidden elements render as an <input hidden>
        if ($_component->getHidden()) {
            // Select input have multiple values support
            $return = null;

            foreach (Arrays::force($_component->getSelected()) as $key => $value) {
                $return .= InputHidden::new()
                                      ->setName($_component->getName())
                                      ->setValue($key)
                                      ->render();
            }

            return $return;
        }

        if ($_component->getClearButton()) {
            $_component->getAttributesObject()->add("true", 'data-mdb-clear-button');
            $_component->getAttributesObject()->removeKeys('clear_button');

        }

        if ($_component->getSearch()) {
            $_component->getAttributesObject()->add("true", 'data-mdb-filter');
            $_component->getAttributesObject()->removeKeys('search');
        }

        if ($_component->getCustomContent()) {
            $_component->getAttributesObject()->removeKeys('custom_content');

            $render = '<div class="select-custom-content">
                         ' . render($_component->getCustomContent()) . '
                       </div>';
        }

        $after  = $_component->renderAfterContent();
        $before = $_component->renderBeforeContent();

        if ($before or $after) {
            return '<div class="input-group mb-3">' . $before . parent::render() . isset_get($render) . $after . '</div>';
        }

        return parent::render() . isset_get($render);
    }
}
