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

use Phoundation\Web\Html\Csrf;
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

        $o_component  = $this->getComponentObject();
        $terms        = '<a href="' . Url::new('terms')->makeWww() . '">' . tr('terms and conditions') . '</a>';
        $register     = '<a href="' . Url::new('sign-up')->makeWww() . '">' . tr('Register') . '</a>';

        // Render SSO entries?
        if ($o_component->getEnabled('facebook')) {
            $facebook = ' <button type="button" class="btn btn-link btn-lg btn-floating mx-1" data-mdb-ripple-init data-ripple-color="primary">
                              <i class="fab fa-facebook-f"></i>
                          </button>';
        }

        if ($o_component->getEnabled('google')) {
            $google = ' <button type="button" class="btn btn-link btn-lg btn-floating mx-1" data-mdb-ripple-init data-ripple-color="primary">
                            <i class="fab fa-google"></i>
                        </button>';
        }

        if ($o_component->getEnabled('github')) {
            $github = ' <button type="button" class="btn btn-link btn-lg btn-floating mx-1" data-mdb-ripple-init data-ripple-color="primary">
                            <i class="fab fa-github"></i>
                        </button>';
        }

        // Render the sign-in page section
        $signin   = ' <form method="post" action="' . Url::new($o_component->getUrl('form-action', default: config()->getString('web.pages.sign-in.urls.form', 'sign-in')))->makeWww() . '">
                          ' . Csrf::getHiddenElement() . '
                          <div class="sign-in text-center h1"> 
                              <img src="' . Url::new($o_component->getImage('image-logo', default: config()->getString('web.pages.sign-in.images.logo', 'logos/large.webp')))->makeImg() . '" alt="' . $o_component->getText(tr('Medinet Mobile')) . '" width="310">
                          </div>
                          <hr>';

        if ($o_component->getEnabled('email', default: config()->getBoolean('web.pages.sign-in.enabled.email', true))) {
            $signin .= '  <div class="form-outline mb-4" data-mdb-input-init>
                              <input type="email" id="loginName" name="email" class="form-control"' . $o_component->getValue(EnumHttpRequestMethod::get, 'email') . ' />
                              <label class="form-label" for="loginName">' . $o_component->getText(tr('Email')) . '</label>
                          </div>
                          <div class="form-outline mb-4" data-mdb-input-init>
                              <input type="password" id="loginPassword" name="password" class="form-control" />
                              <label class="form-label" for="loginPassword">' . $o_component->getText(tr('Password')) . '</label>
                          </div>
                          <button type="submit" class="btn btn-primary btn-block mb-4" data-mdb-ripple-init>
                              ' . $o_component->getText(tr('Sign in')) . '
                          </button>';

        }

        $signin .=        $o_component->getSection('sso') . '
                          <div class="row mb-4">
                              <div class="col-md-12 d-flex justify-content-center">
                                  <a href="' . Url::new($o_component->getUrl('lost-password', default: 'lost-password'))->makeWww()->addQuery($o_component->get(EnumHttpRequestMethod::get, 'email'), 'email') . '">' . $o_component->getText('Forgot password?') . '</a>
                              </div>
                          </div>';

        if ($o_component->getEnabled('sign-up', default: config()->getBoolean('web.pages.sign-in.enabled.sign-up', true))) {
            $signin .= '   <div class="text-center">
                              <p>' . $o_component->getText(tr('Not a member? :register', [':register' => $register])) . '</p>
                          </div>';
        }

        if ($o_component->getEnabled('copyright', default: config()->getBoolean('web.pages.sign-in.enabled.copyright', true))) {
            $signin .= '  <div class="text-center">
                              ' . $o_component->getText(tr('Copyright © 2025 :url', [
                                  ':url' => '<a target="_blank" href="' . $o_component->getUrl('owner', default: config()->getString('project.owner.url', 'https://phoundation.org')) . '">' . $o_component->getText(config()->getString('project.owner.name', 'Phoundation')) . '</a>'
                              ])) . '
                              <br/>
                              <small>
                                  ' . $o_component->getText(tr('All rights reserved')) . '
                              </small>
                          </div>';
        }

        $signin .= '  </form>';

        // Render the entire page
        $render = '   <header>
                          <section class="text-center text-md-start">
                              <div class="p-5" style="height: 200px; background: url(' . Url::new($o_component->getUrl('banner', default: 'banners/large.jpg'))->makeImg() . ') center no-repeat;">
                              </div>
                          </section>
                      </header>
                      <main class="mb-5" style="margin-top: -100px;">
                          <div class="container px-4">
                              <div class="row d-flex justify-content-center">
                                  <div class="col-xl-5 col-md-8">
                                      <div class="card shadow-4">
                                          <div class="card-body p-4">';

        if ($o_component->getEnabled('signup')) {
            $render .= '                      <!-- Pills navs -->
                                              <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                                                  <li class="nav-item" role="presentation">
                                                      <a class="nav-link active" id="tab-login" data-mdb-pill-init href="#pills-login" role="tab" aria-controls="pills-login" aria-selected="true">
                                                          ' . $o_component->getText(tr('Sign in')) . '
                                                      </a>
                                                  </li>
                                                  <li class="nav-item" role="presentation">
                                                      <a class="nav-link" id="tab-register" data-mdb-pill-init href="#pills-register" role="tab" aria-controls="pills-register" aria-selected="false">
                                                          ' . $o_component->getText(tr('Register')) . '
                                                      </a>
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
