<?php

/**
 * Class TemplateSignInPage
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Pages;

use Phoundation\Developer\Project\Project;
use Phoundation\Web\Html\Components\Anchor;
use Phoundation\Web\Html\Csrf;
use Phoundation\Web\Html\Enums\EnumAnchorRenderRightsFail;
use Phoundation\Web\Html\Enums\EnumHttpRequestMethod;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\Url;
use Phoundation\Web\Requests\Response;


class TemplateSignInPage extends TemplateRenderer
{
    /**
     * Renders and returns the lost password page
     *
     * @return string|null
     */
    public function render(): ?string {
        // Render sign-in form
        // This page will build its own body
        Response::setPageTitle(tr('Please sign in'));
        Response::setRenderMainWrapper(false);

        $_component  = $this->getComponentObject();
        $terms        = Anchor::new(Url::new('terms')->makeWww(), tr('terms and conditions'))->setRenderRightsFail(EnumAnchorRenderRightsFail::full);
        $register     = Anchor::new(Url::new('sign-up')->makeWww(), tr('Register'))->setRenderRightsFail(EnumAnchorRenderRightsFail::full);

        // Render SSO entries?
        if ($_component->getEnabled('facebook')) {
            $facebook = ' <button type="button" class="btn btn-link btn-lg btn-floating mx-1" data-mdb-ripple-init data-ripple-color="primary">
                              <i class="fab fa-facebook-f"></i>
                          </button>';
        }

        if ($_component->getEnabled('google')) {
            $google = ' <button type="button" class="btn btn-link btn-lg btn-floating mx-1" data-mdb-ripple-init data-ripple-color="primary">
                            <i class="fab fa-google"></i>
                        </button>';
        }

        if ($_component->getEnabled('github')) {
            $github = ' <button type="button" class="btn btn-link btn-lg btn-floating mx-1" data-mdb-ripple-init data-ripple-color="primary">
                            <i class="fab fa-github"></i>
                        </button>';
        }

        // Render the sign-in page section
        $signin   = ' <form method="post" action="' . Url::new($_component->getUrl('form-action', default: config()->getString('platforms.web.pages.sign-in.urls.form', 'sign-in')))->makeWww() . '">
                          ' . Csrf::getHiddenElement() . '
                          <div class="sign-in text-center h1"> 
                              <img src="' . Url::new($_component->getImage('image-logo', default: config()->getString('platforms.web.pages.sign-in.images.logo', 'logos/large.webp')))->makeImg() . '" alt="' . $_component->getText(tr('PCJ Admin')) . '" width="310">
                          </div>
                          <hr>';

        if ($_component->getEnabled('email', default: config()->getBoolean('platforms.web.pages.sign-in.enabled.email', true))) {
            $signin .= '  <div class="form-outline mb-4" data-mdb-input-init>
                              <input type="email" id="loginName" name="email" class="form-control"' . $_component->getValue(EnumHttpRequestMethod::get, 'email') . ' />
                              <label class="form-label" for="loginName">' . $_component->getText(tr('Email')) . '</label>
                          </div>
                          <div class="form-outline mb-4" data-mdb-input-init>
                              <input type="password" id="loginPassword" name="password" class="form-control" />
                              <label class="form-label" for="loginPassword">' . $_component->getText(tr('Password')) . '</label>
                          </div>
                          <button type="submit" class="btn btn-primary btn-block mb-4" data-mdb-ripple-init>
                              ' . $_component->getText(tr('Sign in')) . '
                          </button>';

        }

        $signin .=        $_component->getSection('sso') . '
                          <div class="row mb-4">
                              <div class="col-md-12 d-flex justify-content-center">
                                  ' . Anchor::new(Url::new($_component->getUrl('lost-password', default: 'lost-password'))->makeWww()->addQuery($_component->get(EnumHttpRequestMethod::get, 'email'), 'email'))
                                            ->setContent($_component->getText('Forgot password?'))
                                            ->setRenderRightsFail(EnumAnchorRenderRightsFail::full). '
                              </div>
                          </div>';

        if ($_component->getEnabled('sign-up', default: config()->getBoolean('platforms.web.pages.sign-in.enabled.sign-up', true))) {
            $signin .= '   <div class="text-center">
                              <p>' . $_component->getText(tr('Not a member? :register', [':register' => $register])) . '</p>
                          </div>';
        }

        if ($_component->getEnabled('copyright', default: config()->getBoolean('platforms.web.pages.sign-in.enabled.copyright', true))) {
            $signin .= '  <div class="text-center">
                              ' . Project::getCopyrightString(true) . '
                          </div>';
        }

        $signin .= '  </form>';

        // Render the entire page
        $render = '   <header>
                          <section class="text-center text-md-start">
                              <div class="p-5" style="height: 200px; background: url(' . Url::new($_component->getUrl('banner', default: 'banners/large.jpg'))->makeImg() . ') center no-repeat;">
                              </div>
                          </section>
                      </header>
                      <main class="mb-5" style="margin-top: -100px;">
                          <div class="container px-4">
                              <div class="row d-flex justify-content-center">
                                  <div class="col-xl-5 col-md-8">
                                      <div class="card shadow-4">
                                          <div class="card-body p-4">';

        if ($_component->getEnabled('signup')) {
            $render .= '                      <!-- Pills navs -->
                                              <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                                                  <li class="nav-item" role="presentation">
                                                      ' . Anchor::new('#pills-login')
                                                                ->setClass('nav-link active')
                                                                ->setId('tab-login')
                                                                ->addData('', 'mdb-pill-init')
                                                                ->addAria('true', 'selected')
                                                                ->setRole('tab')
                                                                ->setContent($_component->getText(tr('Sign in')))
                                                                ->setRenderRightsFail(EnumAnchorRenderRightsFail::full) . '
                                                  </li>
                                                  <li class="nav-item" role="presentation">
                                                      ' . Anchor::new('#pills-register')
                                                                ->setClass('nav-link')
                                                                ->setRole('tab')
                                                                ->setId('tab-register')
                                                                ->addData('', 'mdb-pill-init')
                                                                ->addAria('pills-register', 'controls')
                                                                ->addAria('false', 'selected')
                                                                ->setContent($_component->getText(tr('Register')))
                                                                ->setRenderRightsFail(EnumAnchorRenderRightsFail::full) . '
                                                  </li>
                                              </ul>';

            $render .= '                      <div class="tab-content">
                                                  <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
                                                      ' . $signin . '
                                                  </div>
                                                  <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="tab-register">
                                                      ' . $signup . '
                                                  </div>
                                              </div>';
        } else {
            $render .= $signin;
        }

        $render .= '                      </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </main>';

        return $render;
    }
}
