<?php

/**
 * Class TemplateUpdateLostPasswordPage
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

use Phoundation\Accounts\Users\Sessions\Session;
use Phoundation\Developer\Project\Project;
use Phoundation\Web\Html\Components\Anchor;
use Phoundation\Web\Html\Csrf;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\Url;
use Phoundation\Web\Requests\Response;


class TemplateUpdateLostPasswordPage extends TemplateRenderer
{
    public function render(): ?string
    {
        // This page will build its own body
        Response::setRenderMainWrapper(false);

        $_component = $this->getComponentObject();
        $_user      = Session::getUserObject();

        // Render the entire page
        $this->render = ' <header>
                              <section class="text-center text-md-start">
                                  <div class="p-5" style="height: 200px; background: url(' . Url::new($_component->getImage('image-background', default: config()->getString('platforms.web.pages.update-lost-password.images.banner', 'banners/large.jpg')))->makeImg() . ') center no-repeat;">
                                  </div>
                              </section>
                          </header>
                          <main class="mb-5" style="margin-top: -100px;">
                              <div class="container px-4">
                                  <div class="row d-flex justify-content-center">
                                      <div class="col-xl-5 col-md-8">
                                          <div class="card shadow-4">
                                              <div class="card-body p-4">
                                                  <form method="post" action="' . Url::new($_component->getUrl('form-action', default: config()->getString('platforms.web.pages.update-lost-password.urls.form', Url::newCurrent())))->makeWww() . '">
                                                      ' . Csrf::getHiddenElement() . '
                                                      <div class="sign-in text-center h1"> 
                                                          <img src="' . Url::new($_component->getImage('image-logo', default: config()->getString('platforms.web.pages.update-lost-password.images.logo', 'logos/large.webp')))->makeImg() . '" alt="' . $_component->getText(tr('Medinet Mobile')) . '" width="310">
                                                      </div>
                                                      <hr>
                                                      <h2 class="text-center">' . $_component->getText(tr('Update lost password')) . '</h2>
                                                      <p class="login-box-msg text-center">' . $_component->getText(tr('Please provide your new password below')) . '</p>
                                                      <hr>
                                                      <div class="form-outline mb-4" data-mdb-input-init>
                                                          <input type="password" id="password" name="password" class="form-control" />
                                                          <label class="form-label" for="password">' . $_component->getText(tr('Password')) . '</label>
                                                      </div>
                                                      <div class="form-outline mb-4" data-mdb-input-init>
                                                          <input type="password" id="passwordv" name="passwordv" class="form-control" />
                                                          <label class="form-label" for="passwordv">' . $_component->getText(tr('Verify password')) . '</label>
                                                      </div>
                                                      <button type="submit" class="btn btn-primary btn-block mb-4" data-mdb-ripple-init>
                                                          ' . $_component->getText(tr('Request a new password')) . '
                                                      </button>
                                                      <div class="row mb-4">
                                                          <div class="col-md-12 d-flex justify-content-center">
                                                              ' . Anchor::new()
                                                                        ->addClasses('btn btn-block btn-outline-primary')
                                                                        ->addData('', 'mdb-ripple-init')
                                                                        ->setUrlObject(Url::new($_component->getUrl('sign-in', default: 'sign-in'))->makeWww())
                                                                        ->setContent($_component->getText('Back to sign-in page')) . '
                                                          </div>
                                                      </div>';

        if ($_component->getEnabled('copyright', default: config()->getBoolean('platforms.web.pages.lost-password-page.enabled.copyright', true))) {
            $this->render .= '                        <div class="text-center">
                                                          ' . Project::getCopyrightString(true) . '
                                                      </div>';
        }

        $this->render .= '                        </form>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </main>';

        return $this->render;
    }
}
