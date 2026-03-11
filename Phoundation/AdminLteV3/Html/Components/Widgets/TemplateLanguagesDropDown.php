<?php

/**
 * Class TemplateLanguagesDropDown
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\AdminLteV3
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV3\Html\Components\Widgets;

use Phoundation\Date\PhoDate;
use Phoundation\Exception\OutOfBoundsException;
use Phoundation\Utils\Strings;
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

        $this->render =     Anchor::new('#')->setClass('nav-link')->addData('dropdown', 'toggle')->setContent('<i style="color:red;">&#x1F1E8;&#x1F1E6;</i>') .
                            '<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">';

        if ($count) {
            $current = 0;

            $this->render .= '  <span class="dropdown-item dropdown-header">' . tr(':count Languages', [':count' => $count]) . '</span>
                                    <div class="dropdown-divider"></div>';

            foreach ($languages as $language) {
                if (++$current > 12) {
                    break;
                }

                $this->render .= Anchor::new(str_replace(':ID', $language->getId(), $this->_component->getLanguagesUrl()))
                                       ->setClass('dropdown-item')
                                       ->setContent(($language->getIcon() ? '<i class="text-' . Html::safe($language->getMode()->value) . ' fas fa-' . Html::safe($language->getIcon()) . ' mr-2"></i> ' : null) . Strings::truncate($language->getTitle(), 24) . '<span class="float-right text-muted text-sm"> ' . Html::safe($language->getCreatedOnObject()->getAge()) . '</span>') .
                                 '<div class="dropdown-divider"></div>';
            }

        } else {
            $this->render .= '  <span class="dropdown-item dropdown-header">' . tr('No alternative languages available') . '</span>
                                    <div class="dropdown-divider"></div>';
        }

        $this->render .= '          ' . Anchor::new($this->_component->getSettingsUrl())->setClass('dropdown-item dropdown-footer')->setContent(tr('Language settings')) . '
                                </div>';

        return parent::render();
    }
}
