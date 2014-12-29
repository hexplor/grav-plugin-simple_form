<?php namespace Grav\Plugin;

use Grav\Common\Page\Page;
use RocketTheme\Toolbox\Event\Event;
use Grav\Common\Plugin;

class Simple_FormPlugin extends Plugin
{
    private $data = [];

    private function mergeConfig(Page $page)
    {
        $defaults = $this->grav['config']->get('plugins.simple_form');

        if (is_array($page->header()->simple_form)) {
            $this->grav['config']->set('plugins.simple_form', array_replace_recursive($defaults, $page->header()->simple_form));
        }
    }

    private function validate(Page $page)
    {
        if (isset($page->header()->simple_form) and $page->header()->simple_form) {
            $this->mergeConfig($page);

            return ($this->grav['config']->get('plugins.simple_form.token')) ? true : false;
        }

        return false;
    }

    private function pageProcess(Page $page)
    {
        $this->validate($page);

        $config = $this->grav['config']->get('plugins.simple_form');

        if ($config['short_code']) {
            $old_content = $page->content();

            $this->data['html'] = $this->grav['twig']->twig()->render('plugins/simple_form/' . $config['template_file'], ['fields' => $config['fields'], 'token' => $config['token']]);

            $content = str_replace('{[' . $config['short_code'] . ']}', $this->data['html'], $old_content);
            $page->content($content);
        }

        /* @todo: Removed for now. */
        //$this->grav['twig']->twig_vars['simple_form'] = $this->data;

        $this->grav['assets']->addInlineJs($this->grav['twig']->twig()->render('plugins/simple_form/simple_form.js.twig', ['fields' => $config['fields'], 'token' => $config['token'], 'messages' => $config['messages']]));
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
