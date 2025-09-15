<?php

/**
 * Class TemplateLostPasswordUpdatedPage
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

use Phoundation\Developer\Project\Project;
use Phoundation\Web\Html\Components\Anchor;
use Phoundation\Web\Html\Components\Img;
use Phoundation\Web\Html\Csrf;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\Url;
use Phoundation\Web\Requests\Response;


class TemplateLostPasswordUpdatedPage extends TemplateRenderer
{
    public function render(): ?string
    {
        // This page will build its own body
        Response::setRenderMainWrapper(false);

        $this->render = '   <body class="hold-transition login-page" style="background: url(' . Url::new('backgrounds/password.jpg')->makeImg() . '); background-position: center; background-repeat: no-repeat; background-size: cover;">
                                <div class="login-box">
                                    <div class="card card-outline card-info">
                                        <div class="card-header text-center">
                                            ' . Anchor::new(Project::getOwnerUrl())
                                                      ->setClass('h1')
                                                      ->setContent(Img::new('logos/large.jpg')
                                                                      ->setAlt(tr(':owner logo', [':owner' => Project::getOwnerName()])), false) . '
                                        </div>
                                        <div class="card-body">
                                            <p class="login-box-msg">' . tr('All done! You can now continue to your dashboard or continue to the sign-in page...') . '</p>

                                            <form action="' . Url::newCurrent() . '" method="post">
                                                ' . Csrf::getHiddenElement() . '
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        ' . Anchor::new(Url::new('index'))
                                                                  ->setClass('btn btn-primary btn-block')
                                                                  ->setContent(tr('Go to dashboard')) . '
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        ' . Anchor::new(Url::new('sign-out')->makeWww()->removeQueryKeys('redirect'))
                                                                  ->setClass('btn btn-outline-secondary btn-block')
                                                                  ->setContent(tr('Go to sign-in page')) . '
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </body>';

        return $this->render;
    }
}
