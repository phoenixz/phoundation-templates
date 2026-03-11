<?php

/**
 * Class TemplateProfileImage
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLteV4
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV4\Html\Components\Widgets;

use Phoundation\Web\Html\Components\Widgets\ProfileImage;
use Phoundation\Web\Html\Template\TemplateRenderer;


class TemplateProfileImage extends TemplateRenderer
{
    /**
     * ProfileImage class constructor
     */
    public function __construct(ProfileImage $_component)
    {
        parent::__construct($_component);
    }
}
