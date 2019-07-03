<?php
//determine which controller needs to be called based on the URL address. 
class RouterController extends Controller
{
	protected $controller;
	
	private function parseUrl($url)
	{
		$parsedUrl = parse_url($url);
		$parsedUrl["path"] = ltrim($parsedUrl["path"], "/");
		$parsedUrl["path"] = trim($parsedUrl["path"]);
		$explodedUrl = explode("/", $parsedUrl["path"]);
		return $explodedUrl;
	}
	private function dashesToCamel($text)
	{
		$text = str_replace('-', ' ', $text);
		$text = ucwords($text);
		$text = str_replace(' ', '', $text);
		return $text;
	}
	public function process($args)
	{
		$parsedUrl = $this->parseUrl($args[0]);
		if (empty($parsedUrl[0]))
			$this->redirect('login');
		$controllerClass = $this->dashesToCamel(array_shift($parsedUrl)) . 'Controller';
		if (file_exists('controllers/' . $controllerClass . '.php'))
        	$this->controller = new $controllerClass;
		else
			$this->redirect('error');
		$this->controller->process($parsedUrl);
		$this->data['title'] = $this->controller->head['title'];
		$this->data['description'] = $this->controller->head['description'];
		$this->data['messages'] = $this->getMessages();
		$this->view = 'layout';
	}
}
?>
