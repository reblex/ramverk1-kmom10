<?php

namespace Anax\Page;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * A default page rendering class.
 */
class PageRender implements PageRenderInterface, InjectionAwareInterface
{
    use InjectionAwareTrait;


    /**
     * Render a standard web page using a specific layout.
     *
     * @param array   $data   variables to expose to layout view.
     * @param integer $status code to use when delivering the result.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.ExitExpression)
     */
    public function renderPage($data, $status = 200)
    {
        // Get the view container, holding all views
        $view = $this->di->get("view");

        $data["stylesheets"] = ["css/main.css"];

        $view->add("common/navbar", [], "navbar");
        $view->add("common/footer", [], "footer");

        $view->add("common/layout", $data, "layout");
        $body = $view->renderBuffered("layout");
        $this->di->get("response")->setBody($body)->send($status);
        exit;
    }
}
