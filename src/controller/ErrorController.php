<?php
namespace Itb\Controller;


use Itb\WebApplication;

class ErrorController
{
    private $app;

    public function __construct(WebApplication $app)
    {
        $this->app = $app;
    }


    public function errorAction($e, $statusCode)
    {
//        $statusCode = $e->getStatusCode();

        print('status code  =' . $statusCode);
        print('<hr>');



        $errorMessage = $e->getMessage();

        // default - general error
        // ------------
        $templateName = 'error';

        // special message for 404 not found errors...
        if(404 == $statusCode){
            $templateName = '404';
        }

        $argsArray = array(
            'message' => $errorMessage
        );

        return $this->app['twig']->render($templateName . '.html.twig', $argsArray);
    }


}
