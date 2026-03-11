<?php

/**
 * Class TemplatePage
 *
 *
 *
 * @author    Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright © 2025 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLteV3
 */


declare(strict_types=1);

namespace Templates\Phoundation\AdminLteV3;

use Phoundation\Accounts\Users\Sessions\Session;
use Phoundation\Core\Plugins\Plugins;
use Phoundation\Developer\Project\Project;
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
        $return  = '';
        $mode    = $mode    ?? Session::getDisplayMode();
        $compact = $compact ?? Session::getCompactMode();

        switch ($mode) {
            case null:
                // no break

            case 'light':
                break;

            case 'dark':
                $return .= ' dark-mode';
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
                $return .= ' compact';
                break;

            default:
                throw new OutOfBoundsException(tr('Unknown display compact mode ":compact" specified', [
                    ':compact' => $compact,
                ]));
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
        return '<!DOCTYPE ' . $doctype . ">\n<html lang=\"" . Session::getLanguage() . '">' . PHP_EOL . Response::renderHeadTag();
    }


    /**
     * Execute, builds and returns the page output, according to the template.
     *
     * Either use the default execution steps from parent::execute($target), or write your own execution steps here.
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

        if (Response::getDirectOutputMode()) {
            return $body;
        }

        // Build HTML and minify the output
        $output = $this->renderHtmlHeadTag();
        Response::getHtmlHeadersSent(true);

        if (Response::getRenderMainWrapper()) {
            $body    = Request::getPanelsObject()->get('top' , exception: false)?->render() .
                       Request::getPanelsObject()->get('left', exception: false)?->render() .
                       $body .
                       Request::getPanelsObject()->get('bottom', exception: false)?->render();

            $output .= ' <body class="sidebar-mini' . (config()->getBoolean('web.panels.sidebar.collapsed', false) ? ' sidebar-collapse' : '') . $this->getDisplayModeString() . '" style="height: auto;">
                            <div class="wrapper">' .
                                Response::getFlashMessagesObject()->render() .
                                $body . '
                            </div>';

        } else {
            // Page requested that no body parts be built
            $output .= Response::getFlashMessagesObject()->render() . $body;
        }

        // Add file upload JavaScript, if required. Add footers and minify all the HTML
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

        // Load basic AdminLteV3 and fonts CSS
        Response::loadCss([
            'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback',
            'adminlte/plugins/fontawesome-free-6.4.0-web/css/all',
            'adminlte/plugins/fontawesome-free-6.4.0-web/css/regular',
//            'adminlte/plugins/fontawesome-free-6.4.0-web/css/v4-shim',
            'adminlte/css/adminlte',
            'adminlte/plugins/overlayScrollbars/css/OverlayScrollbars',
            'adminlte/css/phoundation'
        ], true);

        // Load configured CSS files
        Response::loadCss(config()->getArray('templates.adminlte.css', []));

        // Load basic AdminLteV3 amd jQuery javascript libraries
        Response::loadJavaScript([
            'adminlte/plugins/jquery/jquery',
            'adminlte/plugins/jquery-ui/jquery-ui',
            'adminlte/plugins/bootstrap/js/bootstrap.bundle',
            'adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars',
            'adminlte/js/adminlte',
            'phoundation/js/jquery-phoundation',
        ], prefix: true);

        // Set basic page details
        Response::setPageTitle(Project::getHumanReadableFullName() . ' (' . Response::getHeaderTitle() . (Response::getHeaderSubTitle() ? ' ' . Response::getHeaderSubTitle() : null) . ')');

        return Response::renderHtmlHeaders();
    }


    /**
     * Actually renders the environment warning message
     *
     * @param string|null $mode
     * @param string|null $title
     * @param string|null $message
     *
     * @return string|null
     */
    protected function getRenderedEnvironmentWarning(?string $mode, ?string $title, ?string $message): ?string
    {
        return '<div class="text-center alert alert-' . $mode . ' alert-dismissible">
                  <h5 class=""><i class="icon fas fa-ban"></i> ' . $title . '</h5>
                      ' . $message . '
                </div>';
    }


    /**
     * Build the HTML body
     *
     * @return string|null
     */
    public function renderMain(): ?string
    {
        $body = parent::renderMain();

        if (Response::getDirectOutputMode()) {
            return $body;
        }

        if (Response::getRenderMainWrapper()) {
            $body = '   <div class="' . Response::getClass('content-wrapper', 'content-wrapper') .  '" style="min-height: 1518.06px;">
                           ' . Request::getPanelsObject()->get('header', exception: false)?->render() . '
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            ' . $this->renderEnvironmentWarning() . $body . '
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>';
        }

        return $body;
    }
}
