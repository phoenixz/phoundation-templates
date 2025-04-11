<?php

/**
 * Class TemplateMdb template
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */


declare(strict_types=1);

namespace Templates\Phoundation\Mdb;

use Phoundation\Accounts\Users\Sessions\Session;
use Phoundation\Core\Plugins\Plugins;
use Phoundation\Exception\OutOfBoundsException;
use Phoundation\Web\Html\Components\Widgets\Panels\BottomPanel;
use Phoundation\Web\Html\Components\Widgets\Panels\HeaderPanel;
use Phoundation\Web\Html\Components\Widgets\Panels\Interfaces\PanelsInterface;
use Phoundation\Web\Html\Components\Widgets\Panels\Panels;
use Phoundation\Web\Html\Components\Widgets\Panels\SidePanel;
use Phoundation\Web\Html\Components\Widgets\Panels\TopPanel;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Requests\Request;
use Phoundation\Web\Requests\Response;

class TemplatePage extends \Phoundation\Web\Requests\TemplatePage
{
    /**
     * Returns the display mode string for the configured mode
     *
     * Currently supported modes are "light" and "dark" or "" (no mode, template default)
     *
     * @param string|null $mode
     * @param bool|null   $compact
     *
     * @return string
     */
    protected function getDisplayModeString(?string $mode = null, ?bool $compact = null): string
    {
        if (Session::getUserObject()->isGuest()) {
            $return  = null;
            $classes = [];
            $compact = $compact ?? Session::get('display', 'dark_mode')    ?? config()->getBoolean('web.display.compact'   , false, true);
            $mode    = $mode    ?? Session::get('display', 'compact_mode') ?? config()->getBoolean('web.display.modes.dark', false, true);

        } else {
            $return  = null;
            $classes = [];
            $compact = $compact ?? config()->getBoolean('web.display.compact'   , false, true);
            $mode    = $mode    ?? config()->getBoolean('web.display.modes.dark', false, true);
        }

        switch ($mode) {
            case false:
                $classes[] = 'light';
                break;

            case true:
                $classes[] = 'dark';
                $return   .= ' data-mdb-theme="dark"';
                break;

            default:
                throw new OutOfBoundsException(tr('Unknown display mode ":mode" specified', [
                    ':mode' => $mode,
                ]));
        }

        switch ($compact) {
            case false:
                break;

            case true:
                $classes[] = 'compact';
                break;

            default:
                throw new OutOfBoundsException(tr('Unknown display mode ":mode" specified', [
                    ':mode' => $mode,
                ]));
        }

        if (count($classes)) {
            $return .= ' class="' . implode(' ', $classes) . '"';
        }

        return $return;
    }


    /**
     * Renders the HTML header string
     *
     * @param string $doctype
     *
     * @return string|null
     */
    public function renderHtmlHeaders(string $doctype): ?string
    {
        return '<!DOCTYPE ' . $doctype . ">\n<html lang=\"" . Session::getLanguage() . '"' . $this->getDisplayModeString() . '>' . PHP_EOL . '<head>';
    }


    /**
     * Execute, builds and returns the page output, according to the template.
     *
     * Either use the default execution steps from parent::execute($target) or write your own execution steps here.
     * Once the output has been generated, it should be returned.
     *
     * @return string|null
     */
    public function execute(): ?string
    {
        // Generate panels used by the plugins
        Request::setPanelsObject($this->getAvailablePanelsObject());

        // Start all plugins
        Plugins::start();

        // Render the page body
        $body = $this->renderMain();

        if (Response::getRenderMainContentsOnly()) {
            return $body;
        }

        // Build HTML and minify the output
        $output = $this->renderHtmlHeadTag();

        Response::getHtmlHeadersSent();

        if (Response::getRenderMainWrapper()) {
            $body    = Request::getPanelsObject()->get('top', false)?->render() .
                       Request::getPanelsObject()->get('left')?->render() .
                       $body .
                       Request::getPanelsObject()->get('bottom', false)?->render();

            $output .=  '<body class="mdb-skin-custom" data-mdb-spy="scroll" data-mdb-target="#scrollspy" data-mdb-offset="250">';
        }

        // Page requested that no body parts be built
        $output .= Response::getFlashMessagesObject()->render() . $body;
        $output .= Response::getFileUploadHandlersObject()->render();
        $output .= $this->renderHtmlFooters();
        $output  = Html::minify($output);

        // Build Template specific HTTP headers
        $this->renderHttpHeaders($output);
        return $output;
    }


    /**
     * Returns a Panels object with the available panels for this Template
     *
     * @return PanelsInterface
     */
    public function getAvailablePanelsObject(): PanelsInterface
    {
        return Panels::new()
            ->add(config()->getBoolean('web.panels.top.enabled'   , true) ? TopPanel::new()    : null, 'top')
            ->add(config()->getBoolean('web.panels.left.enabled'  , true) ? SidePanel::new()   : null, 'left')
            ->add(config()->getBoolean('web.panels.header.enabled', true) ? HeaderPanel::new() : null, 'header')
            ->add(config()->getBoolean('web.panels.bottom.enabled', true) ? BottomPanel::new() : null, 'bottom');
    }


    /**
     * Build the HTTP headers for the page
     *
     * @param string $output
     * @return void
     */
    public function renderHttpHeaders(string $output): void
    {
        Response::setContentType('text/html');
        Response::setDoctype('html');
    }


    /**
     * Build the HTML header for the page
     *
     * @return string|null
     */
    public function renderHtmlHeadTag(): ?string
    {
        // Set head meta data
        Response::setFavIcon();
        Response::setViewport('width=device-width, initial-scale=1');

        // Load basic MDB and fonts CSS
        Response::loadCss([
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css',
            'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap',
            'templates/mdb/css/mdb',
            'templates/mdb/css/mdb-fix',
            'templates/mdb/css/phoundation',
        ], true);

        // Load configured CSS files
        Response::loadCss(config()->getArray('templates.mdb.css', []));

        // Load basic MDB amd jQuery javascript libraries
        Response::loadJavascript([
            'templates/mdb/js/jquery',
            'templates/mdb/js/mdb.umd',
            'templates/phoundation/js/jquery-phoundation'
        ], prefix: true);

        // Set basic page details
        Response::setPageTitle(tr('Phoundation platform'));

        // Set basic page details
        Response::setPageTitle(config()->get('project.name', tr('Phoundation project')) . ' (' . Response::getHeaderTitle() . ')');

        return Response::renderHtmlHeaders();
    }


    /**
     * Build the HTML body
     *
     * @return string|null
     */
    public function renderMain(): ?string
    {
        $body = parent::renderMain();

        if (Response::getRenderMainContentsOnly() or !Response::getRenderMainWrapper()) {
            return $body;
        }

        $header             = null;
        $horizontal_padding = 1;
        $vertical_padding   = 1;
        $horizontal_margin  = 1;
        $vertical_margin    = 1;

        if (str_contains(ENVIRONMENT, 'trial')) {
            $header .= '<div class="row">
                            <div class="p-3 mb-4 bg-secondary bg-gradient col-xl-12 rounded-5">
                                <div class="text-center example-square">' . tr('This is a trial version. All data is artificially generated and the database can be reset upon request') . '</div>
                            </div>
                        </div>';

        } elseif (str_contains(ENVIRONMENT, 'demo')) {
            $header .= '<div class="row">
                            <div class="p-3 mb-4 bg-secondary bg-gradient col-xl-12 rounded-5">
                                <div class="text-center example-square">' . tr('This is a demonstration version. All data is artificially generated and the database can be reset upon request') . '</div>
                            </div>
                        </div>';

        } elseif (str_contains(ENVIRONMENT, 'local')) {
            $header .= '<div class="row">
                            <div class="p-3 mb-4 bg-secondary bg-gradient col-xl-12 rounded-5">
                                <div class="text-center example-square">' . tr('This is a local version of your project') . '</div>
                            </div>
                        </div>';
        }

        return  Request::getPanelsObject()->get('header', false)?->render() . '
                <main class="pt-' . $horizontal_padding . ' mdb-docs-layout">
                    <div class="container mt-' . $vertical_padding . ' mt-' . $horizontal_padding . ' px-lg-' . $horizontal_margin . '">
                        <div class="tab-content">
                            ' . $header . $body . '
                        </div>
                    </div>
                </main>';
    }


    /**
     * Returns the string required for the bottom margin
     *
     * @param string|false $prefix_space
     *
     * @return string|null
     */
    public function getBottomMarginString(bool $prefix_space = true): ?string
    {
        static $compact = null;
        static $return  = null;

        if ($compact === null) {
            $compact = config()->getBoolean('web.display.compact', false, true);
        }

        if ($return === null) {
            $margin = ($compact ? 2 : 4);

            if ($margin) {
                $return = ($prefix_space ? ' ' : '') . 'mb-' . $margin;

            } else {
                $return = '';
            }
        }

        return $return;
    }
}
