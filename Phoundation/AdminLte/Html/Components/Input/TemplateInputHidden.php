<?php

/**
 * Class TemplateInputHidden
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Components\Input;

use Phoundation\Web\Html\Components\Input\InputHidden;


class TemplateInputHidden extends TemplateInput
{
    /**
     * InputHidden class constructor
     */
    public function __construct(InputHidden $_component)
    {
        $_component->addClasses('form-control');
        parent::__construct($_component);
    }
}
