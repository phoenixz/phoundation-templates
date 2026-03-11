<?php

/**
 * Class TemplateContainer
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Layouts;

use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Layouts\Container;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateContainer extends TemplateRenderer
{
    /**
     * Container class constructor
     */
    public function __construct(Container $_component)
    {
        parent::__construct($_component);
    }


    /**
     * Render the HTML for this container
     *
     * @return string|null
     */
    public function render(): ?string
    {
        return '<div class="container' . ($this->_component->getTier()->value ? '-' . Html::safe($this->_component->getTier()->value) : null) . '">' . Html::safe($this->_component->getContent()) . '</div>';
    }
}
