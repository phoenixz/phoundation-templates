<?php

/**
 * Class TemplateButton
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Input\Buttons;

use Phoundation\Web\Html\Components\Input\Buttons\Interfaces\ButtonInterface;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateButton extends TemplateRenderer
{
    /**
     * Button class constructor
     */
    public function __construct(ButtonInterface $_component)
    {
        parent::__construct($_component);

        $_component->setReadonly($_component->getReadonly() or $_component->getDisabled())
                    ->addData('', 'mdb-ripple-init');

        if ($_component->getReadonly()) {
            $_component->setUrlObject(null)
                        ->addAria('true', 'disabled')
                        ->addClass('disabled');
        }
    }
}
