<?php

/**
 * Class TemplateInputNumeric
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2022 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Components\Input;

use Phoundation\Web\Html\Components\Input\InputNumeric;


class TemplateInputNumeric extends TemplateInputText
{
    /**
     * InputNumeric class constructor
     */
    public function __construct(InputNumeric $component)
    {
        $component->addClasses('form-control');
        parent::__construct($component);
    }
}
