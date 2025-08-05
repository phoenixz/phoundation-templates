<?php

/**
 * Class TemplateFilterForm
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Components\Forms;

use Phoundation\Web\Html\Components\Forms\FilterForm;
use Templates\Phoundation\AdminLte\Html\Components\Forms\TemplateDataEntryForm;


class TemplateFilterForm extends TemplateDataEntryForm
{
    /**
     * FilterForm class constructor
     */
    public function __construct(FilterForm $element)
    {
        parent::__construct($element);
    }
}
