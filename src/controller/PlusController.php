<?php
namespace Itb\Controller;


use Itb\Model\QuestionRepository;
use Itb\Model\Result;
use Itb\Model\ResultRepository;
use Itb\Model\Question;
use Itb\WebApplication;

use Symfony\Component\HttpFoundation\Request;

class PlusController
{
    const NUM_QUESTIONS = 3;

    private $app;

    private $questionRepository;
    private $resultRepository;

    public function __construct(WebApplication $app)
    {
        $this->app = $app;
        $this->resultRepository = new ResultRepository();
        $this->questionRepository = new QuestionRepository();
    }

    public function indexAction()
    {
        $argsArray = [
        ];
        $templateName = 'plusHome';
        return $this->app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    public function newQuizAction()
    {
        $this->emptyDatabase();

        $q1 = new Question();
        $q1->setNum1(5);
        $q1->setNum2(10);
        $q1->setCorrectAnswer(15);

        $q2 = new Question();
        $q2->setNum1(10);
        $q2->setNum2(1);
        $q2->setCorrectAnswer(11);

        $q3 = new Question();
        $q3->setNum1(10);
        $q3->setNum2(7);
        $q3->setCorrectAnswer(17);

        $this->questionRepository->create($q1);
        $this->questionRepository->create($q2);
        $this->questionRepository->create($q3);

        return $this->questionAction(1);
    }


    public function questionAction($questionNumber)
    {
       /**
         * @var Question $question
         */
        $question = $this->questionRepository->getOneById($questionNumber);

        $argsArray = [
            'questionNumber' => $questionNumber,
            'num1' => $question->getNum1(),
            'num2' => $question->getNum2(),
            'correctAnswer' => $question->getCorrectAnswer()
        ];

        $templateName = 'plusQuestion';

        return $this->app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    public function answerAction(Request $request)
    {
        $studentId = 1; // hard code for now

        $questionId = $request->get('questionId');
        $studentAnswer = $request->get('studentAnswer');
        $correctAnswer = $request->get('correctAnswer');

        $result = new Result();
        $result->setQuestionId($questionId);
        $result->setStudentId($studentId);
        $result->setStudentAnswer($studentAnswer);

        if($studentAnswer == $correctAnswer){
            $result->setScore(1);
        } else {
            $result->setScore(0);
        }

        $this->resultRepository->create($result);

        if($questionId < PlusController::NUM_QUESTIONS){
            $nextQuestionNumber = $questionId + 1;
            return $this->questionAction($nextQuestionNumber);
        } else {
            return $this->resultsAction($studentId);
        }

    }

    public function resultsAction($studentId)
    {
        $resultsForStudent = $this->resultRepository->getAllQuestionResultsForStudent($studentId);


        $argsArray = [
            'resultsForStudents' => $resultsForStudent,
            'numQuestions' => PlusController::NUM_QUESTIONS
        ];
        $templateName = 'plusSummary';
        return $this->app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    private function emptyDatabase()
    {
        $this->questionRepository->resetDatabaseTable();
        $this->resultRepository->resetDatabaseTable();

    }

}