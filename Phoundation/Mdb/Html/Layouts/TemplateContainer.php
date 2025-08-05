<?php

/**
 * Class TemplateContainer
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
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
    public function __construct(Container $o_component)
    {
        parent::__construct($o_component);
    }


    /**
     * Render the HTML for this container
     *
     * @return string|null
     */
    public function render(): ?string
    {
        return '<div class="container' . ($this->o_component->getTier()->value ? '-' . Html::safe($this->o_component->getTier()->value) : null) . '">' . Html::safe($this->o_component->getContent()) . '</div>';
    }
}
