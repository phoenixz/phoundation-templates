<?php

/**
 * Class TemplateInputDate
 *
 * @see       https://github.com/jcsmorais/shortcut-buttons-flatpickr
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package   Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Input;

use Phoundation\Accounts\Users\Sessions\Session;
use Phoundation\Date\Enums\EnumDateFormat;
use Phoundation\Web\Html\Components\Input\InputDate;
use Phoundation\Web\Html\Components\Script;
use Phoundation\Web\Html\Enums\EnumInputType;
use Phoundation\Web\Requests\Response;


class TemplateInputDate extends TemplateInputText
{
    /**
     * InputDate class constructor
     */
    public function __construct(InputDate $_component)
    {
        $_component->addClasses('form-control')
                    ->setInputType(EnumInputType::text);

        parent::__construct($_component);
    }


    /**
     * Returns the default date format required for this TemplateInputDate class
     *
     * @return EnumDateFormat|string
     */
    public static function getDateFormat(): EnumDateFormat|string
    {
        return EnumDateFormat::user_date;
    }


    /**
     * Renders and returns the HTML for the InputDate control
     *
     * @return string|null
     */
    public function render(): ?string
    {
//<div class="form-outline" data-mdb-datepicker-init data-mdb-input-init>
//    <input type="text" class="form-control" id="datepickerWithRanges" />
//    <label for="datepickerWithRanges" class="form-label">Select a date</label>
//</div>
//
//<script>
//    const datepickerElement = document.querySelector('#datepickerWithRanges');
//    const predefinedRanges = [
//        { start: new Date(2025, 5, 1), end: new Date(2025, 5, 7) }, // Example range
//        { start: new Date(2025, 5, 15), end: new Date(2025, 5, 21) } // Example range
//    ];
//
//    const filterFunction = (date) => {
//        return predefinedRanges.some(range => date >= range.start && date <= range.end);
//    };
//
//    new mdb.Datepicker(datepickerElement, {
//        filter: filterFunction
//    });
//</script>

        // Required to format the date of the "Today" button action below
        Response::loadJavaScript('mdb/js/plugins/moment/moment');

        // Set default options and backup $ID as ID needs to be rendered on outer div
        $_component = $this->getComponentObject();
        $id          = $_component->getId();
        $outline     = strtolower(str_replace('-', '_', $id));

        // The ID should be on the outer div, so remove it for the component itself
        $_component->setId($id . '-input', false);

        $return = parent::render() . Script::new('      
        const ' . $outline . '       = document.getElementById("' . $outline . '");
        const ' . $outline . 'Object = new mdb.Datepicker("#' . $outline . '", {' . $_component->renderOptions() . '});

        ' . $outline . '.addEventListener("valueChanged.mdb.datepicker", (e) => {
            $("[name=' . $id . ']").trigger("change");
        });

        $("body").on("click", ".datepicker-footer-btn.datepicker-clear-btn", function (e) {
            e.preventDefault();
            $("[name=' . $id . ']").val(moment(Date.now()).format("' . Session::getLocaleObject()->getDateFormatJavaScript() . '"));  
            ' . $outline . 'Object.close();
            $("[name=' . $id . ']").trigger("change");
      
            const hasInput = ' . $outline . '.querySelector("input");
            const hasLabel = ' . $outline . '.querySelector("label");
            
            if (hasInput && hasLabel) {
                new mdb.Input(' . $outline . ').init();
            }

            return false;
        });');

        $_component->setId($id);
        return $return;

    }
}
