<?php

/**
 * Class TemplateInputTel
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLteV3
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV3\Html\Components\Input;

use Phoundation\Web\Html\Components\Input\InputTel;


class TemplateInputTel extends TemplateInputText
{
    /**
     * InputTel class constructor
     */
    public function __construct(InputTel $_component)
    {
        $_component->addClasses('form-control');
        parent::__construct($_component);
    }
}
