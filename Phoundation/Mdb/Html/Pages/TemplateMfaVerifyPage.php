<?php

/**
 * Class TemplateLostPasswordPage
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Pages;

use Phoundation\Accounts\Users\Sessions\Session;
use Phoundation\Web\Html\Components\Forms\Form;
use Phoundation\Web\Html\Csrf;
use Phoundation\Web\Html\Enums\EnumHttpRequestMethod;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\Url;
use Phoundation\Web\Requests\Response;
use RobThree\Auth\Providers\Qr\QRServerProvider;
use RobThree\Auth\TwoFactorAuth;


class TemplateMfaVerifyPage extends TemplateRenderer
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
        Response::setPageTitle(tr('Please setup multi-factor authentication'));
        Response::setHeaderTitle(tr('Please setup multi-factor authentication'));
        Response::loadJavaScript([
            'templates/mdb/js/jquery',
            'templates/phoundation/js/jquery-phoundation'
        ], prefix: true);

        $qr     = new QRServerProvider();
        $tfa    = new TwoFactorAuth(qrcodeprovider: $qr);
        $secret = $tfa->createSecret();

        // Render the page
        $render   = '   <form method="post" action="' . Url::newCurrent() . '">
                          ' . Csrf::getHiddenElement() . '
                          <div class="sign-in text-center h1"> 
                              <img src="' . Url::new('/logos/sign-in-large.webp')->makeImg() . '" alt="' . tr('Medinet Mobile') . '" width="310" height="51">
                          </div>
                          <hr>  
                          <p class="login-box-msg text-center">' .  tr('Please type the 2FA code for your account ":account"', [':account' => Session::getUserObject()->getDisplayName()]) . '</p>
                          ' . Form::new()
                                  ->setRequestMethod(EnumHttpRequestMethod::post)
                                  ->setAction(Url::new('mfa-create')->makeWww())
                                  ->setContent(Session::getMultiFactorAuthenticationObject()->renderVerify()) . '
                          <hr>

                          <!-- Submit button -->
                          <button type="submit" class="btn btn-primary btn-block mb-4" data-mdb-ripple-init>
                            ' . tr('Confirm and enable multi-factor authentication') . '
                          </button>
                          <a href="' . Url::new('mfa-create')->makeWww() . '" class="btn btn-outline-secondary btn-block mb-4" data-mdb-ripple-init>
                            ' . tr('Back to creating a new MFA code') . '
                          </a>
                          <a href="' . Url::new('signout')->makeWww() . '" class="btn btn-outline-secondary btn-block mb-4" data-mdb-ripple-init>
                            ' . tr('Sign out') . '
                          </a>';

        if (Session::supports('copyright')) {
            $render .= '  <div class="text-center">
                            Copyright © 2025 <a target="_blank" href="' . config()->getString('project.owner.url', 'https://phoundation.org') . '">' . config()->getString('project.owner.name', 'Phoundation') . '</a><br/><small>All rights reserved</small>
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
