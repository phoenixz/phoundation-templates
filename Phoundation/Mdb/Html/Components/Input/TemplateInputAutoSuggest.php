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
        $component = $this->getComponentObject();

        if (empty($component->getId())) {
            if (empty($component->getName())) {
                throw new OutOfBoundsException(tr('Cannot render autosuggest input, it has no id nor name specified'));
            }

            // Copy name from ID
            $component->setId($component->getName());
        }

        // Auto suggest is only available when not readonly or not disabled
        if ($component->getReadonly() or $component->getDisabled()) {
            return parent::render();
        }

        if (empty($component->getName())) {
            throw new OutOfBoundsException(tr('No required HTML name attribute specified for auto suggest component'));
        }

        if (empty($component->getSourceUrl())) {
            throw new OutOfBoundsException(tr('No source URL specified for auto suggest component ":name"', [
                ':name' => $component->getName(),
            ]));
        }

        if ($component->getVariables()) {
            $variables = $component->getVariables()->getSource();
            $variables = ',' . Arrays::implodeWithKeys($variables, ',' . PHP_EOL, ':');

        } else {
            $variables = null;
        }

        // Create JavaScript code for the component
        return Script::new()
                     ->setContent('const asyncAutocomplete = document.querySelector(\'[id="' . $component->getId() . '-div"]\');
                                   const asyncFilter = async (query) => {
                                     const response = await fetch(`' . $component->getSourceUrl() . '?term=${encodeURI(query)}`);
                                     const data = await response.json();
                                     return data.data;
                                   };
                                   
                                   new mdb.Autocomplete(asyncAutocomplete, {
                                     filter: asyncFilter,
                                     displayValue: (value) => value.label
                                   });')
                     ->render() . parent::render();
    }
}
