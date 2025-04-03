<?php

/**
 * Class TemplateInputAutoSuggest
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
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
                    ->addData(null, 'data-mdb-input-init');

        parent::__construct($o_component);
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
                                     const data = await response.json();
                                     return data.data;
                                   };
                                   
                                   if (asyncAutocompletes.length) {                                   
                                       asyncAutocompletes.forEach(function(asyncAutocomplete) {
                                           new mdb.Autocomplete(asyncAutocomplete, {
                                             filter: asyncFilter,
                                             displayValue: (value) => value.label
                                           });
                                       });
                                   }');
        }

        // Don't render the JavaScript object
        return parent::render();
    }
}
