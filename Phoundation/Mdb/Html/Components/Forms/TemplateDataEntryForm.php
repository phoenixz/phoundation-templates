<?php

/**
 * Class DataEntryForm
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Forms;

use Phoundation\Web\Html\Components\Forms\DataEntryForm;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateDataEntryForm extends TemplateRenderer
{
    /**
     * FilterForm class constructor
     */
    public function __construct(DataEntryForm $o_component)
    {
        parent::__construct($o_component);
    }
}
