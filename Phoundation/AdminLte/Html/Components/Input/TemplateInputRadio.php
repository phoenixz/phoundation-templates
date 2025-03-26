<?php

/**
 * Class TemplateInputRadio
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Components\Input;

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
    public function __construct(InputRadio $o_component)
    {
        parent::__construct($o_component);
        $o_component->addClasses('form-control');
    }
}
