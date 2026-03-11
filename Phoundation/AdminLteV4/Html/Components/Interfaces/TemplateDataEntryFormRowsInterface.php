<?php

/**
 * Class TemplateDataEntryFormRows
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\AdminLteV4
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV4\Html\Components\Interfaces;

use Phoundation\Data\DataEntries\Definitions\Interfaces\DefinitionInterface;
use Phoundation\Web\Html\Components\Forms\DataEntryFormColumn;
use Phoundation\Web\Html\Components\Interfaces\RenderInterface;

interface TemplateDataEntryFormRowsInterface
{
    /**
     * Returns the maximum number of columns per row
     *
     * @return int
     */
    public function getColumnCount(): int;

    /**
     * Sets the maximum number of columns per row
     *
     * @param int $count
     * @return static
     */
    public function setColumnCount(int $count): static;

    /**
     * Adds the column component and its definition as a DataEntryFormColumn
     *
     * @param DefinitionInterface|null    $_definition
     * @param RenderInterface|string|null $component
     * @return static
     */
    public function add(?DefinitionInterface $_definition = null, RenderInterface|string|null $component = null): static;

    /**
     * Adds the specified DataEntryFormColumn to this DataEntryFormRow
     *
     * @param DataEntryFormColumn $column
     * @return static
     */
    public function addColumn(DataEntryFormColumn $column): static;

    /**
     * Renders and returns the HTML for this component
     *
     * @return string|null
     */
    public function render(): ?string;
}
