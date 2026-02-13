<?php

/**
 * Class TemplateInputText
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

use Phoundation\Web\Html\Components\Input\InputText;
use Phoundation\Web\Html\Components\Script;


class TemplateInputText extends TemplateInput
{
    /**
     * InputText class constructor
     */
    public function __construct(InputText $_component)
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

        if ($_component->getClearButton()) {
            $_component->addClass('form-icon-trailing');
        }

        $return = parent::render();
        $icon   = $_component->getIcon();

        if ($icon) {
            // Add an icon
            $return = $icon->render() . ' ' . $return;
        }

        if ($_component->getClearButton()) {
            $name = $_component->getName();

            if ($_component->getValue()) {
                // Add a clear button
                $return .= '<span class="trailing pe-auto clear" tabindex="0">✕</span>';

                if ($name) {
                    $return .= Script::new('const clearButton = document.querySelector(".trailing.clear");
                                    const ' . $name . '= document.querySelector("#' . $name . '");
                                    const showElement = (element) => {
                                        if (element.classList.contains("d-none")) {
                                            element.classList.remove("d-none");
                                        }
                                    }
                                    
                                    const hideElement = (element) => {
                                        if (!element.classList.contains("d-none")) {
                                            element.classList.add("d-none");
                                      }
                                    }
                                    
                                    const clearInput = (button) => {
                                        const evt = document.createEvent("HTMLEvents");
                                        evt.initEvent("blur", false, true);
                                        const input = button.parentNode.querySelector(".form-icon-trailing");
                                        input.value = null;
                                        input.dispatchEvent(evt);
                                        hideElement(button);
                                    }
                                    
                                    clearButton.addEventListener("click", () => clearInput(clearButton));
                                    clearButton.addEventListener("keydown", (event) => {
                                      if (event.code === "Enter") {
                                        event.preventDefault();
                                        clearButton.click();
                                      }
                                    });
                                    
                                    ' . $name . '.addEventListener("input", () => {
                                      if (' . $name . '.value !== null) {
                                        showElement(clearButton);
                                      }
                                    });');
                }
            }
        }

        return $return;
    }
}
