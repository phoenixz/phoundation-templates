<?php

/**
 * Class TemplateInputDateTimeLocal
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

use Phoundation\Accounts\Users\Sessions\Session;
use Phoundation\Date\PhoDateTimeFormats;
use Phoundation\Exception\OutOfBoundsException;
use Phoundation\Web\Html\Components\Input\InputDateTimeLocal;
use Phoundation\Web\Html\Components\Script;
use Phoundation\Web\Html\Enums\EnumInputType;
use Phoundation\Web\Requests\Response;


class TemplateInputDateTimeLocal extends TemplateInputText
{
    /**
     * InputDateTimeLocal class constructor
     */
    public function __construct(InputDateTimeLocal $o_component)
    {
        $o_component->addClasses('form-control');
        parent::__construct($o_component);
    }


    public function render(): ?string
    {
        // Extract id from the component
        if (!$this->o_component->getId()) {
            $this->o_component->setId($this->o_component->getName());
        }

        $id = $this->o_component->getId();

        if (!$id) {
            if (!$this->o_component->getReadonly() and !$this->o_component->getDisabled()) {
                throw new OutOfBoundsException(tr('Cannot render IntputDateTimeLocal object, no HTML id attribute specified'));
            }

            // We can render a normal datetime-local component here
            return parent::render();
        }

        $this->o_component->setInputType(EnumInputType::text)
                          ->addClass('datetimepicker-input')
                          ->addData('#' . $id, 'target');

        // Load required CSS and JS
        Response::loadCss('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4');
        Response::loadJavaScript([
            'templates/adminlte/plugins/moment/moment',
            'vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4'
        ]);

        // Return the rendered datetime component
        return '<div class="input-group date" id="' . $id . '" data-target-input="nearest">
                    ' . parent::render() . '
                    <div class="input-group-append" data-target="#' . $id . '" data-toggle="datetimepicker">
                       <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>' .
                Script::new()->setContent('
                    // Date and time picker
                    $.datepicker.setDefaults({
                        format: "' . PhoDateTimeFormats::convertJsToMoment(Session::getLocaleObject()->getDateTimeFormatJavaScript()) . '"
                    });
                    $("#' . $id . '").datetimepicker({ 
                        locale: "' . Session::getLocaleObject()->getLocale() . '",                            
                        format: "' . PhoDateTimeFormats::convertJsToMoment(Session::getLocaleObject()->getDateTimeFormatJavaScript()) . '",
                        icons: { 
                            time: "far fa-clock" 
                        }
                    });
                ');
//        locale: "' . Session::getLocaleObject()->getLocale() . '",
//        format: "' . DateFormats::convertJsToMoment(Session::getLocaleObject()->getDateTimeFormatJavaScript()) . '"
    }
}
