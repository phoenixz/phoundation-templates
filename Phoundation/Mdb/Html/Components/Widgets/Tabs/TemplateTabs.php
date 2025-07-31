<?php

/**
 * Class TemplateCard
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Widgets\Tabs;

use Phoundation\Exception\UnderConstructionException;
use Phoundation\Web\Html\Components\Interfaces\RenderInterface;
use Phoundation\Web\Html\Components\Widgets\Tabs\Interfaces\TabsInterface;
use Phoundation\Web\Html\Enums\EnumOrientation;
use Phoundation\Web\Html\Template\TemplateRenderer;

class TemplateTabs extends TemplateRenderer
{
    /**
     * Card class constructor
     */
    public function __construct(TabsInterface $o_component)
    {
        parent::__construct($o_component);
    }


    /**
     * @inheritDoc
     */
    public function render(): ?string
    {
        $buttons = null;
        $o_tabs = $this->o_component;

        if (
            $o_tabs->getButtons()
                   ->getCount()
        ) {
            $buttons = '<div class="modal-footer justify-content-between buttons">
                            ' . $o_tabs->getButtons()
                                       ->render() . '
                        </div>';
        }

        switch ($o_tabs->getOrientation()) {
            case EnumOrientation::top:
                $this->render = $this->renderTop($o_tabs, $buttons);
                break;

            case EnumOrientation::left:
                $this->render = $this->renderLeft($o_tabs, $buttons);
                break;

            case EnumOrientation::right:
                $this->render = $this->renderRight($o_tabs, $buttons);
                break;

            case EnumOrientation::bottom:
                throw new UnderConstructionException(tr('bottom orientation for tabs is still under construction!'));
        }

        return parent::render();
    }


    /**
     * Renders the tabs with orientation top
     *
     * @param TabsInterface $o_tabs
     * @param string        $buttons
     *
     * @return string|null
     */
    protected function renderTop(TabsInterface $o_tabs, string $buttons): ?string
    {
        $before = $this->renderTopBeforeContent($o_tabs->getBeforeContent());
        $after  = $this->renderTopAfterContent($o_tabs->getAfterContent());

        $render = '      <div class="row">
                             <ul class="nav nav-tabs mb-3" role="tablist">' . $before;

        // Render the tabs
        $active_tab = $o_tabs->getActiveTab();

        if (empty($active_tab)) {
            $first_tab_active = true;
            $active = true;

        } else {
            $first_tab_active = false;
            $active = false;
        }

        foreach ($o_tabs as $tab) {
            if (!$first_tab_active) {
                $name = $tab->getName();

                if ($name === $active_tab) {
                    $active = true;
                }
            }

            $render .= '        <li class="nav-item" role="presentation">
                                    <a data-mdb-tab-init class="nav-link ' . ($active ? ' active' : '') . $tab->getClass(' ') . '" id="' . $tab->getId() . '-tab" href="#' . $tab->getId() . '" role="tab" aria-controls="' . $tab->getId() . '" aria-selected="' . ($active ? 'true' : 'false') . '">
                                        ' . $tab->getLabel() . '
                                    </a>
                                </li>';

            $active = false;
        }

        // Render the change to tabs / contents
        $render .= $after . '</ul>
                             <div class="tab-content" id="ex-with-icons-content">';

        $active_tab = $o_tabs->getActiveTab();

        if (empty($active_tab)) {
            $first_tab_active = true;
            $active = true;

        } else {
            $first_tab_active = false;
            $active = false;
        }

        foreach ($o_tabs as $tab) {
            if (!$first_tab_active) {
                $name = $tab->getName();

                if ($name === $active_tab) {
                    $active = true;
                }
            }

            $render .= '         <div class="tab-pane fade' . ($active ? ' active show' : '') . '" id="' . $tab->getId() . '" role="tabpanel" aria-labelledby="' . $tab->getId() . '-tab">
                                     ' . $tab->getContent() . '
                                 </div>';

            $active = false;
        }

        $render .= '         </div>
                             ' . $buttons . '
                         </div>';
        return $render;
    }


    /**
     * Renders and returns the after content
     *
     * @param RenderInterface|array|callable|string|null $content
     *
     * @return string|null
     */
    protected function renderContent(RenderInterface|array|callable|string|null $content): ?string
    {
        if (is_callable($content)) {
            $content = $content();
        }

        if (is_array($content)) {
            $return = null;

            foreach ($content as $item) {
                $return .= $this->renderContent($item);
            }

            return $return;
        }

        if ($content instanceof RenderInterface) {
            return $content->render();
        }

        if (is_string($content)) {
            return $content;
        }

        return null;
    }


    /**
     * Renders and returns the before content
     *
     * @param RenderInterface|array|callable|string|null $content
     *
     * @return string|null
     */
    protected function renderTopBeforeContent(RenderInterface|array|callable|string|null $content): ?string
    {
        if ($content) {
            return '<li class="nav-before">' . $this->renderContent($content) . '</li>';
        }

        return null;
    }


    /**
     * Renders and returns the after content
     *
     * @param RenderInterface|array|callable|string|null $content
     *
     * @return string|null
     */
    protected function renderTopAfterContent(RenderInterface|array|callable|string|null $content): ?string
    {
        if ($content) {
            return '<li class="nav-after">' . $this->renderContent($content) . '</li>';
        }

        return null;
    }


    /**
     * Returns the tabs with orientation left
     *
     * @param TabsInterface $o_tabs
     * @param string        $buttons
     *
     * @return string|null
     */
    protected function renderLeft(TabsInterface $o_tabs, string $buttons): ?string
    {
throw new UnderConstructionException(tr('left orientation for tabs with MDB template requires an upgrade to support before and after content!'));
        $content_display_size = $o_tabs->getContentDisplaySize()->value;
        $tab_display_size     = 12 - $content_display_size;

        $render = '  <div class="row w-100">
                         <div class="col-' . $tab_display_size . ' col-sm-' . $tab_display_size . '">
                             <div class="nav flex-column nav-tabs text-center" id="v-tabs-tab" role="tablist" aria-orientation="vertical">';

        // Render the tabs
        $active_tab = $o_tabs->getActiveTab();

        if (empty($active_tab)) {
            $first_tab_active = true;
            $active           = true;

        } else {
            $first_tab_active = false;
            $active           = false;
        }

        foreach ($o_tabs as $tab) {
            if (!$first_tab_active) {
                $name = $tab->getName();

                if ($name === $active_tab) {
                    $active = true;
                }
            }

            $render .= '         <a data-mdb-tab-init class="nav-link' . $tab->getClass(' ') . ($active ? ' active' : '') . '" id="' . $tab->getId() . '-tab" href="#' . $tab->getId() . '" role="tab" aria-controls="' . $tab->getId() . '" aria-selected="' . ($active ? 'true' : 'false') . '">
                                     ' . $tab->getLabel() . '
                                 </a>';
            $active = false;
        }

        // Render the change to tabs / contents
        $render .= '         </div>
                         </div>
                         <div class="col-' . $content_display_size . ' col-sm-' . $content_display_size . '">
                             <div class="tab-content" id="v-tabs-tabContent">';

        $active_tab = $o_tabs->getActiveTab();

        if (empty($active_tab)) {
            $first_tab_active = true;
            $active           = true;

        } else {
            $first_tab_active = false;
            $active           = false;
        }

        foreach ($o_tabs as $tab) {
            if (!$first_tab_active) {
                $name = $tab->getName();

                if ($name === $active_tab) {
                    $active = true;
                }
            }

            $render .= '         <div class="tab-pane fade' . ($active ? ' active show' : '') . '" id="' . $tab->getId() . '" role="tabpanel" aria-labelledby="' . $tab->getId() . '-tab">
                                     ' . $tab->getContent() . '
                                 </div>';

            $active = false;
        }

        $render .= '         </div>
                         </div>
                         ' . $buttons . '
                     </div>';

        return $render;
    }


    /**
     * Renders the Right orientation tabs
     *
     * @param TabsInterface $o_tabs
     * @param string        $buttons
     *
     * @return string|null
     */
    public function renderRight(TabsInterface $o_tabs, string $buttons): ?string
    {
        throw new UnderConstructionException(tr('right orientation for tabs with MDB template is still under construction!'));

        $render = '  <div class="row">
                         <div class="col-' . $content_display_size . ' col-sm-' . $content_display_size . '">
                             <div class="tab-content" id="vert-tabs-tabContent">';

        // Render the tab contents
        $active_tab = $o_tabs->getActiveTab();

        if (empty($active_tab)) {
            $first_tab_active = true;
            $active = true;

        } else {
            $first_tab_active = false;
            $active = false;
        }

        foreach ($o_tabs as $tab) {
            if (!$first_tab_active) {
                $name = $tab->getName();

                if ($name === $active_tab) {
                    $active = true;
                }
            }

            $render .= '         <div class="tab-pane text-left fade' . ($active ? ' active show' : '') . '" id="' . $tab->getId() . '" role="tabpanel" aria-labelledby="' . $tab->getId() . '-tab">
                                 ' . $tab->getContent() . '
                                 </div>';

            $active = false;
        }

        $render .= '         </div>
                         </div>
                         <div class="col-' . $tab_display_size . ' col-sm-' . $tab_display_size . '">
                             <div class="nav flex-column nav-tabs nav-tabs-right h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">';

        // Render the tabs
        $active_tab = $o_tabs->getActiveTab();

        if (empty($active_tab)) {
            $first_tab_active = true;
            $active = true;

        } else {
            $first_tab_active = false;
            $active = false;
        }

        foreach ($o_tabs as $tab) {
            if (!$first_tab_active) {
                $name = $tab->getName();

                if ($name === $active_tab) {
                    $active = true;
                }
            }

            $render .= '         <a class="nav-link' . $tab->getClass(' ') . ($active ? ' active' : '') . '" id="' . $tab->getId() . '-tab" data-toggle="pill" href="#' . $tab->getId() . '" role="tab" aria-controls="' . $tab->getId() . '" aria-selected="' . ($active ? 'true' : 'false') . '">
                                     ' . $tab->getLabel() . '
                                 </a>';
            $active = false;
        }

        // Render the change to tabs / contents
        $render .= '          </div>
                          </div>
                          ' . $buttons . '
                      </div>';
        return $render;
    }
}
