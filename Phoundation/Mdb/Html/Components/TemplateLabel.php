<?php

/**
 * Class TemplateLabel
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components;

use Phoundation\Web\Html\Components\Label;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateLabel extends TemplateRenderer
{
    /**
     * Icons class constructor
     */
    public function __construct(Label $_component)
    {
        parent::__construct($_component);
    }


    /**
     * Render the label HTML
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $this->_component->addClasses('form-label');
        return parent::render();
    }
}
