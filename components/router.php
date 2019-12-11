<?php  

/**
 * Класс маршрутизатора
 */
class Router 
{
	
	private $routes;

	public function __construct()
	{
		$routesPath = ROOT.'/config/routes.php';
		$this->routes = include($routesPath); //При инициализации подключаем конфигурационный файл
	}

	/*Получение строки запроса*/

	private function getURI ()
	{
		if (!empty($_SERVER['REQUEST_URI'])) {
			return trim($_SERVER['REQUEST_URI'], '/');
		}
	}

	/*Основной метод класса. Запускает обработчик*/

	public function run()
	{
		//Получить строку запроса
		$uri = $this->getURI();
		
		//Проверить наличие в файле routes
		foreach ($this->routes as $uriPattern => $path) {
			if (preg_match("~$uriPattern~", $uri))
			{
				
				$internalRoute = preg_replace("~$uriPattern~", $path, $uri);

				//Если есть совпадение - определить какой контролеер и action обрабатывают запрос
				$segments = explode('/', $internalRoute);

				$controllerName = array_shift($segments).'Controller';
				$controllerName = ucfirst($controllerName);

				$actionName = 'action'.ucfirst(array_shift($segments));
				$parameters = $segments;
				//Подключить файл класса-контроллера

				$controllerFile = ROOT . '/controllers/' . 
						$controllerName . '.php';

				if (file_exists($controllerFile)) {
					include_once($controllerFile);
				}
				//Создать объект, вызвать метод

				$controllerObject = new $controllerName;
				$result = $controllerObject->$actionName($parameters[0],$parameters[1],$parameters[2]);
				if ($result != null) {
					break;
				}
			}
		}
		
		
	}
}

?>