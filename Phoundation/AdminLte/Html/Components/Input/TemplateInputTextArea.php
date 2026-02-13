<?php

/**
 * Class TemplateInputTextArea
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

use Phoundation\Web\Html\Components\Input\InputTextArea;


class TemplateInputTextArea extends TemplateInputText
{
    /**
     * TextArea class constructor
     */
    public function __construct(InputTextArea $_component)
    {
        $_component->addClasses('form-control');
        parent::__construct($_component);
    }
}
