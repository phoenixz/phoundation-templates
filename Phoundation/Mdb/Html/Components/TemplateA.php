<?php

/**
 * Class TemplateA
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components;

use Phoundation\Web\Html\Components\Anchor;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateA extends TemplateRenderer
{
    /**
     * Icons class constructor
     */
    public function __construct(Anchor $_component)
    {
        parent::__construct($_component);
    }


    /**
     * Render the a HTML
     *
     * @note This render skips the parent Element class rendering for speed and simplicity
     * @return string|null
     */
    public function render(): ?string
    {
        $this->_component->addClasses('nav-link');
        return parent::render();
    }
}
