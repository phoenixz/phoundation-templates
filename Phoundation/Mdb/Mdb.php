<?php

/**
 * Class Mdb
 *
 * This is the Mdb template
 *
 * @see       https://mdbootstrap.com/learn/mdb-foundations/basics/introduction/
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package   Templates\Phoundation\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb;

use Phoundation\Filesystem\PhoDirectory;
use Phoundation\Filesystem\PhoRestrictions;
use Phoundation\Filesystem\Interfaces\PhoDirectoryInterface;
use Phoundation\Web\Html\Template\Template;
use Templates\Phoundation\Mdb\Html\Components\Widgets\Menus\TemplateMenu;


class Mdb extends Template
{
    /**
     * Template constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->name        = 'Mdb';
        $this->page_class  = TemplatePage::class;
        $this->menus_class = TemplateMenu::class;

        parent::__construct();
    }


    /**
     * Return a description for this template
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return 'This is the Mdb template for your website. You are free to add or build other templates';
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
