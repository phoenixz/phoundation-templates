<?php

/**
 * Class TemplateInputMultiButtonText
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

use Phoundation\Web\Html\Components\Anchor;
use Phoundation\Web\Html\Components\Input\InputMultiButtonText;
use Phoundation\Web\Html\Html;


class TemplateInputMultiButtonText extends TemplateInput
{
    /**
     * InputMultiButtonText class constructor
     */
    public function __construct(InputMultiButtonText $o_component)
    {
        parent::__construct($o_component);
    }


    /**
     * Renders and returns the HTML for this object
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $options = '';

        // Build the options list
        foreach ($this->o_component->getSource() as $url => $label) {
            if (str_starts_with($label, '#')) {
                // Any label starting with # is a divider
                $options .= '<li class="dropdown-divider"></li>';
            } else {
                $options .= '<li class="dropdown-item">' . Anchor::new(Html::safe($url), Html::safe($label))  . '</li>';
            }
        }

        // Render the entire object
        $this->render = '   <div class="input-group input-group-lg mb-3">
                                <div class="input-group-prepend">
                                ' . $this->o_component->getButton()->render() . '                                
                                <ul class="dropdown-menu" style="">
                                    ' . $options . '
                                </ul>
                                </div>
                                
                                ' . $this->o_component->getInput()->render() . '
                            </div>';

        return parent::render();
    }
}
