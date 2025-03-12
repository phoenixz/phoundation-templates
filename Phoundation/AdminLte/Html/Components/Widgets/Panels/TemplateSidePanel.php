<?php

/**
 * Class TemplateSidePanel
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Components\Widgets\Panels;

use Phoundation\Core\Core;
use Phoundation\Core\Sessions\Session;
use Phoundation\Utils\Strings;
use Phoundation\Web\Html\Components\Widgets\Panels\SidePanel;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\Url;


class TemplateSidePanel extends TemplateRenderer
{
    /**
     * SidePanel class constructor
     */
    public function __construct(SidePanel $o_component)
    {
        parent::__construct($o_component);
    }


    /**
     * Renders and returns the sidebar
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $this->render = ' <aside class="main-sidebar sidebar-dark-primary elevation-4">
                            <a href="' . Url::newCurrent() . '" class="brand-link">
                              <img src="' . Url::new('img/logos/' . Core::getProjectSeoName() . '/large.webp')->makeImg() . '" alt="' . tr(':project logo', [':project' => Strings::capitalize(config()->get('project.name'))]) . '" class="brand-image elevation-3" width="250px" style="opacity: .8">
                            </a>
                            <div class="sidebar">
                              <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                                <div class="image">
                                    <a href="' . (Session::getUserObject()->isGuest() ? '#' : Url::new('/my/profile.html')->makeWww()) . '" class="d-block">
                                      ' . Session::getUserObject()
                                                 ->getProfileImageObject()
                                                     ->getHtmlImgObject()
                                                         ->setId('menu-profile-image')
                                                         ->setClass('img-circle elevation-2')
                                                         ->setAlt(tr('Profile picture for :user', [':user' => Session::getUserObject()->getDisplayName()]))
                                                         ->render() . '
                                    </a>
                                  </div>
                                <div class="info">
                                  <a href="' . (Session::getUserObject()->isGuest() ? '#' : Url::new('/my/profile.html')->makeWww()) . '" class="d-block">' . Session::getUserObject()->getDisplayName() . '</a>
                                </div>
                              </div>
                              <div class="form-inline">
                                <div class="input-group" data-widget="sidebar-search">
                                  <input class="form-control form-control-sidebar" type="search" placeholder="' . tr('Search menu') . '" aria-label="' . tr('Search menu') . '">
                                  <div class="input-group-append">
                                    <button class="btn btn-sidebar">
                                      <i class="fas fa-search fa-fw"></i>
                                    </button>
                                  </div>
                                </div>
                                <div class="sidebar-search-results">
                                  <div class="list-group">
                                    <a href="#" class="list-group-item">
                                      <div class="search-title">
                                        <strong class="text-light"></strong>N<strong class="text-light"></strong>o<strong class="text-light"></strong> <strong class="text-light"></strong>e<strong class="text-light"></strong>l<strong class="text-light"></strong>e<strong class="text-light"></strong>m<strong class="text-light"></strong>e<strong class="text-light"></strong>n<strong class="text-light"></strong>t<strong class="text-light"></strong> <strong class="text-light"></strong>f<strong class="text-light"></strong>o<strong class="text-light"></strong>u<strong class="text-light"></strong>n<strong class="text-light"></strong>d<strong class="text-light"></strong>!<strong class="text-light"></strong>
                                      </div>
                                      <div class="search-path">
                                      </div>
                                    </a>
                                  </div>
                                </div>
                              </div>
                        
                              <!-- Sidebar Menu -->
                              <nav>
                                ' . $this->o_component->getMenu()?->render() . '                                
                              </nav>
                              <!-- /.sidebar-menu -->
                            </div>
                            <!-- /.sidebar -->
                          </aside>';

        $this->render .= $this->o_component->getModals()?->render() . PHP_EOL;

        return parent::render();
    }
}
