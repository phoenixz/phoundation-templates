<?php

/**
 * Class TemplateInputAutoSuggest
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\AdminLteV3
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV3\Html\Components\Input;

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
    public function __construct(InputAutoSuggest $_component)
    {
        $_component->addClasses('form-control');
        parent::__construct($_component);
    }


    /**
     * Render and return the HTML for this AutoSuggest Input Element
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $_component = $this->_component;

        // Auto suggest is only available when not readonly or not disabled
        if ($_component->getReadonly() or $_component->getDisabled()) {
            return parent::render();
        }

        if (empty($_component->getName())) {
            throw new OutOfBoundsException(tr('No required HTML name attribute specified for auto suggest component'));
        }

        if (empty($_component->getSourceUrl())) {
            throw new OutOfBoundsException(tr('No source URL specified for auto suggest component ":name"', [
                ':name' => $_component->getName(),
            ]));
        }

        if ($_component->getVariables()) {
            $variables = $_component->getVariables()->getSource();
            $variables = ',' . Arrays::implodeWithKeys($variables, ',' . PHP_EOL, ':');

        } else {
            $variables = null;
        }

        // This input element requires some javascript
        // TODO This should load from the correct Template library!
        Response::loadJavaScript('adminltev3/plugins/jquery-ui/jquery-ui');

        if ($_component->getPropertyBoolean('add_javascript', true)) {
            // Create JavaScript code for the component
            return Script::new()
                         ->setContent('$(\'' . $_component->getSelector() . '\').autocomplete({
                                       source: function(request, response) {
                                         let $selected = $(\'[name="' . $_component->getName() . '"]\');
                         
                                         $.ajax({
                                           url: "' . $_component->getSourceUrl() . '",
                                           dataType: "jsonp",
                                           data: {
                                             term: request.term
                                             ' . $variables . '
                                           },
                                           success: function(data) {
                                             response(data);
                                           }
                                         });
                                       },
      ' . ($_component->getWidth() ? 'open: function(event, ui) {
                                            $(this).autocomplete("widget").css({
                                                width: ' . $_component->getWidth() . '
                                            });
                                       },' : '') . '
                                       delay: ' . $_component->getDelay() . ', 
                                       minLength: ' . $_component->getMinSuggestLength() . ',
                                       select: function(event, ui) {
                                         console.log("Selected: " + ui.item.value + " aka " + ui.item.id);
                                       }
                                     });')
                         ->render() . parent::render();
        }

        // Do not render the JavaScript part
        return parent::render();
    }
}
