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

use Phoundation\Web\Html\Components\Anchor;
use Phoundation\Web\Html\Csrf;
use Phoundation\Web\Html\Enums\EnumAnchorRenderRightsFail;
use Phoundation\Web\Html\Enums\EnumHttpRequestMethod;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\Url;
use Phoundation\Web\Requests\Response;


class TemplateLostPasswordPage extends TemplateRenderer
{
    public function render(): ?string
    {
        Response::setRenderMainWrapper(false);

        $o_component  = $this->getComponentObject();
        $this->render = '   <body class="hold-transition login-page" style="background: url(' . $o_component->getUrl('image-background') . '); background-position: center; background-repeat: no-repeat; background-size: cover;">
                                <div class="login-box">
                                    <div class="card card-outline card-info">
                                        <div class="card-header text-center">
                                            <img src="' . Url::new($o_component->getImage('image-logo', default: config()->getString('web.pages.sign-in.images.logo', 'logos/large.webp')))->makeImg() . '" alt="' . $o_component->getText(tr('Medinet tracking')) . '" width="310">                                        
                                        </div>
                                        <div class="card-body">
                                            <h1 class="text-center">' . $o_component->getText(tr('Lost password?')) . '</h1>            
                                            <p class="login-box-msg text-center">' . $o_component->getText(tr('Please provide your email address and we will send you a link where you can re-establish your password')) . '</p>
                                            <form action="' . $o_component->getUrl('form') . '" method="post">
                                                ' . Csrf::getHiddenElement() . '
                                                <div class="input-group mb-3">
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
                                                        ' . Anchor::new($o_component->getUrl('back-to-sign-in'))
                                                                  ->setRenderRightsFail(EnumAnchorRenderRightsFail::full)
                                                                  ->setContent($o_component->getText(tr('Back to sign in')))
                                                                  ->setClass('btn btn-outline-secondary btn-block') . '                                                       
                                                    </div>
                                                </div>  
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </body>';

        return $this->render;
    }
}
