<?php

/**
 * Class TemplateMdb TemplateHtmlTable
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
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateHtmlTable extends TemplateRenderer
{
    /**
     * Table class constructor
     */
    public function __construct(HtmlTable $o_component)
    {
        $o_component->addClasses('table');
        parent::__construct($o_component);
    }
}
