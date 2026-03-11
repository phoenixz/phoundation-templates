<?php

/**
 * Class TemplateBottomPanel
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\AdminLteV3
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV3\Html\Components\Widgets\Panels;

use Phoundation\Core\Core;
use Phoundation\Developer\Project\Project;
use Phoundation\Web\Html\Components\Anchor;
use Phoundation\Web\Html\Components\Widgets\Panels\BottomPanel;
use Phoundation\Web\Html\Enums\EnumAnchorTarget;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\Url;


class TemplateBottomPanel extends TemplateRenderer
{
    /**
     * BottomPanel class constructor
     */
    public function __construct(BottomPanel $_component)
    {
        parent::__construct($_component);
    }


    /**
     * @inheritDoc
     */
    public function render(): ?string
    {
        $phoudation = Anchor::new('https://phoundation.org/', tr('Phoundation'));
        $adminlte   = tr('Using template :name', [':name' => Anchor::new('https://adminlte.io/', tr('AdminLteV3'))]);
        $project    = Anchor::new(Url::newCurrentDomainRootUrl(), Project::getHumanReadableFullName() . ' (v' . Project::getVersion() . ')');

        return '  <footer class="main-footer">
                    <div class="float-right d-none d-sm-block">
                      <b>' . tr(':project using :phoundation (:adminlte)', [':project' => $project, ':phoundation' => $phoudation, ':adminlte' => $adminlte]) . '</b> ' . Core::PHOUNDATION_VERSION . '
                    </div>
                    ' . Project::getCopyrightString() . '
                  </footer>';
    }
}
