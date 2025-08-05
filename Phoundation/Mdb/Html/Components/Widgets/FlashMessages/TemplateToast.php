<?php

/**
 * Class TemplateToast
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Widgets\FlashMessages;

use Phoundation\Utils\Strings;
use Phoundation\Web\Html\Components\Widgets\FlashMessages\Interfaces\FlashMessageInterface;
use Phoundation\Web\Html\Components\Widgets\FlashMessages\Interfaces\ToastInterface;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateToast extends TemplateRenderer
{
    /**
     * Breadcrumbs class constructor
     */
    public function __construct(ToastInterface $o_component)
    {
        parent::__construct($o_component);
    }


    /**
     * Renders and returns the HTML for this component
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $o_message    = $this->o_component->getFlashMessageObject();
        $position     = $this->renderPosition($o_message);
        $this->render = '   var toast = document.createElement("div");
                            toast.setAttribute("data-mdb-color", "' . $o_message->getMode()->value . '");
                            toast.classList.add("toast", "fade");
                            toast.innerHTML = `
                                <div class="toast-header">
                                    ' . $o_message->getIcon() . ' <strong class="me-auto">' . $o_message->getTitle() . '</strong>
                                    <small>' . $o_message->getSubTitle() . '</small>
                                    <button type="button" class="btn-close" data-mdb-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    ' . $o_message->getMessage() . '
                                </div>
                                `;                              
                            
                            document.body.appendChild(toast);
                            
                            var toastInstance = new mdb.Toast(toast, {
                                stacking: true,
                                hidden: true,
                                width: "' . $o_message->getWidth() . 'px",
                                position: "' . $position . '",             
                                autohide: ' . Strings::fromBoolean((bool) $o_message->getAutoClose()) . '
                                ' . ($o_message->getAutoClose() ? ', delay: ' . $o_message->getAutoClose() : null) . '                                
                            });
                            
                            toastInstance.show();';

        return parent::render();
    }


    /**
     * Renders the Toast position on screen
     *
     * @param FlashMessageInterface $o_message
     *
     * @return string|null
     */
    protected function renderPosition(FlashMessageInterface $o_message): ?string
    {
        if ($o_message->getTop()) {
            if ($o_message->getLeft()) {
                return 'top-left';
            }

            return 'top-right';
        }

        if ($o_message->getLeft()) {
            return 'bottom-left';
        }

        return 'bottom-right';
    }
}
