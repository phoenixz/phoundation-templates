<?php

/**
 * Class TemplateMessagesDropDown
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\AdminLteV4
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV4\Html\Components\Widgets;

use Phoundation\Exception\OutOfBoundsException;
use Phoundation\Web\Html\Components\Anchor;
use Phoundation\Web\Html\Components\Widgets\MessagesDropDown;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateMessagesDropDown extends TemplateRenderer
{
    /**
     * MessagesDropDown class constructor
     */
    public function __construct(MessagesDropDown $_component)
    {
        parent::__construct($_component);
    }


    /**
     * Renders and returns the NavBar
     *
     * @return string|null
     */
    public function render(): ?string
    {
        if (!$this->_component->getMessagesUrl()) {
            throw new OutOfBoundsException(tr('No messages page URL specified'));
        }

        if ($this->_component->getMessages()) {
            $count = $this->_component->getMessages()->count();
        } else {
            $count = 0;
        }

        $this->render =         Anchor::new('#')
                                      ->setClass('nav-link')
                                      ->addData('dropdown', 'toggle')
                                      ->setContent('<i class="far fa-comments"></i > ' . ($count ? '<span class="badge badge-danger navbar-badge"> ' . Html::safe($count) . '</span > ' : null), false) . '    
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                  <span class="dropdown-item dropdown-header">' . tr(':count Messages', [':count' => ($count > 99 ? '99+' : $count)]) . '</span>
                                  <div class="dropdown-divider"></div>';

        if ($count) {
            foreach ($this->_component->getMessages() as $message) {
                $this->render .= Anchor::new($message->getUrl())
                                       ->setClass('dropdown-item')
                                       ->setContent('<!-- Message Start -->
                                                    <div class="media">
                                                      <img src="' . Html::safe($message->getAvatar()) . '" alt="' . tr('Avatar for :user', [':user' => Html::safe($message->getDisplayName())]) . '" class="img-size-50 mr-3 img-circle">
                                                      <div class="media-body">
                                                        <h3 class="dropdown-item-title">
                                                          ' . Html::safe($message->getDisplayName()) . '
                                                          ' . (Html::safe($message->getStar()) ? '<span class="float-right text-sm text-' . Html::safe($message->getStar()) . '"><i class="fas fa-star"></i></span>' : null) . '
                                                        </h3>
                                                        <p class="text-sm">' . Html::safe($message->getMessageHeader()) . '</p>
                                                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> ' . Html::safe($message->getAge()) . '</p>
                                                      </div>
                                                    </div>
                                                    <!-- Message End -->') . '
                                  <div class="dropdown-divider"></div>';
            }
        }

        $this->render .=          Anchor::new($this->_component->getMessagesUrl())
                                        ->setClass('dropdown-item dropdown-footer')
                                        ->setContent(tr('See All Messages')) . '
                                </div>';

        return parent::render();
    }
}
