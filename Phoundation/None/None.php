<?php

/**
 * Class None
 *
 * This is the None template, a template that will build *nothing* and allows (and requires) you to build all the HTML
 * yourself
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package None\Web
 */


declare(strict_types=1);


namespace Templates\Phoundation\None;

use Phoundation\Filesystem\Interfaces\PhoDirectoryInterface;
use Phoundation\Filesystem\PhoDirectory;
use Phoundation\Filesystem\PhoRestrictions;
use Phoundation\Utils\Seo;
use Phoundation\Web\Html\Components\Widgets\Menus\Menu;
use Phoundation\Web\Html\Template\Template;
use Templates\Phoundation\Mdb\TemplatePage;

class None extends Template
{
    /**
     * Template constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->name        = 'None';
        $this->page_class  = TemplatePage::class;
        $this->menus_class = Menu::class;

        parent::__construct();
    }


    /**
     * Return a description for this template
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * Return a description for this template
     *
     * @return string
     */
    public function getSeoName(): string
    {
        return Seo::string($this->name);
    }


    /**
     * Return a description for this template
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return 'This is the None template, a template that will build *nothing* and allows (and requires) you to build all the HTML yourself';
    }


    /**
     * Returns the path for this template
     *
     * @return PhoDirectoryInterface
     */
    public function getDirectoryObject(): PhoDirectoryInterface
    {
        return new PhoDirectory(__DIR__ . '/', PhoRestrictions::newReadonlyObject(DIRECTORY_ROOT));
    }
}
