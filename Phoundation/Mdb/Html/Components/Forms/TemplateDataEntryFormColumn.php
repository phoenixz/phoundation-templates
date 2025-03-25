<?php

/**
 * Class DataEntryForm
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Forms;

use Phoundation\Core\Log\Log;
use Phoundation\Data\DataEntries\Definitions\Interfaces\DefinitionInterface;
use Phoundation\Exception\OutOfBoundsException;
use Phoundation\Web\Html\Components\Input\Interfaces\BeforeAfterContentInterface;
use Phoundation\Web\Html\Components\Input\Interfaces\InputSelectInterface;
use Phoundation\Web\Html\Components\Interfaces\ComponentInterface;
use Phoundation\Web\Html\Components\Widgets\Tooltips\Tooltip;
use Phoundation\Web\Html\Enums\EnumElement;
use Phoundation\Web\Html\Enums\EnumInputType;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Templates\Phoundation\Mdb\TemplatePage;


class TemplateDataEntryFormColumn extends TemplateRenderer
{
    /**
     * FilterForm class constructor
     */
    public function __construct(ComponentInterface $o_component)
    {
        parent::__construct($o_component);
    }


    /**
     * Render the DataEntry Form Column
     *
     * @note $this->component is a DataEntryFormColumn object here, the component to render is inside there and can be
     *       accessed with $this->component->getColumnComponent() where (again) $this->component is actually the column,
     *       not the component itself.
     *
     * @return string|null
     */
    public function render(): ?string
    {
        if (!$this->o_component) {
            return null;
        }

        $o_definition =  $this->o_component->getDefinitionObject();
        $o_component  =  $this->o_component->getColumnComponent();
        $scripts      =  '';

        if (!$o_definition) {
            throw new OutOfBoundsException(tr('Cannot render form component, no definition specified'));
        }

        if (!$o_definition->getRender()) {
            // Don't render the object!
            return null;
        }

        if (!$o_component) {
            return null;
        }

        // Ensure that when d-none is added, it is only added to the div
        $d_none = ($o_definition->getDisplay() ? '' : ' d-none');
        $o_component->removeClass('d-none');

        if (is_string($o_component)) {
            $render = $o_component;
            $group  = false;

        } else {
            if ($o_component instanceof InputSelectInterface) {
                if ($o_definition->getElement() !== EnumElement::select) {
                    if ($o_definition->getElement() !== 'select') {
                        Log::warning(ts('Encountered <select> component ":component" in data entry form ":data_entry" with element not set to EnumElement->select but to ":element" instead. This will cause rendering issues, forced $component->setElement(EnumElement->select)', [
                            ':data_entry' => get_class($o_definition->getDataEntryObject()),
                            ':component'  => $o_definition->getColumn(),
                            ':element'    => $o_component->getElement(),
                        ]));
                    }

                    $o_definition->setElement(EnumElement::select);
                }
            }

            $group = (($o_component instanceof BeforeAfterContentInterface) and ($o_component->hasBeforeContent() or $o_component->hasAfterContent()));

            if ($group) {
                $o_component->setPlaceholder($o_definition->getLabel());
                $o_definition->setLabel(null);
            }

            $render = $o_component->render();

            if ($o_component->hasOuterDiv()) {
                // Get attributes and properties for the o_outer div
                $o_outer    = $o_component->getOuterDivObject();
                $class      = $o_outer->getClass();
                $attributes = $o_outer->getAttributesString();
            }
        }

        if ($o_definition->getHidden()) {
            // Hidden elements don't display anything beyond the hidden <input>
            return $render . $scripts;
        }

        switch ($o_definition->getElement()) {
            case EnumElement::select:
                if ($group) {
                    $this->render .= '<div class="' . TemplatePage::getBottomMarginString() . Html::safe($o_definition->getSize() ? 'col-sm-' . $o_definition->getSize() : 'col') . ($o_definition->getVisible() ? '' : ' invisible') . $d_none . '">
                                          <div class="input-group">
                                            ' . $render . $scripts .
               ($o_definition->getLabel() ? ' <label class="form-label select-label" for="' . Html::safe($o_definition->getColumn()) . '">
                                                  ' . Html::safe($o_definition->getLabel()) . '
                                              </label>' : '') . '
                                          </div>
                                      </div>';

                } else {
                    $this->render .= '<div class="' . TemplatePage::getBottomMarginString() . Html::safe($o_definition->getSize() ? 'col-sm-' . $o_definition->getSize() : 'col') . ($o_definition->getVisible() ? '' : ' invisible') . $d_none . '">
                                        ' . $render . $scripts .
           ($o_definition->getLabel() ? ' <label class="form-label select-label" for="' . Html::safe($o_definition->getColumn()) . '">
                                              ' . Html::safe($o_definition->getLabel()) . '
                                          </label>' : '') . '
                                      </div>';
                }

                return parent::render();

            case EnumElement::textarea:
                // no break

            case EnumElement::input:
                $label    = null;
                $mdb_init = ($group ? null : ' data-mdb-input-init=""');
                break;

            default:
                $label    = null;
                $mdb_init = '';
        }

        switch ($o_definition->getInputType()) {
            case EnumInputType::auto_suggest:
                $class         = ' ' . str_replace(['form-control', 'form-outline'], '', $o_component->getClass()) . ' ';
                $this->render .= '  <div id="' . $o_component->getId() . '_autosuggest_div" class="' . TemplatePage::getBottomMarginString() . $class . Html::safe($o_definition->getSize() ? 'col-sm-' . $o_definition->getSize() : 'col') . ($o_definition->getVisible() ? '' : ' invisible') . $d_none . '">
                                        <div' . $mdb_init . ' class="' . ($group ? ' input-group' : 'form-outline') . (isset($class) ? ' ' . $class : '') . '"' . (isset($attributes) ? ' ' . $attributes : '') . '>
                                            ' . $render;

                if (!$group) {
                    $this->render .= '      <label class="form-label' . $label . '" for="' . Html::safe($o_definition->getColumn()) . '">
                                                ' . Html::safe($o_definition->getLabel()) . '
                                            </label>';
                }

                $this->render .= '      </div>
                                    </div>';
                break;

            default:
                $this->render .= '  <div class="' . TemplatePage::getBottomMarginString() . Html::safe($o_definition->getSize() ? 'col-sm-' . $o_definition->getSize() : 'col') . ($o_definition->getVisible() ? '' : ' invisible') . $d_none . '">
                                        <div' . $mdb_init . ' class="' . ($group ? ' input-group' : 'form-outline') . (isset($class) ? ' ' . $class : '') . '"' . (isset($attributes) ? ' ' . $attributes : '') . '>
                                            ' . $render;
                if (!$group) {
                    $this->render .= '      <label class="form-label' . $label . '" for="' . Html::safe($o_definition->getColumn()) . '">
                                                ' . Html::safe($o_definition->getLabel()) . '
                                            </label>';
                }

                $this->render .= '      </div>
                                    </div>';
            //            ' . $this->renderTooltip($definition) . '
        };

        return parent::render();
    }


    /**
     * Renders and returns the tooltip for the specified definition
     *
     * @param DefinitionInterface $definition
     * @return string|null
     */
    protected function renderTooltip(DefinitionInterface $definition): ?string
    {
        if ($definition->getTooltip()) {
            // Render and return the tooltip
            return Tooltip::new()
                          ->setTitle($definition->getTooltip())
                          ->setUseIcon(true)
                          ->render();
        }

        return null;
    }
}
