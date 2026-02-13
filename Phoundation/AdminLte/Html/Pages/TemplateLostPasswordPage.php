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

use Phoundation\Developer\Project\Project;
use Phoundation\Web\Html\Components\Anchor;
use Phoundation\Web\Html\Components\Img;
use Phoundation\Web\Html\Csrf;
use Phoundation\Web\Html\Enums\EnumAnchorRenderRightsFail;
use Phoundation\Web\Html\Enums\EnumHttpRequestMethod;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Requests\Response;


class TemplateLostPasswordPage extends TemplateRenderer
{
    public function render(): ?string
    {
        Response::setRenderMainWrapper(false);

        $_component  = $this->getComponentObject();
        $this->render = '   <body class="hold-transition login-page" style="background: url(' . $_component->getUrl('image-background') . '); background-position: center; background-repeat: no-repeat; background-size: cover;">
                                <div class="login-box">
                                    <div class="card card-outline card-info">
                                        <div class="card-header text-center">
                                            ' . Anchor::new(Project::getOwnerUrl())
                                                      ->setClass('h1')
                                                      ->setContent(Img::new('logos/large.jpg')
                                                                      ->setAlt(tr(':owner logo', [':owner' => Project::getOwnerName()])), false) . '
                                        </div>
                                        <div class="card-body">
                                            <h1 class="text-center">' . $_component->getText(tr('Lost password?')) . '</h1>            
                                            <p class="login-box-msg text-center">' . $_component->getText(tr('Please provide your email address and we will send you a link where you can re-establish your password')) . '</p>
                                            <form action="' . $_component->getUrl('form') . '" method="post">
                                                ' . Csrf::getHiddenElement() . '
                                                <div class="input-group mb-3">
                                                    <input type="email" name="email" id="email" class="form-control" placeholder="' . $_component->getText(tr('Email address')) . '"' . $_component->getValue(EnumHttpRequestMethod::get, 'email') . '>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-envelope"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary btn-block">' . $_component->getText(tr('Request a link to update your password')) . '</button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        ' . Anchor::new($_component->getUrl('back-to-sign-in'))
                                                                  ->setRenderRightsFail(EnumAnchorRenderRightsFail::full)
                                                                  ->setContent($_component->getText(tr('Back to sign in')))
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
