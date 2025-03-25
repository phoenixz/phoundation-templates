<?php

/**
 * Class TemplateDataEntryFormColumn
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Components\Forms;

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
    public function __construct(DataEntryFormColumnInterface $o_component)
    {
        parent::__construct($o_component);
    }


    public function render(): ?string
    {
        $o_definition = $this->o_component->getDefinitionObject();
        $o_component  = $this->o_component->getColumnComponent();
        $scripts      = '';

        if (!$o_definition) {
            throw new OutOfBoundsException(tr('Cannot render form component, no definition specified'));
        }

        if (!$o_component) {
            return null;
        }

        if (is_string($o_component)) {
            $render = $o_component;
            $group  = false;

        } else {
            $render =  $o_component->render();
            $group  = (($o_component instanceof BeforeAfterContentInterface) and ($o_component->hasBeforeContent() or $o_component->hasAfterContent()));

            if ($o_component->hasOuterDiv()) {
                // Get attributes and properties for the outer div
                $outer      = $o_component->getOuterDivObject();
                $class      = $outer->getClass();
                $attributes = $outer->getAttributesString();
            }
        }

        // Add scripts?
        if ($o_definition->getScripts()) {
            foreach ($o_definition->getScripts() as $o_script) {
                $scripts .= $o_script->render();
            }
        }

        if ($o_definition->getHidden()) {
            // Hidden elements don't display anything beyond the hidden <input>
            return $render . $scripts;
        }

        $this->render .= match ($o_definition->getInputType()?->value) {
            'checkbox' => '    <div class="' . Html::safe($o_definition->getSize() ? 'col-sm-' . $o_definition->getSize() : 'col') . ($o_definition->getVisible() ? '' : ' invisible') . ($o_definition->getDisplay() ? '' : ' d-none') . (isset($class) ? ' ' . $class : '') . '"' . (isset($attributes) ? ' ' . $attributes : '') . '>
                                   <div class="form-group'  . ($group ? 'input-group ' : null) . (isset($class) ? ' ' . $class : '') . '"' . (isset($attributes) ? ' ' . $attributes : '') . '>
                                       <div class="form-horizontal">
                                           <label for="' . Html::safe($o_definition->getColumn()) . '">' . Html::safe($o_definition->getLabel()) . '</label>
                                           ' . $this->renderTooltip($o_definition) . '
                                       </div>
                                       <div class="form-check">
                                           ' . $render . $scripts . '
                                           <label class="form-check-label" for="' . Html::safe($o_definition->getColumn()) . '">' . Html::safe($o_definition->getLabel()) . '</label>
                                       </div>
                                   </div>
                               </div>',

            default    => '    <div class="' . Html::safe($o_definition->getSize() ? 'col-sm-' . $o_definition->getSize() : 'col') . ($o_definition->getVisible() ? '' : ' invisible') . ($o_definition->getDisplay() ? '' : ' d-none') . (isset($class) ? ' ' . $class : '') . '"' . (isset($attributes) ? ' ' . $attributes : '') . '>
                                   <div class="form-group'  . ($group ? 'input-group ' : null) . (isset($class) ? ' ' . $class : '') . '"' . (isset($attributes) ? ' ' . $attributes : '') . '>
                                       <div class="form-horizontal">
                                           <label for="' . Html::safe($o_definition->getColumn()) . '">' . Html::safe($o_definition->getLabel()) . '</label>
                                           ' . $this->renderTooltip($o_definition) . '
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
