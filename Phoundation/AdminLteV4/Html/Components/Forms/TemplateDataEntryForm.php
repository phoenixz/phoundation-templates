<?php

/**
 * Class TemplateDataEntryForm
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\AdminLteV4
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV4\Html\Components\Forms;

use Phoundation\Web\Html\Components\Forms\DataEntryForm;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateDataEntryForm extends TemplateRenderer
{
    /**
     * FilterForm class constructor
     */
    public function __construct(DataEntryForm $_component)
    {
        parent::__construct($_component);
    }
}
