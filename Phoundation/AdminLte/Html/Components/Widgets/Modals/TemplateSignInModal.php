<?php

/**
 * Class TemplateSignInModal
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLte\Html\Components\Widgets\Modals;

use Phoundation\Web\Html\Components\Script;
use Phoundation\Web\Html\Components\Widgets\Modals\SignInModal;
use Phoundation\Web\Html\Enums\EnumDisplaySize;
use Phoundation\Web\Html\Layouts\Grid;
use Phoundation\Web\Html\Layouts\GridColumn;
use Phoundation\Web\Html\Layouts\GridRow;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\Url;


class TemplateSignInModal extends TemplateRenderer
{
    /**
     * SignInModal class constructor
     */
    public function __construct(SignInModal $o_component)
    {
        parent::__construct($o_component);
    }


    /**
     * Render the HTML for this sign-in modal
     *
     * @return string|null
     */
    public function render(): ?string
    {
        // Build the form
        $form = $this->o_component->getForm()->render();

        // Build the layout
        $layout = Grid::new()
                      ->addGridRow(GridRow::new()
                                          ->addGridColumn(GridColumn::new()->setSize(EnumDisplaySize::three))
                                          ->addGridColumn(GridColumn::new()->setSize(EnumDisplaySize::six)->setContent($form))
                                          ->addGridColumn(GridColumn::new()->setSize(EnumDisplaySize::three)));

        // Set defaults
        $this->o_component
             ->setId('signinModal')
             ->setSize('lg')
             ->setTitle(tr('Sign in'))
             ->setContent($layout->render());

        // Render the sign in modal.
        // TemplateSignInModal objects handle caching themselves to avoid Script class output not being cached
        return cache('html')->get($this->o_component->getCacheKey(), function () {
            $this->o_component->setCache(false);

            return parent::render() . Script::new()
                                            ->setContent('
                                                $("form#form-sign-in").submit(function(e) {
                                                    e.stopPropagation();
                                    
                                                    $.post("' . Url::new('sign-in')
                                                                   ->makeAjax() . '", $(this).serialize())
                                                        .done(function (data, textStatus, jqXHR) {
                                                            $(".image-menu").replaceWith(data.html);
                                                            $("#signinModal").modal("hide");
                                                        });
                                    
                                                    return false;
                                                })');
        });
    }
}
