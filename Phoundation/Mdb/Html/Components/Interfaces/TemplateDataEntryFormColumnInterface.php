<?php

/**
 * interface TemplateDataEntryFormColumnInterface
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Interfaces;

use Phoundation\Web\Html\Components\Interfaces\ComponentInterface;


interface TemplateDataEntryFormColumnInterface
{
    /**
     * Returns the component
     *
     * @return ComponentInterface|null
     */
    public function getComponentObject(): ComponentInterface|null;

    /**
     * Sets the component
     *
     * @param ComponentInterface|null $component
     * @return static
     */
    public function setComponentObject(ComponentInterface|null $component): static;

    /**
     * Renders and returns the HTML for this component
     *
     * @return string|null
     */
    public function render(): ?string;
}
