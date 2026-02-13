<?php

/**
 * Class TemplateToast
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Components\Widgets\FlashMessages;

use Phoundation\Web\Html\Components\Widgets\FlashMessages\Interfaces\ToastInterface;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateToast extends TemplateRenderer
{
    /**
     * Breadcrumbs class constructor
     */
    public function __construct(ToastInterface $_component)
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
        $this->render = '$(document).Toasts("create", ' . $this->_component->renderJson() . ');';

        return parent::render();
    }
}
