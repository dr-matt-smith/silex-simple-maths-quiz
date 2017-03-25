<?php
namespace Itb\Controller;


use Itb\Model\Module\ModuleResult;
use Itb\Model\Module\ModuleResultRepository;
use Itb\WebApplication;

use Symfony\Component\HttpFoundation\Request;

class MainController
{
    private $app;

    public function __construct(WebApplication $app)
    {
        $this->app = $app;
    }

    public function indexAction()
    {
        $argsArray = [
        ];
        $templateName = 'index';
        return $this->app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    public function updateAction($id)
    {
        // get reference to our repository
        $moduleResultRepository = new ModuleResultRepository();
        $result = $moduleResultRepository->getOneById($id);

        if(null == $result){
            $errorMessage = 'no module result found with id = ' . $id;
            $this->app->abort(400, $errorMessage);
        }

        $argsArray = [
            'result' => $result
        ];
        $templateName = 'updateForm';
        return $this->app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    public function updateNoIdAction()
    {
            $errorMessage = 'you must provide an id for the update page (e.g. /updateModuleResult/123)';
        // 400 - bad request
        $this->app->abort(400, $errorMessage);
    }


    public function processUpdateModuleResultAction(Request $request)
    {
        $id = $request->get('id');
        $moduleCode = $request->get('moduleCode');
        $studentNumber = $request->get('studentNumber');
        $semester = $request->get('semester');
        $grade = $request->get('grade');

        $moduleResultRepository = new ModuleResultRepository();
        $moduleResult = $moduleResultRepository->getOneById($id);

        $moduleResult->setModuleCode($moduleCode);
        $moduleResult->setStudentNumber($studentNumber);
        $moduleResult->setGrade($grade);
        $moduleResult->setSemester($semester);

        $updateSuccess = $moduleResultRepository->update($moduleResult);

        // default - bad update
        $argsArray = [
            'message' => 'sorry, an error occurred when attempting to update module result',
        ];
        $templateName = 'error';


        // if update successful ...
        if(null != $updateSuccess){
            return $this->updateSuccess($id);
        } else {
            return $this->app['twig']->render($templateName . '.html.twig', $argsArray);
        }
    }

    public function updateSuccess($id)
    {
        $argsArray = [
            'id' => $id
        ];

        $templateName = 'updateSuccess';
        return $this->app['twig']->render($templateName . '.html.twig', $argsArray);
    }

}