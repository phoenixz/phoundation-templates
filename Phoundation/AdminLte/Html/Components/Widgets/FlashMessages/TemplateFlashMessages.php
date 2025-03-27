<?php

/**
 * Class TemplateFlashMessages
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Components\Widgets\FlashMessages;

use Phoundation\Web\Html\Components\Script;
use Phoundation\Web\Html\Components\Widgets\FlashMessages\Interfaces\FlashMessagesInterface;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateFlashMessages extends TemplateRenderer
{
    /**
     * BreadCrumbs class constructor
     */
    public function __construct(FlashMessagesInterface $o_component)
    {
        parent::__construct($o_component);
    }


    /**
     * Renders and returns the HTML for this component
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $this->render = '';

        foreach ($this->o_component as $o_message) {
            $this->render .= $o_message->render();
        }

        // Add script tags around all the flash calls
        $this->render = Script::new($this->render)
                              ->setAttach($this->o_component->getAttachJavaScript())
                              ->render();

        return parent::render();
    }
}
