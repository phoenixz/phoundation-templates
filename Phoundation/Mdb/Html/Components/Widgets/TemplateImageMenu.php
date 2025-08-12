<?php

/**
 * Class TemplateImageMenu
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb\Html\Components\Widgets;

use Phoundation\Exception\OutOfBoundsException;
use Phoundation\Web\Html\Components\Anchor;
use Phoundation\Web\Html\Components\Widgets\ImageMenu;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateImageMenu extends TemplateRenderer
{
    /**
     * ImageMenu class constructor
     */
    public function __construct(ImageMenu $o_component)
    {
        parent::__construct($o_component);
    }


    /**
     * Renders and returns the image menu block HTML
     *
     * @return string|null
     */
    public function render(): ?string
    {
        if (!$this->o_component->getImage()) {
            throw new OutOfBoundsException(tr('Cannot render ImageMenu object HTML, no image specified'));
        }
//.        <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#exampleModal" style=""> Launch demo modal </button>

        $o_anchor     = Anchor::new(($this->o_component->getMenu() ? '#' : Html::safe($this->o_component->getUrl())))
                              ->setClasS(($this->o_component->getMenu() ? 'dropdown-toggle ' : '') . 'd-flex align-items-center hidden-arrow')
                              ->setId('navbarDropdownMenuAvatar')
                              ->addData('dropdown', 'mdb-toggle')
                              ->addAria('false', 'expanded');

        if ($this->o_component->getMenu()) {
            $o_anchor->setRole('button');

            if ($this->o_component->getModalSelector()) {
                $o_anchor->addData('modal', 'mdb-toggle')
                         ->addData($this->o_component->getModalSelector(), 'mdb-target');
            }
        }

        $this->render = ' <div class="dropdown image-menu">
                            ' . $o_anchor->setContent($this->o_component->getImage()->getImgObject()
                                                                                    ->setHeight($this->o_component->getHeight())
                                                                                    ->addClasses('rounded-circle')
                                                                                    ->addExtraAttributes('loading="lazy"'));

        $this->render .= '  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">';

        if ($this->o_component->getMenu()) {
            foreach ($this->o_component->getMenu() as $label => $url) {
                $this->render .= '<li>
                                    ' . Anchor::new($url, $label)->setClass('dropdown-item') . '
                                  </li>';
            }

        }

        $this->render .= '      </ul>
                            </div>' . PHP_EOL;

        return parent::render();
    }
}
