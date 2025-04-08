<?php

/**
 * Class TemplateBottomPanel
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Components\Widgets\Panels;

use Phoundation\Core\Core;
use Phoundation\Web\Html\Components\Widgets\Panels\BottomPanel;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\Url;


class TemplateBottomPanel extends TemplateRenderer
{
    /**
     * BottomPanel class constructor
     */
    public function __construct(BottomPanel $o_component)
    {
        parent::__construct($o_component);
    }


    /**
     * @inheritDoc
     */
    public function render(): ?string
    {
        $phoudation = '<a href="https://phoundation.org/">Phoundation</a>';
        $adminlte   = tr('template :name', [':name' => '<a href="https://adminlte.io/">' . tr('AdminLte') . '</a>']);
        $project    = '<a href="' . Url::newCurrentDomainRootUrl() . '">' . config()->getString('project.name', 'Phoundation') . '</a>';

        return '  <footer class="main-footer">
                    <div class="float-right d-none d-sm-block">
                      <b>' . tr(':project using :phoundation (:adminlte)', [':project' => $project, ':phoundation' => $phoudation, ':adminlte' => $adminlte]) . '</b> ' . Core::PHOUNDATION_VERSION . '
                    </div>
                    <strong>Copyright © ' . config()->getString('project.copyright', '2025') . ' <a href="' . config()->getString('project.owner.url', 'https://phoundation.org') . '" target="_blank">' . config()->getString('project.owner.name', 'Phoundation') . '</a>.</strong> All rights reserved. <br>
                  </footer>';
    }
}
