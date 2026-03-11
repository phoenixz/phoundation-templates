<?php

/**
 * Class TemplateSignInPage
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\AdminLteV3
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV3\Html\Pages;

use Phoundation\Developer\Project\Project;
use Phoundation\Web\Html\Components\Anchor;
use Phoundation\Web\Html\Csrf;
use Phoundation\Web\Html\Enums\EnumAnchorRenderRightsFail;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\Url;
use Phoundation\Web\Requests\Response;


class TemplateSignInPage extends TemplateRenderer
{
    public function render(): ?string
    {
        // This page will build its own body
        Response::setRenderMainWrapper(false);
        Response::setPageTitle(tr('Please sign in'));
        Response::setHeaderTitle(tr('Please sign in'));

        $_component = $this->getComponentObject();
        $get         = $_component->getGetData();

        $this->render = '   <body class="hold-transition login-page" style="background: url(' . $_component->getUrl('image-background') . '); background-position: center; background-repeat: no-repeat; background-size: cover; !important;">
                                <div class="login-box">
                                  <!-- /.login-logo -->
                                  <div class="card card-outline card-info">
                                    <div class="card-header text-center">
                                        ' . $_component->getSection('card-header') . '                                      
                                    </div>
                                    <div class="card-body">
                                      <p class="login-box-msg">' . $_component->getText(tr('Please sign in to start your session')) . '</p>
                                      <form action="' . Url::newCurrent() . '" method="post">
                                            ' . Csrf::getHiddenElement();

                                            if ($_component->getEnabled('email')) {
                                                $this->render .= '  <div class="input-group mb-3">
                                                                        <input type="email" name="email" id="email" class="form-control" placeholder="' . tr('Email address') . '"' . (isset($get['email']) ? 'value="' . $get['email'] . '"' : '') . '>
                                                                        <div class="input-group-append">
                                                                            <div class="input-group-text">
                                                                                <span class="fas fa-envelope"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="input-group mb-3">
                                                                        <input type="password" name="password" id="password" class="form-control" placeholder="' . tr('Password') . '">
                                                                        <div class="input-group-append">
                                                                            <div class="input-group-text">
                                                                                <span class="fas fa-lock"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <div class="icheck-primary">
                                                                                <input type="checkbox" id="remember">
                                                                                <label for="remember">
                                                                                    ' . tr('Remember Me') . '
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <!-- /.col -->
                                                                        <div class="col-4">
                                                                            <button type="submit" class="btn btn-primary btn-block">' . tr('Sign In') . '</button>
                                                                        </div>
                                                                        <!-- /.col -->
                                                                    </div>';
                                            }

        $this->render .= '            </form>';


        if ($_component->getEnabled('facebook')) {
            $html =                   Anchor::new('#')
                                            ->setClass('btn btn-block btn-primary')
                                            ->setContent('<i class="fab fa-facebook mr-2"></i>' . tr('Sign in using Facebook'));
        }

        if ($_component->getEnabled('google')) {
            $html =                   Anchor::new('#')
                                            ->setClass('btn btn-block btn-primary')
                                            ->setContent('<i class="fab fa-google-plus mr-2"></i>' . tr('Sign in using Google'));
        }

        if (isset($html)) {
            $this->render .= '       <div class="social-auth-links text-center mt-2 mb-3">
                                         ' . $html . '
                                     </div>';
        }

        if ($_component->getEnabled('lost-password')) {
            $this->render .= '        <p class="mb-1">
                                          ' . $_component->getSection('lost-password') . '                                          
                                      </p>';
        }

        if ($_component->getEnabled('register')) {
            $this->render .= '        <p class="mb-0">
                                          ' . Anchor::new(Url::new('/sign-up.html')->makeWww()->addRedirect(array_get_safe($get, 'redirect'))->addQuery(array_get_safe($get, 'email'), 'email'))
                                                    ->setContent(tr('text-center'))
                                                    ->setContent(tr('Register a new membership'))
                                                    ->setRenderRightsFail(EnumAnchorRenderRightsFail::full) . '
                                      </p>';
        }

        if ($_component->getEnabled('copyright')) {
            $this->render .= '          <div class="login-footer text-center">
                                            ' . Project::getCopyrightString(true) . '
                                        </div>
                                    </div>';
        }

        $this->render .= '          <!-- /.card-body -->
                                  </div>
                                  <!-- /.card -->
                                </div>
                            </body>';

        return $this->render;
    }
}
