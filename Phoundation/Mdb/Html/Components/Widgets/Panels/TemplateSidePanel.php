<?php

/**
 * Class TemplateSidePanel
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Widgets\Panels;

use Phoundation\Accounts\Users\Sessions\Session;
use Phoundation\Developer\Project\Project;
use Phoundation\Utils\Strings;
use Phoundation\Web\Html\Components\Anchor;
use Phoundation\Web\Html\Components\Widgets\Panels\SidePanel;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\Url;

class TemplateSidePanel extends TemplateRenderer
{
    /**
     * SidePanel class constructor
     */
    public function __construct(SidePanel $_component)
    {
        parent::__construct($_component);
    }


    /**
     * Renders and returns the sidebar
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $this->render = ' <nav data-mdb-sidenav-init id="sidenav-9" data-mdb-scroll-container="#scroll-container" class="sidenav sidenav-sm" data-mdb-accordion="true" data-mdb-hidden="' . (Session::getAutoShowMenu() ? 'false' : 'true') . '">
                              ' . Anchor::new(Url::new('index'))
                                        ->setClass('d-flex justify-content-center py-4 mb-3')
                                        ->addData('', 'mdb-ripple-init')
                                        ->setStyle('background: white; border-bottom: 2px solid #f5f5f5" data-mdb-ripple-color="primary')
                                        ->setContent('<img src="' . Url::new('logos/large.png')->makeImg() . '" alt="' . tr(':project logo', [':project' => Strings::capitalize(Project::getHumanReadableFullName())]) . '" width="200px" draggable="false">') .
                                  Anchor::new(Url::new('profile'))
                                        ->setClass('d-flex py-4 mb-3 justify-content-center')
                                        ->addData('', 'mdb-ripple-init')
                                        ->addData('primary', 'mdb-ripple-color')
                                        ->setStyle('align-items: center; border-bottom: 2px solid #f5f5f5')
                                        ->setContent(Session::getUserObject()->getProfileImageObject()->getHtmlImgObject()
                                                            ->setId('menu-profile-image')
                                                            ->setClass('img-circle elevation-2')
                                                            ->setAlt(tr('Profile picture for :user', [':user' => Session::getUserObject()->getDisplayName()]))
                                                            ->setWidth(32)
                                                            ->setHeight(32) . Session::getUserObject()->getDisplayName(reverse: true)). '
                              ' . $this->_component->getMenu()?->render() . '
                          </nav>';

        $this->render .= $this->_component->getModals()?->render() . PHP_EOL;

        return parent::render();

//        $this->render = ' <aside class="main-sidebar sidebar-dark-primary elevation-4">
//                            <a href="' . Url::new('index')->makeWww() . '" class="brand-link">
//                              <img src="' . Url::new('logos/large.webp')->makeImg() . '" alt="' . tr(':project logo', [':project' => Strings::capitalize(Project::getHumanReadableFullName())]) . '" class="brand-image elevation-3" style="opacity: .8" width="250px">
//                            </a>
//                            <div class="sidebar">
//                              <div class="user-panel mt-3 pb-3 mb-3 d-flex">
//                                <div class="image">
//                                  <a href="' . (Session::getUserObject()->isGuest() ? '#' : Url::new('/my/profile.html')->makeWww()) . '" class="d-block">
//                                    ' . Session::getUserObject()
//                                               ->getProfileImageObject()->getHtmlImgObject()
//                                                                        ->setId('menu-profile-image')
//                                                                        ->setSrc(Url::new('img/profiles/default.png')->makeImg())
//                                                                        ->setClass('img-circle elevation-2')
//                                                                        ->setAlt(tr('Profile picture for :user', [':user' => Session::getUserObject()->getDisplayName()]))
//                                                                        ->render() . '
//                                  </a>
//                                </div>
//                                <div class="info">
//                                  <a href="' . (Session::getUserObject()->isGuest() ? '#' : Url::new('/my/profile.html')->makeWww()) . '" class="d-block">' . Session::getUserObject()->getDisplayName() . '</a>
//                                </div>
//                              </div>
//                              <div class="form-inline">
//                                <div class="input-group" data-widget="sidebar-search">
//                                  <input class="form-control form-control-sidebar" type="search" placeholder="' . tr('Search menu') . '" aria-label="' . tr('Search menu') . '">
//                                  <div class="input-group-append">
//                                    <button class="btn btn-sidebar">
//                                      <i class="fas fa-search fa-fw"></i>
//                                    </button>
//                                  </div>
//                                </div>
//                                <div class="sidebar-search-results">
//                                  <div class="list-group">
//                                    <a href="#" class="list-group-item">
//                                      <div class="search-title">
//                                        <strong class="text-light"></strong>N<strong class="text-light"></strong>o<strong class="text-light"></strong> <strong class="text-light"></strong>e<strong class="text-light"></strong>l<strong class="text-light"></strong>e<strong class="text-light"></strong>m<strong class="text-light"></strong>e<strong class="text-light"></strong>n<strong class="text-light"></strong>t<strong class="text-light"></strong> <strong class="text-light"></strong>f<strong class="text-light"></strong>o<strong class="text-light"></strong>u<strong class="text-light"></strong>n<strong class="text-light"></strong>d<strong class="text-light"></strong>!<strong class="text-light"></strong>
//                                      </div>
//                                      <div class="search-path">
//                                      </div>
//                                    </a>
//                                  </div>
//                                </div>
//                              </div>
//
//                              <!-- Sidebar Menu -->
//                              <nav>
//                                ' . $this->_component->getMenu()?->render() . '
//                              </nav>
//                              <!-- /.sidebar-menu -->
//                            </div>
//                            <!-- /.sidebar -->
//                          </aside>';
//
//        $this->render .= $this->_component->getModals()?->render() . PHP_EOL;
//
//        return parent::render();
    }
}
