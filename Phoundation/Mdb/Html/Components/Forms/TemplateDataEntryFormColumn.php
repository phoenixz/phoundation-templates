<?php

/**
 * Class TemplateDataEntryFormColumn
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\Mdb
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
    public function __construct(ComponentInterface $_component)
    {
        parent::__construct($_component);
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
        if (!$this->_component) {
            return null;
        }

        $_definition =  $this->_component->getDefinitionObject();
        $_component  =  $this->_component->getColumnComponent();
        $scripts      =  '';

        if (!$_definition) {
            throw new OutOfBoundsException(tr('Cannot render form component, no definition specified'));
        }

        if (!$_definition->getRender()) {
            // Do not render the object!
            return null;
        }

        if (!$_component) {
            return null;
        }

        // Add marker to all labels that are obligatory
        if (!$_definition->getOptional() and !$_definition->getReadOnly() and !$_definition->getDisabled()) {
            if ($_definition->getContainsData()) {
                if ($_definition->getRender()) {
                    if ($_definition->getLabel()) {
                        $_definition->setLabel('* ' . $_definition->getLabel());
                    }

                    if ($_definition->getPlaceholder()) {
                        $_definition->setLabel('* ' . $_definition->getPlaceholder());
                    }
                }
            }
        }

        // Ensure that when d-none is added, it is only added to the div
        $d_none = ($_definition->getDisplay() ? '' : ' d-none');
        $_component->removeClass('d-none');

        if (is_string($_component)) {
            $render = $_component;
            $group  = false;

        } else {
            if ($_component instanceof InputSelectInterface) {
                if ($_definition->getElement() !== EnumElement::select) {
                    if ($_definition->getElement() !== 'select') {
                        Log::warning(ts('Encountered <select> component ":component" in data entry form ":data_entry" with element not set to EnumElement->select but to ":element" instead. This will cause rendering issues, forced $component->setElement(EnumElement->select)', [
                            ':data_entry' => $_definition->getDataEntryObject() ? get_class($_definition->getDataEntryObject()) : 'N/A',
                            ':component'  => $_definition->getColumn(),
                            ':element'    => $_component->getElement(),
                        ]), 3);
                    }

                    $_definition->setElement(EnumElement::select);
                }
            }

            $group = (($_component instanceof BeforeAfterContentInterface) and ($_component->hasBeforeContent() or $_component->hasAfterContent()));

            // TODO Fix this by generating a hasPlaceholderInterface type class Interface that is added to all controls that support placeholders. This way its one interface check to see if the method is there or not
            if (($group or ($_component instanceof InputDateRange) or ($_component instanceof InputDateTimeRange)) and !($_component instanceof InputSelectInterface) and !($_component instanceof ButtonInterface)) {
                $_component->setPlaceholder($_definition->getLabel());
                $_definition->setLabel(null);
            }

            $render = $_component->render();

            if ($_component->hasOuterDiv()) {
                // Get attributes and properties for the o_outer div
                $_outer    = $_component->getOuterDivObject();
                $class      = $_outer->getClass();
                $attributes = $_outer->getAttributesString();
            }
        }

        if ($_definition->getHidden()) {
            // Hidden elements do not display anything beyond the hidden <input>
            return $render . $scripts;
        }

        switch ($_definition->getElement()) {
            case EnumElement::select:
                if ($group) {
                    $this->render .= '<div class="' . Html::safe($_definition->getSize() ? 'col-sm-' . $_definition->getSize() : 'col') . ($_definition->getVisible() ? '' : ' invisible') . $d_none . Request::getPageObject()?->getBottomMarginString() . '">
                                          <div class="input-group">
                                            ' . $render . $scripts .
               ($_definition->hasLabel() ? ' <label class="form-label select-label" for="' . Html::safe($_definition->getColumn()) . '">
                                                  ' . Html::safe($_definition->getLabel()) . '
                                              </label>' : '') . '
                                          </div>
                                      </div>';

                } else {
                    $this->render .= '<div class="' . Html::safe($_definition->getSize() ? 'col-sm-' . $_definition->getSize() : 'col') . ($_definition->getVisible() ? '' : ' invisible') . $d_none . Request::getPageObject()?->getBottomMarginString() . '">
                                        ' . $render . $scripts .
      ($_definition->hasLabel() ?      ' <label class="form-label select-label" for="' . Html::safe($_definition->getColumn()) . '">
                                              ' . Html::safe($_definition->getLabel()) . '
                                          </label>' : '') . '
                                      </div>';
                }

                return parent::render();

            case EnumElement::textarea:
                // no break

            case EnumElement::input:
                $label    = null;
                $mdb_init = ($group ? null : ' data-mdb-input-init=""');
                $mask     = $_definition->getInputMask();
                $mask     = ($mask ? ' data-mdb-input-mask="' . $mask . '" data-mdb-input-mask-init' : null);
                break;

            default:
                $label    = null;
                $mdb_init = '';
        }

        switch ($_definition->getInputType()) {
            case EnumInputType::auto_suggest:
                $class         = ' ' . str_replace(['form-control', 'form-outline'], '', $_component->getClass()) . ' ';
                $this->render .= '  <div id="' . $_component->getId() . '_autosuggest_div" class="' . $class . Html::safe($_definition->getSize() ? 'col-sm-' . $_definition->getSize() : 'col') . ($_definition->getVisible() ? '' : ' invisible') . $d_none . Request::getPageObject()?->getBottomMarginString() . '">
                                        <div' . $mdb_init . ' class="' . ($group ? ' input-group' : 'form-outline') . $mask . (isset($class) ? ' ' . $class : '') . '"' . (isset($attributes) ? ' ' . $attributes : '') . '>
                                            ' . $render;

                if (!$group and $_definition->hasLabel()) {
                    $this->render .= '      <label class="form-label' . $label . '" for="' . Html::safe($_definition->getColumn()) . '">
                                                ' . Html::safe($_definition->getLabel()) . '
                                            </label>';
                }

                $this->render .= '      </div>
                                    </div>';
                break;

            case EnumInputType::date:
                $this->render .= '  <div class="' . Html::safe($_definition->getSize() ? 'col-sm-' . $_definition->getSize() : 'col') . ($_definition->getVisible() ? '' : ' invisible') . $d_none . Request::getPageObject()?->getBottomMarginString() . '">
                                        <div' . $mdb_init . ' id="' . $_component->getId() . '" class="' . ($group ? ' form-outline input-group' : 'form-outline') . (isset($class) ? ' ' . $class : '') . '"' . (isset($attributes) ? ' ' . $attributes : '') . $mask . ' data-mdb-input-init>
                                            ' . $render;
                if (!$group and $_definition->hasLabel()) {
                    $this->render .= '      <label class="form-label' . $label . '" for="' . Html::safe($_definition->getColumn()) . '">
                                                ' . Html::safe($_definition->getLabel()) . '
                                            </label>';
                }

                $this->render .= '      </div>
                                    </div>';

                //            ' . $this->renderTooltip($_definition) . '
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
                $this->render .= '  <div class="' . Html::safe($_definition->getSize() ? 'col-sm-' . $_definition->getSize() : 'col') . ($_definition->getVisible() ? '' : ' invisible') . $d_none . Request::getPageObject()?->getBottomMarginString() . '">
                                        <div class="' . ($_definition->getReadonly() ? 'readonly ' : null) . ($_definition->getDisabled() ? 'disabled ' : null) . ($group ? 'input-group ' : 'form-outline ') . (isset($class) ? $class . ' ' : '') . '"' . ($attributes ?? '') . '>
                                            ' . $render;
                if (!$group and $_definition->hasLabel()) {
                    $this->render .= '      <label class="form-label' . $label . '" for="' . Html::safe($_definition->getColumn()) . '">
                                                ' . Html::safe($_definition->getLabel()) . '
                                            </label>';
                }

                $this->render .= '      </div>
                                    </div>';

                break;

            default:
                $this->render .= '  <div class="' . Html::safe($_definition->getSize() ? 'col-sm-' . $_definition->getSize() : 'col') . ($_definition->getVisible() ? '' : ' invisible') . $d_none . Request::getPageObject()?->getBottomMarginString() . '">
                                        <div' . $mdb_init . ' class="' . ($_definition->getReadonly() ? 'readonly ' : null) . ($_definition->getDisabled() ? 'disabled ' : null) . ($group ? 'input-group ' : 'form-outline ') . (isset($class) ? $class . ' ' : '') . '"' . ($attributes ?? '') . '>
                                            ' . $render;
                if (!$group and $_definition->hasLabel()) {
                    $this->render .= '      <label class="form-label' . $label . '" for="' . Html::safe($_definition->getColumn()) . '">
                                                ' . Html::safe($_definition->getLabel()) . '
                                            </label>';
                }

                $this->render .= '      </div>
                                    </div>';
            //            ' . $this->renderTooltip($_definition) . '
        };

        return parent::render();
    }


    /**
     * Renders and returns the tooltip for the specified definition
     *
     * @param DefinitionInterface $_definition
     * @return string|null
     */
    protected function renderTooltip(DefinitionInterface $_definition): ?string
    {
        if ($_definition->getTooltip()) {
            // Render and return the tooltip
            return Tooltip::new()
                          ->setTitle($_definition->getTooltip())
                          ->setUseIcon(true)
                          ->render();
        }

        return null;
    }
}
