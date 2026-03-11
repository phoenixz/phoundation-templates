<?php

/**
 * Class TemplateInputText
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\AdminLteV4
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV4\Html\Components\Input;

use Phoundation\Web\Html\Components\Input\InputText;


class TemplateInputText extends TemplateInput
{
    /**
     * InputText class constructor
     */
    public function __construct(InputText $_component)
    {
        $_component->addClasses('form-control');
        parent::__construct($_component);
    }
}
