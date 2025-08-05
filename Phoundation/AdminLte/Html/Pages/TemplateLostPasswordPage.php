<?php

/**
 * Class TemplateLostPasswordPage
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

use Phoundation\Web\Html\Csrf;
use Phoundation\Web\Html\Enums\EnumHttpRequestMethod;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\Url;


class TemplateLostPasswordPage extends TemplateRenderer
{
    public function render(): ?string
    {
        $o_component  = $this->getComponentObject();
        $this->render = '   <body class="hold-transition login-page" style="background: url(' . Url::new($o_component->getUrl('image-background'))->makeImg() . '); background-position: center; background-repeat: no-repeat; background-size: cover;">
                                <div class="login-box">
                                    <div class="card card-outline card-info">
                                        <div class="card-header text-center">
                                            <a href="' . Url::new($o_component->getUrl('customer'))->makeImg() . '" class="h1">' . $o_component->getText('owner-label') . '</a>
                                        </div>
                                        <div class="card-body">
                                            <p class="login-box-msg text-center">' . $o_component->getText(tr('Please provide your email address and we will send you a link where you can re-establish your password')) . '</p>
                                            <form action="' . $o_component->getUrl('form') . '" method="post">
                                                ' . Csrf::getHiddenElement();

        if ($o_component->getEnabled('email')) {
            $this->render .= '                  <div class="input-group mb-3">
                                                    <input type="email" name="email" id="email" class="form-control" placeholder="' . $o_component->getText(tr('Email address')) . '"' . $o_component->getValue(EnumHttpRequestMethod::get, 'email') . '>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-envelope"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary btn-block">' . $o_component->getText(tr('Request a link to update your password')) . '</button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <a class="btn btn-outline-secondary btn-block" href="' . $o_component->getUrl('back-to-sign-in') . '">' . $o_component->getText(tr('Back to sign in')) . '</a>
                                                    </div>
                                                </div>';
        }

        $this->render .= '                  </form>
                                        </div>
                                    </div>
                                </div>
                            </body>';

        return parent::render();
    }
}
