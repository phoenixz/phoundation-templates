<?php

/**
 * Class TemplateBottomPanel
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Widgets\Panels;

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
    public function __construct(BottomPanel $o_component)
    {
        parent::__construct($o_component);
    }


    /**
     * @inheritDoc
     */
    public function render(): ?string
    {
        if (config()->getBoolean('web.panels.bottom.enabled', true)) {
            $phoudation = Anchor::new('https://phoundation.org/', tr('Phoundation'));
            $template   = tr('Using template :name', [':name' => Anchor::new('https://mdbootstrap.com/', tr('MDB'))]);
            $project    = Anchor::new(Url::newCurrentDomainRootUrl(), Project::getHumanReadableFullName() . ' (v' . Project::getVersion() . ')');

            return '  <footer class="bg-body-tertiary text-center fixed-bottom">
                      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                          ' . tr(':project using :phoundation (:template)', [':project' => $project, ':phoundation' => $phoudation, ':template' => $template]) . ' ' . Core::PHOUNDATION_VERSION . '
                          <span class="float-end">' . Project::getCopyrightString() . '</span>
                      </div>
                  </footer>';
        }

        return null;
   }
}
