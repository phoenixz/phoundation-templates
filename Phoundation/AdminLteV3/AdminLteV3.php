<?php

/**
 * Class AdminLteV3
 *
 * This is the AdminLteV3 template
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package AdminLteV3\Web
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV3;

use Phoundation\Filesystem\Interfaces\PhoDirectoryInterface;
use Phoundation\Filesystem\PhoDirectory;
use Phoundation\Filesystem\PhoRestrictions;
use Phoundation\Utils\Seo;
use Phoundation\Web\Html\Template\Template;
use Templates\Phoundation\AdminLteV3\Html\Components\Widgets\Menus\TemplateMenu;

class AdminLteV3 extends Template
{
    /**
     * Template constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->name        = 'AdminLteV3';
        $this->page_class  = TemplatePage::class;
        $this->menus_class = TemplateMenu::class;

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
        return 'This is the AdminLteV3 admin template for your website. You are free to add or build other templates';
    }


    /**
     * Returns the path for this template
     *
     * @return PhoDirectoryInterface
     */
    public function getDirectoryObject(): PhoDirectoryInterface
    {
        return new PhoDirectory(__DIR__ . '/', PhoRestrictions::newReadonly(DIRECTORY_ROOT));
    }
}
