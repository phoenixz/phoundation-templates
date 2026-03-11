<?php

/**
 * Class TemplateToast
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Phoundation\Mdb
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
    public function __construct(ToastInterface $_component)
    {
        parent::__construct($_component);
    }


    /**
     * Renders and returns the HTML for this component
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $_message    = $this->_component->getFlashMessageObject();
        $position     = $this->renderPosition($_message);
        $this->render = '   var toast = document.createElement("div");
                            toast.setAttribute("data-mdb-color", "' . $_message->getMode()->value . '");
                            toast.classList.add("toast", "fade");
                            toast.innerHTML = `
                                <div class="toast-header">
                                    ' . $_message->getIcon() . ' <strong class="me-auto">' . $_message->getTitle() . '</strong>
                                    <small>' . $_message->getSubTitle() . '</small>
                                    <button type="button" class="btn-close" data-mdb-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    ' . $_message->getMessage() . '
                                </div>
                                `;                              
                            
                            document.body.appendChild(toast);
                            
                            var toastInstance = new mdb.Toast(toast, {
                                stacking: true,
                                hidden: true,
                                width: "' . $_message->getWidth() . 'px",
                                position: "' . $position . '",             
                                autohide: ' . Strings::fromBoolean((bool) $_message->getAutoClose()) . '
                                ' . ($_message->getAutoClose() ? ', delay: ' . $_message->getAutoClose() : null) . '                                
                            });
                            
                            toastInstance.show();';

        return parent::render();
    }


    /**
     * Renders the Toast position on screen
     *
     * @param FlashMessageInterface $_message
     *
     * @return string|null
     */
    protected function renderPosition(FlashMessageInterface $_message): ?string
    {
        if ($_message->getTop()) {
            if ($_message->getLeft()) {
                return 'top-left';
            }

            return 'top-right';
        }

        if ($_message->getLeft()) {
            return 'bottom-left';
        }

        return 'bottom-right';
    }
}
