<?php

/**
 * Class TemplateSignInPage
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Phoundation\Web
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Pages;

use Phoundation\Core\Core;
use Phoundation\Utils\Config;
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

        $this->render = '   <body class="hold-transition login-page" style="background: url(' . Url::new('img/backgrounds/' . Core::getProjectSeoName() . '/password.jpg')->makeImg() . '); background-position: center; background-repeat: no-repeat; background-size: cover;">
                                <div class="login-box">
                                    <div class="card card-outline card-info">
                                        <div class="card-header text-center">
                                            <a href="' . config()->getString('project.customer-url', 'https://phoundation.org') . '" class="h1">' . config()->getString('project.owner.label', '<span>Phoun</span>dation') . '</a>
                                        </div>
                                        <div class="card-body">
                                            <p class="login-box-msg">' . tr('All done! You can now continue to your dashboard or continue to the sign-in page...') . '</p>

                                            <form action="' . Url::newCurrent() . '" method="post">
                                                ' . Csrf::getHiddenElement() . '
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <a href="' . Url::new('index')->makeWww() . '" class="btn btn-primary btn-block">' . tr('Go to dashboard') . '</a>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <a href="' . Url::new('sign-out')->makeWww()->removeQueryKeys('redirect') . '" class="btn btn-outline-secondary btn-block">' . tr('Go to sign-in page') . '</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </body>';

        return parent::render();
    }
}
