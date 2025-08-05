<?php

/**
 * Class TemplateInputSwitch
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Input;

use Phoundation\Web\Html\Components\Input\InputSwitch;


class TemplateInputSwitch extends TemplateInputCheckbox
{
    /**
     * InputCheckbox class constructor
     */
    public function __construct(InputSwitch $o_component)
    {
        $this->type_class = ' form-switch';
        parent::__construct($o_component);
    }
}
