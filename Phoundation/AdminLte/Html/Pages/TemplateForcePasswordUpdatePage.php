<?php

/**
 * Class TemplateForcePasswordUpdatePage
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
use Phoundation\Web\Html\Csrf;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\Url;
use Phoundation\Web\Requests\Response;


class TemplateForcePasswordUpdatePage extends TemplateRenderer
{
    public function render(): ?string
    {
        // This page will build its own body
        Response::setRenderMainWrapper(false);

        $_component  = $this->getComponentObject();
        $this->render = '   <body class="hold-transition login-page" style="background: url(' .  Url::new('backgrounds/password.jpg')->makeImg() . '); background-position: center; background-repeat: no-repeat; background-size: cover;">
                                <div class="login-box">
                                    <!-- /.login-logo -->
                                    <div class="card card-outline card-info">
                                        <div class="card-header text-center">
                                          ' . Anchor::new(Project::getOwnerUrl())
                                                    ->setContent(Project::getOwnerLabel(), false)
                                                    ->setClass('h1'). '
                                    </div>
                                    <div class="card-body">
                                        <p class="login-box-msg">' .  $_component->getText(tr('Please update your account to have a new and secure password password before continuing...')) . '</p>
                                        <p class="login-box-msg">' .  tr('Please ensure that your password has at least 10 characters, is secure, and is known only to you.') . '</p>

                                        <form action="' .  Url::newCurrent() . '" method="post">
                                            ' . Csrf::getHiddenElement() . '
                                            <div class="input-group mb-3">
                                                <input type="password" name="password" id="password" class="form-control" placeholder="' .  tr('Password') . '">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-lock"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group mb-3">
                                                <input type="password" name="passwordv" id="passwordv" class="form-control" placeholder="' .  tr('Verify password') . '">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-lock"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary btn-block">' .  tr('Update and continue') . '</button>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    ' . Anchor::new(Url::new('/sign-out.html'), tr('Sign out'))->setClass('btn btn-outline-secondary btn-block') . '
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </body>';

        return $this->render;
    }
}
