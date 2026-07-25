<?php

/**
 * Class TemplateForcePasswordUpdatePage
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


class TemplateForcePasswordUpdatePage extends TemplateRenderer
{
    /**
     * Renders and returns the sign in page
     *
     * @return string|null
     */
    public function render(): ?string
    {
        // This page will build its own body
        Response::setRenderMainWrapper(false);
        Response::setPageTitle(tr('Please update your password'));
        Response::setHeaderTitle(tr('Please update your password'));

        $_component = $this->getComponentObject();
        $get         = $_component->getGetData();

        // Render the page
        $render   = '   <form method="post" action="' . Url::newCurrent() . '">
                          ' . Csrf::getHiddenElement() . '
                          <div class="sign-in text-center h1"> 
                              <img src="' . Url::new('/logos/sign-in-large.webp')->makeImg() . '" alt="' . tr('PCJ Admin') . '" width="310" height="51">
                          </div>
                          <hr>  
                          <p class="login-box-msg">' .  tr('Please update your account to have a new and secure password password before continuing...') . '</p>
                          <p class="login-box-msg">' .  tr('Please ensure that your password has at least 10 characters, is secure, and is known only to you.') . '</p>
                          <div class="form-outline mb-4" data-mdb-input-init>
                            <input type="password" id="password" name="password" class="form-control"' . (isset($get['email']) ? 'value="' . $get['email'] . '"' : '') . ' />
                            <label class="form-label" for="loginName">' . tr('Password') . '</label>
                          </div>

                          <!-- Password input -->
                          <div class="form-outline mb-4" data-mdb-input-init>
                            <input type="password" id="passwordv" name="passwordv" class="form-control" />
                            <label class="form-label" for="loginPassword">' . tr('Verify password') . '</label>
                          </div>

                          <!-- Submit button -->
                          <button type="submit" class="btn btn-primary btn-block mb-4" data-mdb-ripple-init>
                            ' . tr('Update and continue') . '
                          </button>
                          ' . Anchor::new(Url::new('signout'))
                                    ->setContent(tr('Sign out'))
                                    ->setClass('btn btn-outline-secondary btn-block mb-4')
                                    ->addData('', 'mdb-ripple-init');

        if ($_component->getEnabled('copyright')) {
            $render .= '  <div class="text-center">
                              ' . Project::getCopyrightString() . '
                          </div>';
        }

        $render .= Csrf::getHiddenElement() .
            '    </form>';

        // Render the entire page
        $this->render = '   <!--Main Navigation-->
                            <header>
                              <!-- Heading -->
                              <section class="text-center text-md-start">
                                <!-- Background gradient -->
                                <div class="p-5" style="height: 200px; background: url(' . Url::new('banners/large.jpg')->makeImg() . ') center no-repeat;  !important;">
                                </div>
                                <!-- Background gradient -->
                              </section>
                              <!-- Heading -->

                            </header>
                            <!--Main Navigation-->

                            <!--Main layout-->
                            <main class="mb-5" style="margin-top: -100px;">
                              <!-- Container for demo purpose -->
                              <div class="container px-4">

                                <div class="row d-flex justify-content-center">
                                  <div class="col-xl-5 col-md-8">
                                    <div class="card shadow-4">
                                      <div class="card-body p-4">';

                                        $this->render .= $render;

        $this->render .= '            </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </main>';

        return parent::render(); // TODO: Change the autogenerated stub
    }
}
