<?php

/**
 * Class TemplateCard
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Widgets\Cards;

use Phoundation\Web\Html\Components\Anchor;
use Phoundation\Web\Html\Components\Widgets\Cards\Card;
use Phoundation\Web\Html\Enums\EnumOrientation;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateCard extends TemplateRenderer
{
    /**
     * Card class constructor
     */
    public function __construct(Card $_component)
    {
        parent::__construct($_component);
    }


    /**
     * @inheritDoc
     */
    public function render(): ?string
    {
        $_component = $this->_component;
        $tabs        = $_component->getTabsObject(false);

        if ($tabs and ($tabs->getOrientation() === EnumOrientation::top)) {
            $this->render = '   <div' . ($this->_component->getId() ? ' id="' . $this->_component->getId() . '"' : '') . ' class="card ' . ($this->_component->getClass() ? $this->_component->getClass() . ' ' : null) . ($this->_component->getGradient() ? 'gradient-' . Html::safe($this->_component->getGradient()) : '') . ($this->_component->getMode()->value ? 'card-' . Html::safe($this->_component->getMode()->value) : '') . ($this->_component->getOutline() ? ' card-outline' : '') . ($this->_component->getBackground() ? 'bg-' . Html::safe($this->_component->getBackground()) : '') . ' card-tabs">
                                    <div class="card-header p-0 p-1 border-bottom-0"> 
                                        <ul class="nav nav-tabs" id="" role="tablist">';

            if ($this->_component->getTitle()) {
                $this->render .= '          <li class="pt-2 px-3"><' . $this->_component->getHeaderTitleTag() . ' class="card-title">' . $this->_component->getTitle() . '</' . $this->_component->getHeaderTitleTag() . '></li>';
            }

            if ($this->_component->getHeaderContent()) {
                $this->render .= $this->_component->getHeaderContent();
            }

            // Render tabs
            $active = true;

            foreach ($tabs as $tab) {
                $this->render .= '          <li class="nav-item">
                                                ' . Anchor::new('#' . $tab->getId())
                                                          ->setId($tab->getId() . '-tab')
                                                          ->setRole('tab')
                                                          ->setClass('nav-link' . ($active ? ' active' : ''))
                                                          ->setContent($tab->getLabel())
                                                          ->addData('pill', 'toggle')
                                                          ->addAria($tab->getId(), 'controls')
                                                          ->addAria(($active ? 'true' : 'false'), 'selected') . '
                                            </li>';

                if ($active) {
                    $this->render .= $this->_component->getHeaderContent();
                }

                $active = false;
            }

            // Render transition tabs to tab contents
            $this->render .= '          </ul>
                                    </div>
                                    <div class="card-body' . ($_component->getCenter() ? ' text-center' : null) . '">
                                        <div class="tab-content">';

            // Render tab contents
            $active = true;

            foreach ($tabs as $tab) {
                $this->render .= '          <div class="tab-pane fade' . ($active ? ' active show' : '') . '" id="' . $tab->getId() . '" role="tabpanel" aria-labelledby="' . $tab->getId() . '-tab">
                                                ' . $tab->getContent() . '
                                            </div>';
                $active = false;
            }

            // Finish tab contents
            $this->render .= '          </div>
                                    </div>
                                </div>';

        } else {
            $this->render = '   <div' . ($this->_component->getId() ? ' id="' . $this->_component->getId() . '"' : '') . ' class="card ' . ($this->_component->getClass() ? $this->_component->getClass() . ' ' : null) . ($this->_component->getGradient() ? 'gradient-' . Html::safe($this->_component->getGradient()) : '') . ($this->_component->getMode()->value ? 'card-' . Html::safe($this->_component->getMode()->value) : '') . ($this->_component->getOutline() ? ' card-outline' : '') . ($this->_component->getBackground() ? 'bg-' . Html::safe($this->_component->getBackground()) : '') . '">';

            if ($this->_component->getReloadSwitch() or $this->_component->getMaximizeSwitch() or $this->_component->getCollapseSwitch() or $this->_component->getCloseSwitch() or $this->_component->getTitle() or $this->_component->getHeaderContent()) {
                $this->render .= '  <div class="card-header">
                                        <' . $this->_component->getHeaderTitleTag() . ' class="card-title">' . $this->_component->getTitle() . '</' . $this->_component->getHeaderTitleTag() . '>
                                         ' . $this->_component->getHeaderContent() . '
                                        <div class="card-tools">
                                            ' . ($this->_component->getReloadSwitch() ? '   <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="widgets.html" data-source-selector="#card-refresh-content" data-load-on-init="false">
                                                                                                 <i class="fas fa-sync-alt"></i>
                                                                                             </button>' : '') . '
                                            ' . ($this->_component->getMaximizeSwitch() ? ' <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                                                                                 <i class="fas fa-expand"></i>
                                                                                             </button>' : '') . '
                                            ' . ($this->_component->getCollapseSwitch() ? ' <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                                                                 <i class="fas fa-' . ($this->_component->getCollapsed() ? 'plus' : 'minus') . '"></i>
                                                                                             </button>' : '') . '
                                            ' . ($this->_component->getCloseSwitch() ? '    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                                                                 <i class="fas fa-times"></i>
                                                                                             </button>' : '') . '                              
                                        </div>
                                    </div>';
            }

            $description   = $this->_component->getDescription();
            $this->render .= '      <!-- /.card-header -->
                                    <div class="card-body' . ($_component->getCenter() ? ' text-center' : null) . '">
                                        ' . ($description ? '<p class="card-description">' . $description . '</p>' : null) . '                                    
                                        ' . $this->_component->getContent() . '
                                    </div>';

            if ($this->_component->getButtonsObject() or $this->_component->getFooterContent()) {
                $this->render .= '  <div class="card-footer">
                                        ' . $this->_component->getFooterContent()
                                         . $this->_component->getButtonsObject()->render() . '           
                                    </div>';
            }

            $this->render .= '  </div>';
        }

        return parent::render();
    }
}
