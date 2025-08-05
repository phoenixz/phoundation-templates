<?php

/**
 * Class TemplateIcons
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Components\Icons;

use Phoundation\Web\Html\Components\Icons\Icons;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateIcons extends TemplateRenderer
{
    /**
     * Icons class constructor
     */
    public function __construct(Icons $o_component)
    {
        parent::__construct($o_component);
    }


    /**
     * Render the icon HTML
     *
     * @note This render skips the parent Element class rendering for speed and simplicity
     * @return string|null
     */
    public function render(): ?string
    {
        if (preg_match('/[a-z0-9-_]*]/i', $this->o_component->getContent())) {
            // icon names should only have letters, numbers and dashes and underscores
            return $this->o_component->getContent();
        }

        return '<i class="fas fa-' . $this->o_component->getContent() . ($this->o_component->getTier()->value ? ' fa-' . Html::safe($this->o_component->getTier()->value) : '') . '"></i>';
    }
}
