<?php

/**
 * Class TemplateSignInPage
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
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


class TemplateLostPasswordPage extends TemplateRenderer
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

        // Render the entire page
        $render  = '  <header>
                          <section class="text-center text-md-start">
                              <div class="p-5" style="height: 200px; background: url(' . Url::new($o_component->getImage('image-background-lost-password', default: 'banners/large.jpg'))->makeImg() . ') center no-repeat;">
                              </div>
                          </section>
                      </header>
                      <main class="mb-5" style="margin-top: -100px;">
                          <div class="container px-4">
                              <div class="row d-flex justify-content-center">
                                  <div class="col-xl-5 col-md-8">
                                      <div class="card shadow-4">
                                          <div class="card-body p-4">
                                              <form method="post" action="' . Url::new($o_component->getUrl('form-action', default: config()->getString('web.pages.lost-password.urls.form', 'lost-password')))->makeWww() . '">
                                                  ' . Csrf::getHiddenElement() . '
                                                  <div class="sign-in text-center h1"> 
                                                      <img src="' . Url::new($o_component->getImage('image-logo', default: config()->getString('web.pages.sign-in.images.logo', 'logos/large.webp')))->makeImg() . '" alt="' . $o_component->getText(tr('Medinet Mobile')) . '" width="310">
                                                  </div>
                                                  <hr>
                                                  <h2 class="text-center">' . $o_component->getText(tr('Lost your password?')) . '</h2>
                                                  <p class="login-box-msg text-center">' . $o_component->getText(tr('Please provide your email address and we will send you a link where you can re-establish your password')) . '</p>
                                                  <hr>
                                                  <div class="form-outline mb-4" data-mdb-input-init>
                                                      <input type="email" id="loginName" name="email" class="form-control"' . $o_component->getValue(EnumHttpRequestMethod::get, 'email') . ' />
                                                      <label class="form-label" for="loginName">' . $o_component->getText(tr('Email address')) . '</label>
                                                  </div>
                                                  <button type="submit" class="btn btn-primary btn-block mb-4" data-mdb-ripple-init>
                                                      ' . $o_component->getText(tr('Request a new password')) . '
                                                  </button>
                                                  <div class="row mb-4">
                                                      <div class="col-md-12 d-flex justify-content-center">
                                                          <a data-mdb-ripple-init class="btn btn-block btn-outline-primary" href="' . Url::new($o_component->getUrl('sign-in', default: 'sign-in'))->makeWww() . '">' . $o_component->getText('Back to sign-in page') . '</a>
                                                      </div>
                                                  </div>';

        if ($o_component->getEnabled('copyright', default: config()->getBoolean('web.pages.lost-password-page.enabled.copyright', true))) {
            $render .= '                          <div class="text-center">
                                                      ' . $o_component->getText(tr('Copyright © 2025 :url', [
                                                          ':url' => '<a target="_blank" href="' . $o_component->getUrl('owner', default: config()->getString('project.owner.url', 'https://phoundation.org')) . '">' . $o_component->getText(config()->getString('project.owner.name', 'Phoundation')) . '</a>'
                                                      ])) . '      
                                                      <br/>
                                                      <small>
                                                          ' . $o_component->getText(tr('All rights reserved')) . '
                                                      </small>
                                                  </div>';
        }

        $render .= '                          </form>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </main>';

        return $render;
    }
}
