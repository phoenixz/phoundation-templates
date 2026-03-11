<?php

/**
 * Class TemplateDataEntryFormColumn
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\AdminLteV3
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV3\Html\Components\Forms;

use Phoundation\Data\DataEntries\Definitions\Interfaces\DefinitionInterface;
use Phoundation\Exception\OutOfBoundsException;
use Phoundation\Web\Html\Components\Forms\Interfaces\DataEntryFormColumnInterface;
use Phoundation\Web\Html\Components\Input\Interfaces\BeforeAfterContentInterface;
use Phoundation\Web\Html\Components\Widgets\Tooltips\Tooltip;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateDataEntryFormColumn extends TemplateRenderer
{
    /**
     * FilterForm class constructor
     */
    public function __construct(DataEntryFormColumnInterface $_component)
    {
        parent::__construct($_component);
    }


    public function render(): ?string
    {
        $_definition = $this->_component->getDefinitionObject();
        $_component  = $this->_component->getColumnComponent();
        $scripts      = '';

        if (!$_definition) {
            throw new OutOfBoundsException(tr('Cannot render form component, no definition specified'));
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

        if (is_string($_component)) {
            $render = $_component;
            $group  = false;

        } else {
            $render =  $_component->render();
            $group  = (($_component instanceof BeforeAfterContentInterface) and ($_component->hasBeforeContent() or $_component->hasAfterContent()));

            if ($_component->hasOuterDiv()) {
                // Get attributes and properties for the outer div
                $outer      = $_component->getOuterDivObject();
                $class      = $outer->getClass();
                $attributes = $outer->getAttributesString();
            }
        }

        if ($_definition->getHidden()) {
            // Hidden elements do not display anything beyond the hidden <input>
            return $render . $scripts;
        }

        $this->render .= match ($_definition->getInputType()?->value) {
            'checkbox' => '    <div class="' . Html::safe($_definition->getSize() ? 'col-sm-' . $_definition->getSize() : 'col') . ($_definition->getVisible() ? '' : ' invisible') . ($_definition->getDisplay() ? '' : ' d-none') . (isset($class) ? ' ' . $class : '') . '"' . (isset($attributes) ? ' ' . $attributes : '') . '>
                                   <div class="form-group'  . ($group ? 'input-group ' : null) . (isset($class) ? ' ' . $class : '') . '"' . (isset($attributes) ? ' ' . $attributes : '') . '>
                                       <div class="form-horizontal">
                                           <label for="' . Html::safe($_definition->getColumn()) . '">' . Html::safe($_definition->getLabel()) . '</label>
                                           ' . $this->renderTooltip($_definition) . '
                                       </div>
                                       <div class="form-check">
                                           ' . $render . $scripts . '
                                           <label class="form-check-label" for="' . Html::safe($_definition->getColumn()) . '">' . Html::safe($_definition->getLabel()) . '</label>
                                       </div>
                                   </div>
                               </div>',

            default    => '    <div class="' . Html::safe($_definition->getSize() ? 'col-sm-' . $_definition->getSize() : 'col') . ($_definition->getVisible() ? '' : ' invisible') . ($_definition->getDisplay() ? '' : ' d-none') . (isset($class) ? ' ' . $class : '') . '"' . (isset($attributes) ? ' ' . $attributes : '') . '>
                                   <div class="form-group'  . ($group ? 'input-group ' : null) . (isset($class) ? ' ' . $class : '') . '"' . (isset($attributes) ? ' ' . $attributes : '') . '>
                                       <div class="form-horizontal">
                                           <label for="' . Html::safe($_definition->getColumn()) . '">' . Html::safe($_definition->getLabel()) . '</label>
                                           ' . $this->renderTooltip($_definition) . '
                                       </div>
                                       ' . $render . $scripts . '
                                   </div>
                                </div>',
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
