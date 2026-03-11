<?php

/**
 * Class TemplateNotificationsDropDown
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLteV3
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV3\Html\Components\Widgets;

use Phoundation\Date\PhoDate;
use Phoundation\Exception\OutOfBoundsException;
use Phoundation\Notifications\Html\Components\Modals\NotificationModal;
use Phoundation\Utils\Strings;
use Phoundation\Web\Html\Components\Anchor;
use Phoundation\Web\Html\Components\Widgets\NotificationsDropDown;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateNotificationsDropDown extends TemplateRenderer
{
    /**
     * NotificationsDropDown class constructor
     */
    public function __construct(NotificationsDropDown $_component)
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
        if (!$this->_component->getAllNotificationsUrl()) {
            throw new OutOfBoundsException(tr('No all notifications page URL specified'));
        }

        if (!$this->_component->getNotificationsUrl()) {
            throw new OutOfBoundsException(tr('No notifications page URL specified'));
        }

        $_notifications = $this->_component->getNotifications();

        return cache('html')->getOrGenerate(static::class . '-' . $_notifications->getCacheKey(), function () use ($_notifications) {
            if ($_notifications) {
                $_notifications->autoUpdate();

                $count = $_notifications->getCount();
                $mode  = $_notifications->getMostImportantMode();
                $mode  = strtolower($mode);
                $mode  = match ($mode) {
                    // With HTML, "notice" and "information" are known as "info"
                    'unknown', 'notice', 'information' => 'info',
                    default                            => $mode
                };

            } else {
                $count = 0;
            }

            $this->render =     Anchor::new('#')->setClass('nav-link')
                                                ->addData('dropdown', 'toggle')
                                                ->setContent('<i class="far fa-bell"></i>' . ($count ? '<span class="badge badge-' . Html::safe($mode) . ' navbar-badge">' . Html::safe($count > 99 ? '99+' : $count) . '</span>' : null)) . '
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                  <span class="dropdown-item dropdown-header">' . tr(':count Notifications', [':count' => ($count > 99 ? '99+' : $count)]) . '</span>
                                  <div class="dropdown-divider"></div>';

            if ($count) {
                $current = 0;

                foreach ($_notifications as $_notification) {
                    if (++$current > 12) {
                        break;
                    }

                    $this->render .= Anchor::new(str_replace(':ID', (string) $_notification->getId(), (string) $this->_component->getNotificationsUrl()))
                                           ->setClass('dropdown-item notification open-modal')
                                           ->addData($_notification->getId(), 'id')
                                           ->setContent(($_notification->getIcon() ? '<i class="text-' . Html::safe($_notification->getMode()->value) . ' fas fa-' . Html::safe($_notification->getIcon()) . ' mr-2"></i> ' : null) . Html::safe(Strings::truncate($_notification->getTitle(), 24)) . ' <span class="float-right text-muted text-sm"> ' . Html::safe($_notification->getCreatedOnObject()->getAge()) . '</span>') . '                                    
                                  <div class="dropdown-divider"></div>';
                }
            }

            $this->render .=      Anchor::new($this->_component->getAllNotificationsUrl())->setClass('dropdown-item dropdown-footer')->setContent(tr('See all unread notifications')) . '
                                </div>';

            return parent::render() . NotificationModal::new()->render();
        });
    }
}
