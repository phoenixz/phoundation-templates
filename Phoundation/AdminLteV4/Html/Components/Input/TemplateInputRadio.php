<?php

/**
 * Class TemplateInputRadio
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

use Phoundation\Web\Html\Components\Input\InputRadio;


class TemplateInputRadio extends TemplateInputCheckbox
{
    /**
     * Tracks the class of the container div
     *
     * @var string $class
     */
    protected string $class = 'custom-radio';


    /**
     * InputRadio class constructor
     */
    public function __construct(InputRadio $_component)
    {
        parent::__construct($_component);
        $_component->addClasses('form-control');
    }
}
