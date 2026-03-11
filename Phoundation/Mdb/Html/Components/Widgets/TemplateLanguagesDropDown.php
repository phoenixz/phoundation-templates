<?php

/**
 * Class TemplateLanguagesDropDown
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Widgets;

use Phoundation\Exception\OutOfBoundsException;
use Phoundation\Web\Html\Components\Anchor;
use Phoundation\Web\Html\Components\Widgets\LanguagesDropDown;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateLanguagesDropDown extends TemplateRenderer
{
    /**
     * LanguagesDropDown class constructor
     */
    public function __construct(LanguagesDropDown $_component)
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
        if (!$this->_component->getSettingsUrl()) {
            throw new OutOfBoundsException(tr('No settings page URL specified'));
        }

        $languages = $this->_component->getLanguages();
        $count     = $languages?->getCount();

        $this->render = '   <span data-mdb-dropdown-init class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" aria-expanded="false">
                              <i class="flag-united-kingdom flag m-0"></i>
                            </span>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';

        if ($count) {
            $current = 0;

            $this->render .= '<li>
                                <span class="dropdown-item">
                                  <i class="flag-united-kingdom flag"></i>English
                                  <i class="fa fa-check text-success ms-2"></i
                                ></span>
                              </li>
                              <li>
                                <hr class="dropdown-divider" />
                              </li>';

            foreach ($languages as $language) {
                if (++$current > 12) {
                    break;
                }

                $this->render .= '<li>
                                    ' . Anchor::new(str_replace(':ID', $language->getId(), $this->_component->getLanguagesUrl()))
                                              ->setClass('dropdown-item')
                                              ->setContent('<i class="flag-' . $language->getFlagName() . ' flag"></i>' . $language->getName()) . '
                                  </li>';
            }

        } else {
            $this->render .= '    <li>
                                    <span class="dropdown-item" href="#">' . tr('No alternative languages available') . '</span>
                                  </li>
                                  <li>
                                    <hr class="dropdown-divider" />
                                  </li>';
        }

        $this->render .= '        <li>
                                    ' . Anchor::new($this->_component->getSettingsUrl())
                                              ->setClass('dropdown-item dropdown-footer')
                                              ->setContent(tr('Language settings')) . ' 
                                  </li>
                                </ul>';

        return parent::render();
    }
}
