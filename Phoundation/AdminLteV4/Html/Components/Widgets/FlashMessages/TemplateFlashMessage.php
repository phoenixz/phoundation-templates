<?php

/**
 * Class TemplateFlashMessage
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\AdminLteV4
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV4\Html\Components\Widgets\FlashMessages;

use Phoundation\Web\Html\Components\Widgets\FlashMessages\Interfaces\FlashMessageInterface;
use Phoundation\Web\Html\Components\Widgets\FlashMessages\Toast;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateFlashMessage extends TemplateRenderer
{
    /**
     * Breadcrumbs class constructor
     */
    public function __construct(FlashMessageInterface $_component)
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
        $this->render = match ($this->_component->getFlashHandler()) {
            'toast' => Toast::new($this->_component)->render(),
        };

        return parent::render();
    }
}
