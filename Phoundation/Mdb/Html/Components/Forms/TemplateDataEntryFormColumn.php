<?php

/**
 * Class TemplateDataEntryFormColumn
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Forms;

use Phoundation\Core\Log\Log;
use Phoundation\Data\DataEntries\Definitions\Interfaces\DefinitionInterface;
use Phoundation\Exception\OutOfBoundsException;
use Phoundation\Web\Html\Components\Input\Buttons\Interfaces\ButtonInterface;
use Phoundation\Web\Html\Components\Input\InputDateRange;
use Phoundation\Web\Html\Components\Input\InputDateTimeRange;
use Phoundation\Web\Html\Components\Input\Interfaces\BeforeAfterContentInterface;
use Phoundation\Web\Html\Components\Input\Interfaces\InputSelectInterface;
use Phoundation\Web\Html\Components\Interfaces\ComponentInterface;
use Phoundation\Web\Html\Components\Widgets\Tooltips\Tooltip;
use Phoundation\Web\Html\Enums\EnumElement;
use Phoundation\Web\Html\Enums\EnumInputType;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Requests\Request;


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

        // Add marker to all labels that are obligatory
        if (!$o_definition->getOptional() and !$o_definition->getReadOnly() and !$o_definition->getDisabled()) {
            if ($o_definition->getContainsData()) {
                if ($o_definition->getRender()) {
                    if ($o_definition->getLabel()) {
                        $o_definition->setLabel('* ' . $o_definition->getLabel());
                    }

                    if ($o_definition->getPlaceholder()) {
                        $o_definition->setLabel('* ' . $o_definition->getPlaceholder());
                    }
                }
            }
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
                            ':data_entry' => $o_definition->getDataEntryObject() ? get_class($o_definition->getDataEntryObject()) : 'N/A',
                            ':component'  => $o_definition->getColumn(),
                            ':element'    => $o_component->getElement(),
                        ]), 3);
                    }

                    $o_definition->setElement(EnumElement::select);
                }
            }

            $group = (($o_component instanceof BeforeAfterContentInterface) and ($o_component->hasBeforeContent() or $o_component->hasAfterContent()));

            // TODO Fix this by generating a hasPlaceholderInterface type class Interface that is added to all controls that support placeholders. This way its one interface check to see if the method is there or not
            if (($group or ($o_component instanceof InputDateRange) or ($o_component instanceof InputDateTimeRange)) and !($o_component instanceof InputSelectInterface) and !($o_component instanceof ButtonInterface)) {
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
                    $this->render .= '<div class="' . Html::safe($o_definition->getSize() ? 'col-sm-' . $o_definition->getSize() : 'col') . ($o_definition->getVisible() ? '' : ' invisible') . $d_none . Request::getPageObject()?->getBottomMarginString() . '">
                                          <div class="input-group">
                                            ' . $render . $scripts .
               ($o_definition->hasLabel() ? ' <label class="form-label select-label" for="' . Html::safe($o_definition->getColumn()) . '">
                                                  ' . Html::safe($o_definition->getLabel()) . '
                                              </label>' : '') . '
                                          </div>
                                      </div>';

                } else {
                    $this->render .= '<div class="' . Html::safe($o_definition->getSize() ? 'col-sm-' . $o_definition->getSize() : 'col') . ($o_definition->getVisible() ? '' : ' invisible') . $d_none . Request::getPageObject()?->getBottomMarginString() . '">
                                        ' . $render . $scripts .
      ($o_definition->hasLabel() ?      ' <label class="form-label select-label" for="' . Html::safe($o_definition->getColumn()) . '">
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
                $mask     = $o_definition->getInputMask();
                $mask     = ($mask ? ' data-mdb-input-mask="' . $mask . '" data-mdb-input-mask-init' : null);
                break;

            default:
                $label    = null;
                $mdb_init = '';
        }

        switch ($o_definition->getInputType()) {
            case EnumInputType::auto_suggest:
                $class         = ' ' . str_replace(['form-control', 'form-outline'], '', $o_component->getClass()) . ' ';
                $this->render .= '  <div id="' . $o_component->getId() . '_autosuggest_div" class="' . $class . Html::safe($o_definition->getSize() ? 'col-sm-' . $o_definition->getSize() : 'col') . ($o_definition->getVisible() ? '' : ' invisible') . $d_none . Request::getPageObject()?->getBottomMarginString() . '">
                                        <div' . $mdb_init . ' class="' . ($group ? ' input-group' : 'form-outline') . $mask . (isset($class) ? ' ' . $class : '') . '"' . (isset($attributes) ? ' ' . $attributes : '') . '>
                                            ' . $render;

                if (!$group and $o_definition->hasLabel()) {
                    $this->render .= '      <label class="form-label' . $label . '" for="' . Html::safe($o_definition->getColumn()) . '">
                                                ' . Html::safe($o_definition->getLabel()) . '
                                            </label>';
                }

                $this->render .= '      </div>
                                    </div>';
                break;

            case EnumInputType::date:
                $this->render .= '  <div class="' . Html::safe($o_definition->getSize() ? 'col-sm-' . $o_definition->getSize() : 'col') . ($o_definition->getVisible() ? '' : ' invisible') . $d_none . Request::getPageObject()?->getBottomMarginString() . '">
                                        <div' . $mdb_init . ' id="' . $o_component->getId() . '" class="' . ($group ? ' form-outline input-group' : 'form-outline') . (isset($class) ? ' ' . $class : '') . '"' . (isset($attributes) ? ' ' . $attributes : '') . $mask . ' data-mdb-input-init>
                                            ' . $render;
                if (!$group and $o_definition->hasLabel()) {
                    $this->render .= '      <label class="form-label' . $label . '" for="' . Html::safe($o_definition->getColumn()) . '">
                                                ' . Html::safe($o_definition->getLabel()) . '
                                            </label>';
                }

                $this->render .= '      </div>
                                    </div>';

                //            ' . $this->renderTooltip($o_definition) . '
                break;

            case EnumInputType::button:
                // no break;

            case EnumInputType::submit:
                // no break;

            case EnumInputType::reset:
                // no break;

            case EnumInputType::create_button:
                // no break;

            case EnumInputType::save_button:
                // no break;

            case EnumInputType::back_button:
                // no break;

            case EnumInputType::audit_button:
                // no break;

            case EnumInputType::lock_button:
                // no break;

            case EnumInputType::unlock_button:
                // no break;

            case EnumInputType::delete_button:
                // no break;

            case EnumInputType::undelete_button:
                $this->render .= '  <div class="' . Html::safe($o_definition->getSize() ? 'col-sm-' . $o_definition->getSize() : 'col') . ($o_definition->getVisible() ? '' : ' invisible') . $d_none . Request::getPageObject()?->getBottomMarginString() . '">
                                        <div class="' . ($o_definition->getReadonly() ? 'readonly ' : null) . ($o_definition->getDisabled() ? 'disabled ' : null) . ($group ? 'input-group ' : 'form-outline ') . (isset($class) ? $class . ' ' : '') . '"' . ($attributes ?? '') . '>
                                            ' . $render;
                if (!$group and $o_definition->hasLabel()) {
                    $this->render .= '      <label class="form-label' . $label . '" for="' . Html::safe($o_definition->getColumn()) . '">
                                                ' . Html::safe($o_definition->getLabel()) . '
                                            </label>';
                }

                $this->render .= '      </div>
                                    </div>';

                break;

            default:
                $this->render .= '  <div class="' . Html::safe($o_definition->getSize() ? 'col-sm-' . $o_definition->getSize() : 'col') . ($o_definition->getVisible() ? '' : ' invisible') . $d_none . Request::getPageObject()?->getBottomMarginString() . '">
                                        <div' . $mdb_init . ' class="' . ($o_definition->getReadonly() ? 'readonly ' : null) . ($o_definition->getDisabled() ? 'disabled ' : null) . ($group ? 'input-group ' : 'form-outline ') . (isset($class) ? $class . ' ' : '') . '"' . ($attributes ?? '') . '>
                                            ' . $render;
                if (!$group and $o_definition->hasLabel()) {
                    $this->render .= '      <label class="form-label' . $label . '" for="' . Html::safe($o_definition->getColumn()) . '">
                                                ' . Html::safe($o_definition->getLabel()) . '
                                            </label>';
                }

                $this->render .= '      </div>
                                    </div>';
            //            ' . $this->renderTooltip($o_definition) . '
        };

        return parent::render();
    }


    /**
     * Renders and returns the tooltip for the specified definition
     *
     * @param DefinitionInterface $o_definition
     * @return string|null
     */
    protected function renderTooltip(DefinitionInterface $o_definition): ?string
    {
        if ($o_definition->getTooltip()) {
            // Render and return the tooltip
            return Tooltip::new()
                          ->setTitle($o_definition->getTooltip())
                          ->setUseIcon(true)
                          ->render();
        }

        return null;
    }
}
