<?php

/**
 * Class TemplateInputWeek
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

use Phoundation\Web\Html\Components\Input\InputWeek;


class TemplateInputWeek extends TemplateInputText
{
    /**
     * InputWeek class constructor
     */
    public function __construct(InputWeek $_component)
    {
        $_component->addClasses('form-control');
        parent::__construct($_component);
    }
}
