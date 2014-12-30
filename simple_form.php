<?php namespace Grav\Plugin;

use Grav\Common\Page\Page;
use RocketTheme\Toolbox\Event\Event;

use Grav\Common\Plugin;
use Grav\Common\Data\Data;

class Simple_FormPlugin extends Plugin
{
    private $data = [];

    //protected $config;

    private function mergeConfig(Page $page)
    {
        $this->config = new Data((array) $this->grav['config']->get('plugins.simple_form'));

        if (is_array($page->header()->simple_form)) {
            $this->config = new Data(array_replace_recursive($this->config->toArray(), $page->header()->simple_form));
        }
    }

    private function validate(Page $page)
    {
        if (isset($page->header()->simple_form) and $page->header()->simple_form) {
            $this->mergeConfig($page);

            return ($this->config->get('token')) ? true : false;
        }

        return false;
    }

    private function pageProcess(Page $page)
    {
        if (false === $this->validate($page)) {
            return;
        }

        $template_vars = [
            'fields'    => $this->config->get('fields'),
            'token'     => $this->config->get('token'),
            'messages'  => $this->config->get('messages')
        ];

        if ($this->config->get('short_code')) {
            $old_content = $page->content();

            $this->data['html'] = trim($this->grav['twig']->twig()->render('plugins/simple_form/' . $this->config->get('template_file'), $template_vars));

            $content = str_replace('{[' . $this->config->get('short_code') . ']}', $this->data['html'], $old_content);

            $page->content($content);
        }

        /* @todo: Removed for now. */
        //$this->grav['twig']->twig_vars['simple_form'] = $this->data;

        $this->grav['assets']->addInlineJs($this->grav['twig']->twig()->render('plugins/simple_form/simple_form.js.twig', $template_vars));
    }

    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
        ];
    }

    public function onPluginsInitialized()
    {
        if ($this->isAdmin()) {
            $this->active = false;
            return;
        }

        $this->enable([
            'onTwigTemplatePaths'       => ['onTwigTemplatePaths', 0],
            'onPageProcessed'           => ['onPageProcessed', 0],
            'onCollectionProcessed'     => ['onCollectionProcessed', 0]
        ]);
    }

    public function onTwigTemplatePaths()
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
    }

    public function onCollectionProcessed(Event $event)
    {
        $collection = $event['collection'];

        foreach ($collection as $page) {
            $this->pageProcess($page);
        }
    }

    public function onPageProcessed(Event $event)
    {
        $page = $event['page'];
        $this->pageProcess($page);
    }
}
