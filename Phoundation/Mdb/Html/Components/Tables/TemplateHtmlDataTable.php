<?php

/**
 * Class TemplateMdb TemplateHtmlDataTable
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Tables;

use Phoundation\Web\Html\Components\Tables\HtmlTable;
use Phoundation\Web\Html\Layouts\GridRow;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateHtmlDataTable extends TemplateRenderer
{
    /**
     * Table class constructor
     */
    public function __construct(HtmlTable $o_component)
    {
        $o_component->addClasses('table');
        parent::__construct($o_component);
    }


    /**
     * Renders and returns the HTML for this object
     *
     * @return string|null
     */
    public function render(): ?string
    {
        return GridRow::new()->addGridColumn(parent::render())->render();
    }
}
