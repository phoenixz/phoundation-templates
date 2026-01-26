<?php

/**
 * Class TemplateInputAutoSuggest
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Input;

use Phoundation\Exception\OutOfBoundsException;
use Phoundation\Utils\Arrays;
use Phoundation\Web\Html\Components\Input\InputAutoSuggest;
use Phoundation\Web\Html\Components\Script;


class TemplateInputAutoSuggest extends TemplateInputText
{
    /**
     * InputAutoSuggest class constructor
     */
    public function __construct(InputAutoSuggest $o_component)
    {
        $o_component->addClasses('form-outline autocomplete')
                    ->addData('', 'data-mdb-input-init');

        parent::__construct($o_component);
    }


    /**
     * Returns the suffix for this component for JavaScript selecting
     *
     * @return string|null
     */
    public static function getJavaScriptSelectorSuffix(): ?string
    {
        return '_autosuggest_div';
    }


    /**
     * Render and return the HTML for this object
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $o_component = $this->getComponentObject();

        // Auto suggest is only available when not readonly or not disabled
        if ($o_component->getReadonly() or $o_component->getDisabled()) {
            return parent::render();
        }

        // ID is required. If ID is not available, name can be used as an alternative
        if (empty($o_component->getId())) {
            if (empty($o_component->getName())) {
                throw new OutOfBoundsException(tr('Cannot render autosuggest input, it has no id nor name specified'));

            }

            // Copy ID from name
            $o_component->setId($o_component->getName());
        }

        if (empty($o_component->getName())) {
            throw new OutOfBoundsException(tr('No required HTML name attribute specified for auto suggest component'));
        }

        if (empty($o_component->getSourceUrl())) {
            throw new OutOfBoundsException(tr('No source URL specified for auto suggest component ":name"', [
                ':name' => $o_component->getName(),
            ]));
        }

        // TODO Check $variables not being used here
        if ($o_component->getVariables()) {
            $variables = $o_component->getVariables()->getSource();
            $variables = ',' . Arrays::implodeWithKeys($variables, ',' . PHP_EOL, ':');

        } else {
            $variables = null;
        }

        if ($o_component->getPropertyBoolean('add_javascript', true)) {
            return parent::render() . Script::new('const asyncAutocompletes = document.querySelectorAll(\'' . $o_component->getSelector() . '\');
                                   const asyncFilter = async (query) => {
                                     const response = await fetch(`' . $o_component->getSourceUrl() . '?term=${encodeURI(query)}`);
                                     return $.filterPhoundation(await response.json()).data;
                                   };

                                   if (asyncAutocompletes.length) {                                   
                                       asyncAutocompletes.forEach(function(asyncAutocomplete) {
                                           new mdb.Autocomplete(asyncAutocomplete, {
                                             filter: asyncFilter,
                                             displayValue: function (value) { 
                                                 if (value) {
                                                     return value.label; 
                                                 }
                                                 
                                                 return null;
                                             },
                                             noResults: "' . tr('Please start typing...') . '"
                                           });

                                           ' . $o_component->getEventHandler('onselect', 'asyncAutocomplete.addEventListener("itemSelect.mdb.autocomplete", (e) => {
                                               :SCRIPT
                                           });') . '
                                       });
                                   }');
        }

        // Do not render the JavaScript object
        return parent::render();
    }
}
