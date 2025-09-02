<?php

/**
 * Class TemplateInputAutoSuggest
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Components\Input;

use Phoundation\Exception\OutOfBoundsException;
use Phoundation\Utils\Arrays;
use Phoundation\Web\Html\Components\Input\InputAutoSuggest;
use Phoundation\Web\Html\Components\Script;
use Phoundation\Web\Requests\Response;


class TemplateInputAutoSuggest extends TemplateInputText
{
    /**
     * InputAutoSuggest class constructor
     */
    public function __construct(InputAutoSuggest $o_component)
    {
        $o_component->addClasses('form-control');
        parent::__construct($o_component);
    }


    /**
     * Render and return the HTML for this AutoSuggest Input Element
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $o_component = $this->o_component;

        // Auto suggest is only available when not readonly or not disabled
        if ($o_component->getReadonly() or $o_component->getDisabled()) {
            return parent::render();
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

        // This input element requires some javascript
        // TODO This should load from the correct Template library!
        Response::loadJavaScript('adminlte/plugins/jquery-ui/jquery-ui');

        if ($o_component->getPropertyBoolean('add_javascript', true)) {
            // Create JavaScript code for the component
            return Script::new()
                         ->setContent('$(\'' . $o_component->getSelector() . '\').autocomplete({
                                       source: function(request, response) {
                                         let $selected = $(\'[name="' . $o_component->getName() . '"]\');
                         
                                         $.ajax({
                                           url: "' . $o_component->getSourceUrl() . '",
                                           dataType: "jsonp",
                                           data: {
                                             term: request.term
                                             ' . $variables . '
                                           },
                                           success: function(data) {
                                             response(data.data);
                                           }
                                         });
                                       },
      ' . ($o_component->getWidth() ? 'open: function(event, ui) {
                                            $(this).autocomplete("widget").css({
                                                width: ' . $o_component->getWidth() . '
                                            });
                                       },' : '') . '
                                       delay: ' . $o_component->getDelay() . ', 
                                       minLength: ' . $o_component->getMinSuggestLength() . ',
                                       select: function(event, ui) {
                                         console.log("Selected: " + ui.item.value + " aka " + ui.item.id);
                                       }
                                     });')
                         ->render() . parent::render();
        }

        // Don't render the JavaScript part
        return parent::render();
    }
}
