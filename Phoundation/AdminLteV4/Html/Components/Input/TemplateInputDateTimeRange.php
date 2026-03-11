<?php

/**
 * Class TemplateInputDateTimeRange
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLteV4
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV4\Html\Components\Input;

use Phoundation\Web\Html\Components\Input\InputDateTimeRange;


class TemplateInputDateTimeRange extends TemplateInputText
{
    /**
     * InputText class constructor
     */
    public function __construct(InputDateTimeRange $_component)
    {
        $_component->addClasses('form-control');
        parent::__construct($_component);
    }


    /**
     * Render and return the HTML for this object
     *
     * @return string|null
     */
    public function render(): ?string
    {
//        <div class="form-group">
//            <label>Date and time range:</label>
//            <div class="input-group">
//                <div class="input-group-prepend">
//                    <span class="input-group-text"><i class="far fa-clock"></i></span>
//                </div>
//                <input type="text" class="form-control float-right" id="reservationtime">
//            </div>
//        </div>

//        //Date range picker with time picker
//        $('#reservationtime').daterangepicker({
//          timePicker: true,
//          timePickerIncrement: 30,
//          locale: {
//            format: 'MM/DD/YYYY hh:mm A'
//          }
//        })

        return parent::render();
    }
}
