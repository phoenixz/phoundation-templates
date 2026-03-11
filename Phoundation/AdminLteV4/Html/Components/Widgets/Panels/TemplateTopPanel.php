<?php

/**
 * Class TemplateTopPanel
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\AdminLteV4
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV4\Html\Components\Widgets\Panels;

use Phoundation\Accounts\Users\Sessions\Session;
use Phoundation\Utils\Strings;
use Phoundation\Web\Html\Components\Anchor;
use Phoundation\Web\Html\Components\Icons\FullScreen;
use Phoundation\Web\Html\Components\Interfaces\RenderInterface;
use Phoundation\Web\Html\Enums\EnumDisplayMode;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\Url;
use Templates\Phoundation\AdminLteV4\Exception\AdminLteException;

class TemplateTopPanel extends TemplateRenderer
{
    /**
     * Renders and returns the top panel
     *
     * @return string|null
     */
    public function render(): ?string
    {
        // If impersonated, change top panel color and add an impersonation message
        if (Session::isImpersonated()) {
            $this->_component->setMode(EnumDisplayMode::danger);
            $message = tr('(Impersonated by ":user")', [':user' => Session::getRealUserObject()->getDisplayName()]);

        } else {
            $this->_component->setMode(EnumDisplayMode::white);
        }

        // Top level message?
        if (isset($message)) {
            $message = '    <li class="nav-item d-none d-sm-inline-block">
                              ' . Anchor::new('#', $message)->setClass('nav-link') . '
                            </li>';
        }

        // Build the left menu
        $left_menu = '    <ul class="navbar-nav">
                            <li class="nav-item">
                              ' . Anchor::new('#', '<i class="fas fa-bars"></i>')
                                        ->setRole('button')
                                        ->setClass('nav-link')
                                        ->addData('pushmenu', 'widget') . '  
                            </li>';

        if ($this->_component->keyExists('menu')) {
            foreach ($this->_component->get('menu') as $label => $url) {
                $left_menu .= ' <li class="nav-item d-none d-sm-inline-block">
                                  ' . Anchor::new($url, $label)->setClass('nav-link') . '
                                </li>';
            }
        }

        // Add the optional extra message and finish the left menu
        $left_menu .=       isset_get($message) . '
                          </ul>';

        // Build the top panel with the left menu in it
        $this->render = ' <nav class="main-header navbar navbar-expand navbar-' . Html::safe($this->_component->getMode()->value) . ' navbar-light">
                            <!-- Left navbar links -->
                            ' . $left_menu . '                    
                            <!-- Right navbar links -->
                            <ul class="navbar-nav ml-auto">';

        foreach ($this->_component->getElementsObject() as $element) {
            $element_type = Strings::until($element, '-');

            switch ($element) {
                case 'search':
                    $this->render .= '<!-- Navbar Search -->
                                      <li class="nav-item">
                                        ' . Anchor::new()
                                                  ->setClass('nav-link')
                                                  ->addData('navbar-search', 'widget')
                                                  ->setRole('button')
                                                  ->setContent('<i class="fas fa-search"></i>') . '
                                          <div class="navbar-search-block">
                                          <form class="form-inline" method="get">
                                            <div class="input-group input-group-sm">
                                              <input class="form-control form-control-navbar" type="search" placeholder="' . tr('Search everywhere') . '" aria-label="' . tr('Search everywhere') . '">
                                              <div class="input-group-append">
                                                <button class="btn btn-navbar" type="submit">
                                                  <i class="fas fa-search"></i>
                                                </button>
                                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                                  <i class="fas fa-times"></i>
                                                </button>
                                              </div>
                                            </div>
                                          </form>
                                        </div>
                                      </li>';
                    break;

                case 'messages':
                    $this->render .= '<!-- Messages Dropdown Menu -->
                                      <li class="nav-item dropdown messages">
                                        ' . $this->_component->getMessagesDropDownObject()->render() . '
                                      </li>';
                    break;

                case 'notifications':
                    $this->render .= '<!-- Notifications Dropdown Menu -->
                                      <li class="nav-item dropdown notifications">
                                        ' . $this->_component->getNotificationsDropDownObject()->render() . '
                                      </li>';
                    break;

                case 'languages':
                    $this->render .= '<li class="nav-item dropdown languages">                                  
                                          ' . $this->_component->getLanguagesDropDownObject()->render() . '
                                      </li>';
                    break;

                case 'icon':
                    $this->render .= '  <li class="nav-item">
                                          ' . $this->_component->getIcons()->get($element_type)->render() . '
                                        </li>';
                    break;

                case 'full-screen':
                    $this->render .= '<li class="nav-item">
                                        <span class="nav-link">' . FullScreen::new()->render() . '</span>
                                      </li>';
                    break;

                case 'sign-out':
                    $this->render .= '<li class="nav-item">
                                        ' . Anchor::new(Url::new('sign-out'), '<i class="fas fa-sign-out-alt"></i>')
                                                  ->setRole('button')
                                                  ->setClass('nav-link') . '
                                      </li>';
                    break;

                case 'sidebar-button':
                    $this->render .= '<li class="nav-item">
                                        ' . Anchor::new('#', '<i class="fas fa-th-large"></i>')
                                                  ->setRole('button')
                                                  ->setClass('nav-link')
                                                  ->addData('control-sidebar', 'widget')
                                                  ->addData('true', 'slide') . '
                                      </li>';
                    break;

                default:
                    // This is a custom element. Must be either a render-able object, or a callback that returns HTML
                    if ($element instanceof RenderInterface) {
                        $this->render .= $element->render();

                    } elseif (is_callable($element)) {
                        $this->render .= $element();

                    } else {
                        throw new AdminLteException(tr('Unknown top panel element ":element" specified', [
                            ':element' => $element
                        ]));
                    }
            }
        }

        $this->render .= '  </ul>
                          </nav>';

        return parent::render();
    }
}
