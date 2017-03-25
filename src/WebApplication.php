<?php
namespace Itb;


use Silex\Application;
use Itb\Controller\MainController;
use Itb\Controller\PlusController;
use Symfony\Component\Debug\ErrorHandler;
use Itb\Controller\ErrorController;
use Symfony\Component\HttpFoundation\Request;



class WebApplication extends Application
{
    private $myTemplatesPath = __DIR__ . '/../templates';


    public function __construct()
    {
        parent::__construct();

        $this['debug'] = true;
        $this->setupTwig();
        $this->addRoutes();

        $this->handleErrorsAndExceptions();
    }

    public function setupTwig()
    {
        // register Twig with Silex
        // ------------
        $this->register(new \Silex\Provider\TwigServiceProvider(),
            [
                'twig.path' => $this->myTemplatesPath
            ]
        );
    }

    public function addRoutes()
    {
        // setup Service controller provider
        $this->register(new \Silex\Provider\ServiceControllerServiceProvider());

        // map routes to controller class/method
        //-------------------------------------------

        //==============================
        // controllers as a service
        //==============================
        $this['main.controller'] = function() { return new MainController($this);   };
        $this['plus.controller'] = function() { return new PlusController($this);   };

        //==============================
        // now define the routes
        //==============================

        // -- main --
        $this->get('/', 'main.controller:indexAction');
        $this->get('/updateModuleResult/{id}', 'main.controller:updateAction');
        $this->get('/updateModuleResult', 'main.controller:updateNoIdAction');

        $this->post('/updateModuleResult', 'main.controller:processUpdateModuleResultAction');

        $this->get('/plusHome', 'plus.controller:indexAction');
        $this->get('/plusNewQuiz', 'plus.controller:newQuizAction');
        $this->get('/plusQuestion/{questionNumber}', 'plus.controller:questionAction');
        $this->post('/plusAnswer', 'plus.controller:answerAction');

    }


    public function handleErrorsAndExceptions ()
    {
        ErrorHandler::register();

        //register an error handler
        $this->error(function (\Exception $e, Request $request, $statusCode) {
//        $this->error(function (\Exception $e) {
            $errorController = new ErrorController($this);
            return $errorController->errorAction($e, $statusCode);
        });
    }

}