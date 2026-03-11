<?php

/**
 * Class TemplateInputDate
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\AdminLteV3
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV3\Html\Components\Input;

use Phoundation\Date\Enums\EnumDateFormat;
use Phoundation\Web\Html\Components\Input\InputDate;


class TemplateInputDate extends TemplateInput
{
    /**
     * InputDate class constructor
     */
    public function __construct(InputDate $_component)
    {
        $_component->addClasses('form-control');
        parent::__construct($_component);
    }


    /**
     * Returns the default date format required for this TemplateInputDate class
     *
     * @return EnumDateFormat|string
     */
    public static function getDateFormat(): EnumDateFormat|string
    {
        return 'Y-m-d';
    }
}
