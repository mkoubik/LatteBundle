<?php

use LatteBundle\Event\TemplateEvent;
use LatteBundle\Listener\HelpersListener;
use Nette\Templating\Template;

require_once __DIR__ . '/../bootstrap.php';

$_phpSource = '<?php echo $template->capitalize("hello $name!");';
$_name = 'world';
$_html = 'Hello World!';

$template = new Template();
$template->setSource($_phpSource);
$event = new TemplateEvent($template);

$listener = new HelpersListener($filter);

$listener->onCreateTemplate($event);

ob_start();
$template->name = $_name;
$template->render();
$html = ob_get_clean();

Assert::equal($_html, $html);
