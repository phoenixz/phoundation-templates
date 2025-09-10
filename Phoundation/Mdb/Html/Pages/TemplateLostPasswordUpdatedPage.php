<?php

/**
 * Class TemplateLostPasswordUpdatedPage
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
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\Url;
use Phoundation\Web\Requests\Response;


class TemplateLostPasswordUpdatedPage extends TemplateRenderer
{
    public function render(): ?string
    {
        // This page will build its own body
        Response::setRenderMainWrapper(false);

        $o_component = $this->getComponentObject();

        // Render the entire page
        $this->render = ' <header>
                              <section class="text-center text-md-start">
                                  <div class="p-5" style="height: 200px; background: url(' . Url::new($o_component->getImage('image-background', default: config()->getString('web.pages.update-lost-password.images.banner', 'banners/large.jpg')))->makeImg() . ') center no-repeat;">
                                  </div>
                              </section>
                          </header>
                          <main class="mb-5" style="margin-top: -100px;">
                              <div class="container px-4">
                                  <div class="row d-flex justify-content-center">
                                      <div class="col-xl-5 col-md-8">
                                          <div class="card shadow-4">
                                              <div class="card-body p-4">
                                                  <div class="sign-in text-center h1"> 
                                                      <img src="' . Url::new($o_component->getImage('image-logo', default: config()->getString('web.pages.sign-in.images.logo', 'logos/large.webp')))->makeImg() . '" alt="' . $o_component->getText(tr('Medinet Mobile')) . '" width="310">
                                                  </div>
                                                  <hr>
                                                  <p class="login-box-msg text-center">' . $o_component->getText(tr('All done! You can now continue to your dashboard or continue to the sign-in page...')) . '</p>
                                                  <hr>  
                                                  <div class="row mb-4">
                                                      <div class="col-md-12 d-flex justify-content-center">
                                                          ' . Anchor::new(Url::new($o_component->getUrl('sign-in', default: 'index')))
                                                                    ->setClass('btn btn-block btn-primary')
                                                                    ->addData('', 'mdb-ripple-init')
                                                                    ->setContent($o_component->getText('Go to dashboard')). '                                                            
                                                      </div>
                                                  </div>
                                                  <div class="row mb-4">
                                                      <div class="col-md-12 d-flex justify-content-center">
                                                          ' . Anchor::new()
                                                                    ->setClass('btn btn-block btn-outline-primary')
                                                                    ->addData('', 'mdb-ripple-init')
                                                                    ->setContent(Url::new($o_component->getUrl('sign-out', default: 'sign-out')))
                                                                    ->setContent($o_component->getText('Go back to sign-in page')). '
                                                      </div>
                                                </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </main>';





//        // Render the entire page
//        $this->render = '   <body class="hold-transition login-page" style="background: url(' . Url::new('backgrounds/password.jpg')->makeImg() . '); background-position: center; background-repeat: no-repeat; background-size: cover;">
//                                <div class="login-box">
//                                    <div class="card card-outline card-info">
//                                        <div class="card-header text-center">
//                                            <a href="' . Project::getOwnerUrl() . '" class="h1">' . Project::getOwnerLabel() . '</a>
//                                        </div>
//                                        <div class="card-body">
//                                            <p class="login-box-msg">' . tr('All done! You can now continue to your dashboard or continue to the sign-in page...') . '</p>
//
//                                            <form action="' . Url::new($o_component->getUrl('form-action', default: config()->getString('web.pages.update-lost-password.urls.form', Url::newCurrent()->getSource())))->makeWww() . '" method="post">
//                                                ' . Csrf::getHiddenElement() . '
//                                                <div class="row mb-3">
//                                                    <div class="col-12">
//                                                        <a href="' . Url::new($o_component->getUrl('form-action', default: config()->getString('web.pages.update-lost-password.urls.index', 'index')))->makeWww() . '" class="btn btn-primary btn-block">' . tr('Go to dashboard') . '</a>
//                                                    </div>
//                                                </div>
//                                                <div class="row mb-3">
//                                                    <div class="col-12">
//                                                        <a href="' . Url::new('sign-out')->makeWww()->removeQueryKeys('redirect') . '" class="btn btn-outline-secondary btn-block">' . tr('Go to sign-in page') . '</a>
//                                                    </div>
//                                                </div>
//                                            </form>
//                                        </div>
//                                    </div>
//                                </div>
//                            </body>';

        return $this->render;
    }
}
