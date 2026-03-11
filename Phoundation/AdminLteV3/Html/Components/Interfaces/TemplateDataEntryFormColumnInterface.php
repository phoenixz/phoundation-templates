<?php

declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV3\Html\Components\Interfaces;

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
