<?php

/**
 * Class TemplateCard
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Components\Widgets\Cards;

use Phoundation\Web\Html\Components\Widgets\Cards\Card;
use Phoundation\Web\Html\Enums\EnumOrientation;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;

class TemplateCard extends TemplateRenderer
{
    /**
     * Card class constructor
     */
    public function __construct(Card $o_component)
    {
        parent::__construct($o_component);
    }


    /**
     * @inheritDoc
     */
    public function render(): ?string
    {
        $o_component = $this->o_component;
        $tabs        = $o_component->getTabsObject(false);

        if ($tabs) {
            // Build a card with tabs
            if ($tabs->getOrientation() === EnumOrientation::top) {
                $this->render = '   <div' . ($this->o_component->getId() ? ' id="' . $this->o_component->getId() . '"' : '') . ' class="card ' . ($this->o_component->getClass() ? $this->o_component->getClass() . ' ' : null) . ($this->o_component->getGradient() ? 'gradient-' . Html::safe($this->o_component->getGradient()) : '') . ($this->o_component->getMode()->value ? 'card-' . Html::safe($this->o_component->getMode()->value) : '') . ($this->o_component->getOutline() ? ' card-outline' : '') . ($this->o_component->getBackground() ? 'bg-' . Html::safe($this->o_component->getBackground()) : '') . ' card-tabs">
                                        <div class="card-header p-0 p-1 border-bottom-0">
                                            <ul class="nav nav-tabs" id="" role="tablist">';

                if ($this->o_component->getTitle()) {
                    $this->render .= '          <li class="pt-2 px-3"><' . $this->o_component->getHeaderTitleTag() . ' class="card-title">' . $this->o_component->getTitle() . '</' . $this->o_component->getHeaderTitleTag() . '></li>';
                }

                // Render tabs
                $active = true;

                foreach ($tabs as $tab) {
                    if ($active) {
                        $this->render .= $this->o_component->getHeaderContent();
                    }

                    $this->render .= '          <li class="nav-item">
                                                    <a class="nav-link' . ($active ? ' active' : '') . '" id="' . $tab->getId() . '-tab" data-toggle="pill" href="#' . $tab->getId() . '" role="tab" aria-controls="' . $tab->getId() . '" aria-selected="' . ($active ? 'true' : 'false') . '">' . $tab->getLabel() . '</a>
                                                </li>';
                    $active       = false;
                }

                // Render transition tabs to tab contents
                $this->render .= '          </ul>
                                        </div>
                                        <div class="card-body' . ($o_component->getCenter() ? ' text-center' : null) . '">
                                            <div class="tab-content">';

                // Render tab contents
                $active = true;

                foreach ($tabs as $tab) {
                    $this->render .= '          <div class="tab-pane fade' . ($active ? ' active show' : '') . '" id="' . $tab->getId() . '" role="tabpanel" aria-labelledby="' . $tab->getId() . '-tab">
                                                    ' . $tab->getContent() . '
                                                </div>';
                    $active       = false;
                }

                // Finish tab contents
                $this->render .= '          </div>
                                        </div>
                                    </div>';
            }

        } else {
            $this->render = '   <div' . ($this->o_component->getId() ? ' id="' . $this->o_component->getId() . '"' : '') . ' class="card ' . ($this->o_component->getClass() ? $this->o_component->getClass() . ' ' : null) . ($this->o_component->getGradient() ? 'gradient-' . Html::safe($this->o_component->getGradient()) : '') . ($this->o_component->getMode()->value ? 'card-' . Html::safe($this->o_component->getMode()->value) : '') . ($this->o_component->getOutline() ? ' card-outline' : '') . ($this->o_component->getBackground() ? 'bg-' . Html::safe($this->o_component->getBackground()) : '') . '">';

            if ($this->o_component->getReloadSwitch() or $this->o_component->getMaximizeSwitch() or $this->o_component->getCollapseSwitch() or $this->o_component->getCloseSwitch() or $this->o_component->getTitle() or $this->o_component->getHeaderContent()) {
                $this->render .= '  <div class="card-header">
                                        <' . $this->o_component->getHeaderTitleTag() . ' class="card-title">' . $this->o_component->getTitle() . '</' . $this->o_component->getHeaderTitleTag() . '>
                                        <div class="card-tools">
                                            ' . $this->o_component->getHeaderContent() . '
                                            ' . ($this->o_component->getReloadSwitch() ? '   <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="widgets.html" data-source-selector="#card-refresh-content" data-load-on-init="false">
                                                                                                 <i class="fas fa-sync-alt"></i>
                                                                                               </button>' : '') . '
                                            ' . ($this->o_component->getMaximizeSwitch() ? ' <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                                                                                 <i class="fas fa-expand"></i>
                                                                                               </button>' : '') . '
                                            ' . ($this->o_component->getCollapseSwitch() ? ' <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                                                                 <i class="fas fa-' . ($this->o_component->getCollapsed() ? 'plus' : 'minus') . '"></i>
                                                                                               </button>' : '') . '
                                            ' . ($this->o_component->getCloseSwitch() ? '    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                                                                 <i class="fas fa-times"></i>
                                                                                               </button>' : '') . '                              
                                        </div>
                                    </div>';
            }

            $description   = $this->o_component->getDescription();
            $this->render .= '      <!-- /.card-header -->
                                    <div class="card-body' . ($o_component->getCenter() ? ' text-center' : null) . '">
                                        ' . ($description ? '<p class="card-description">' . $description . '</p>' : null) . '                                    
                                        ' . $this->o_component->getContent() . '
                                    </div>';

            if ($this->o_component->getButtons() or $this->o_component->getFooterContent()) {
                $this->render .= '  <div class="card-footer">
                                        ' . $this->o_component->getFooterContent()
                                          . $this->o_component->getButtons()->render() . '     
                                    </div>';
            }

            $this->render .= '  </div>';
        }

        return parent::render();
    }
}
