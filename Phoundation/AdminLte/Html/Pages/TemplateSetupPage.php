<?php

/**
 * Class TemplateLostPasswordPage
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\AdminLte
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Pages;

use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Requests\Response;


class TemplateSetupPage extends TemplateRenderer
{
    public function render(): ?string
    {
throw new \Phoundation\Exception\UnderConstructionException();
        // This page will build its own body
        Response::setRenderMainWrapper(false);

        $this->render = '   ';

        return parent::render();
    }
}
