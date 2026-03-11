<?php

/**
 * Class TemplateFlashMessages
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Widgets\FlashMessages;

use Phoundation\Web\Html\Components\Script;
use Phoundation\Web\Html\Components\Widgets\FlashMessages\Interfaces\FlashMessagesInterface;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateFlashMessages extends TemplateRenderer
{
    /**
     * Breadcrumbs class constructor
     */
    public function __construct(FlashMessagesInterface $_component)
    {
        parent::__construct($_component);
    }


    /**
     * Renders and returns the HTML for this component
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $this->render = '';

        foreach ($this->_component as $_message) {
            $this->render .= $_message->render();
        }

        // Add script tags around all the flash calls
        $this->render = Script::new($this->render)
                              ->setAttach($this->_component->getAttachJavaScript())
                              ->render();

        return parent::render();
    }
}
