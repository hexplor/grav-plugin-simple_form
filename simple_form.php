<?php namespace Grav\Plugin;

use Grav\Common\Page\Page;
use RocketTheme\Toolbox\Event\Event;
use Grav\Common\Plugin;

class Simple_FormPlugin extends Plugin
{
  private $plugin_name = 'simple_form';
  private $plugin_data = array();

  public static function getSubscribedEvents()
  {
    return [
      'onPluginsInitialized' => ['onPluginsInitialized', 0]
    ];
  }

  public function onPluginsInitialized()
  {
    if ( $this->isAdmin() ) {
      $this->active = false;
      return;
    }

    $this->enable([
      'onTwigTemplatePaths'   => ['onTwigTemplatePaths', 0],
      'onPageProcessed'       => ['onPageProcessed', 0],
      'onCollectionProcessed' => ['onCollectionProcessed', 0]
    ]);
  }

  public function onTwigTemplatePaths()
  {
    $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
  }

  public function onCollectionProcessed(Event $event)
  {
    $collection = $event['collection'];

    foreach ( $collection as $page ) {
      $this->pageProcess($page);
    }
  }

  public function onPageProcessed(Event $event)
  {
    $page = $event['page'];

    $this->pageProcess($page);
  }

  private function pageProcess(Page $page)
  {
    if ( ! isset($page->header()->{$this->plugin_name}) or ! $page->header()->{$this->plugin_name} ) {
      return;
    }

    $params = $this->grav['config']->get('plugins.' . $this->plugin_name);

    if ( is_array($page->header()->{$this->plugin_name}) ) {
      $params = array_replace_recursive($params, $page->header()->{$this->plugin_name});
    }

    if ( $params['short_code'] or $params['auto_content'] ) {
      $old_content = $page->content();

      $this->plugin_data['html'] = $this->grav['twig']->twig()->render('plugins/simple_form/simple_form.html.twig', ['fields' => $params['fields'], 'token' => $params['token']]);

      if ( $params['short_code'] ) {
        $content = str_replace('{[simple_form]}', $this->plugin_data['html'], $old_content);
        $page->content($content);
      }

      if ( $params['auto_content'] ) {
        $page->content($this->plugin_data['html']);
      }
    }

    $this->grav['twig']->twig_vars['simple_form'] = $this->plugin_data;
    $this->grav['assets']->addInlineJs($this->grav['twig']->twig()->render('plugins/simple_form/simple_form.js.twig', ['fields' => $params['fields'], 'token' => $params['token'], 'messages' => $params['messages']]));
  }
}
