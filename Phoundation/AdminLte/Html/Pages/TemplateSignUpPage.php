<?php

/**
 * Class TemplateSignUpPage
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

use Phoundation\Accounts\Users\Sessions\Session;
use Phoundation\Developer\Project\Project;
use Phoundation\Web\Html\Components\Anchor;
use Phoundation\Web\Html\Components\AnchorBlock;
use Phoundation\Web\Html\Csrf;
use Phoundation\Web\Html\Enums\EnumAnchorTarget;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\Url;
use Phoundation\Web\Requests\Response;


class TemplateSignUpPage extends TemplateRenderer
{
    public function render(): ?string
    {
        // This page will build its own body
        Response::setRenderMainWrapper(false);

        $terms       = tr('terms');
        $o_component = $this->getComponentObject();
        $get         = $o_component->getGetData();

        $this->render = '   <body class="hold-transition register-page">
                                <div class="register-box">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header text-center">
                                            ' . Anchor::new(Project::getOwnerUrl(), Project::getOwnerLabel())->addClass('h1') . '
                                        </div>
                                        <div class="card-body">
                                            <p class="login-box-msg">' . tr('Register a new membership') . '</p>
                                            <form action="' . Url::newCurrent() . '" method="post">
                                                ' . Csrf::getHiddenElement() . '
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" placeholder="Full name">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-user"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <input type="email" class="form-control" placeholder="' . tr('Email') . '">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-envelope"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <input type="password" class="form-control" placeholder="' . tr('Password') . '">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-lock"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <input type="password" class="form-control" placeholder="' . tr('Retype password') . '">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-lock"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-8">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                                            <label for="agreeTerms">
                                                                ' . tr('I agree to the :terms', [':terms' => Anchor::new(Url::new('terms')->makeWww(), $terms)]) . '
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!-- /.col -->
                                                    <div class="col-4">
                                                        <button type="submit" class="btn btn-primary btn-block">' . tr('Register') . '</button>
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                            </form>';

        $html = '';

        if ($o_component->getEnabled('facebook')) {
            $html .=                            Anchor::new('#')
                                                      ->setClass('btn btn-block btn-primary')
                                                      ->setContent('<i class="fab fa-facebook mr-2"></i>' . tr('Sign up using Facebook'));
        }

        if ($o_component->getEnabled('google')) {
            $html .=                            Anchor::new('#')
                                                      ->setClass('btn btn-block btn-danger')
                                                      ->setContent('<i class="fab fa-google-plus mr-2"></i>' . tr('Sign up using Google+'));
        }

        if ($html) {
            $this->render .= '              <div class="social-auth-links text-center">
                                            ' . $html . '
                                            </div>';
        }

        $this->render .= '                  ' . Anchor::new(Url::new('sign-in'))
                                                      ->setClass('text-center')
                                                      ->setContent(tr('I already have an account')) . '
                                        </div>';

        if ($o_component->getEnabled('copyright')) {
            $this->render .= '          <div class="login-footer text-center">
                                            ' . Project::getCopyrightString(true) . '
                                        </div>';
        }

        $this->render .= '          </div>
                                </div>
                            </body>';

        return parent::render();
    }
}
