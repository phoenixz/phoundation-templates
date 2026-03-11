<?php

/**
 * Class TemplateWidget
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLteV3
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV3\Html\Components\Widgets;

use Phoundation\Web\Html\Components\Widgets\Widget;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateWidget extends TemplateRenderer
{
    /**
     * Widget class constructor
     */
    public function __construct(Widget $_component)
    {
        parent::__construct($_component);
    }
}
