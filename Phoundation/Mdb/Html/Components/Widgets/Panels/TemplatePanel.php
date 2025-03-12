<?php

/**
 * Class TemplatePanel
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Widgets\Panels;

use Phoundation\Web\Html\Components\Widgets\Panels\Panel;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplatePanel extends TemplateRenderer
{
    /**
     * Panel class constructor
     */
    public function __construct(Panel $o_component)
    {
        parent::__construct($o_component);
    }
}
