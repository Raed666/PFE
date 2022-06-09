<?php

namespace App\Controller;

use App\Entity\Schedule;
use App\Entity\Task;
use App\Form\ScheduleType;
use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\VarDumper\Cloner\Data;

/**
 * @Route("/schedule")
 */
class ScheduleController extends AbstractController
{
    /**
     * @Route("/", name="app_schedule_index", methods={"GET"})
     */
    public function index(ScheduleRepository $scheduleRepository): Response
    {
        return $this->render('schedule/index.html.twig', [
            'schedules' => $scheduleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_schedule_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ScheduleRepository $scheduleRepository , ManagerRegistry $doctrine): Response

    { 
        $task = new Task();
        $schedule = new Schedule();
        $Data = json_decode($request->query->get('Data'),true);

        $repository = $doctrine->getRepository(Task::class);
        $task = $repository->find($Data["Task"]);

      
       
        $schedule->setTimestamp($Data["Time"]);
        $schedule->setTask( $task);
        $scheduleRepository->add($schedule);
    

        return $this->renderForm('schedule/show.html.twig', [
            'schedule' => $schedule,
            
        ]);
    }

    /**
     * @Route("/{id}", name="app_schedule_show", methods={"GET"})
     */
    public function show(Schedule $schedule): Response
    {
        return $this->render('schedule/show.html.twig', [
            'schedule' => $schedule,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_schedule_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Schedule $schedule, ScheduleRepository $scheduleRepository): Response
    {
        $form = $this->createForm(ScheduleType::class, $schedule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $scheduleRepository->add($schedule);
            return $this->redirectToRoute('app_schedule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('schedule/edit.html.twig', [
            'schedule' => $schedule,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_schedule_delete", methods={"POST"})
     */
    public function delete(Request $request, Schedule $schedule, ScheduleRepository $scheduleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$schedule->getId(), $request->request->get('_token'))) {
            $scheduleRepository->remove($schedule);
        }

        return $this->redirectToRoute('app_schedule_index', [], Response::HTTP_SEE_OTHER);
    }

/**
* @Route("/saveTime" ,name="saveTime")
*/
public function saveTime(Request $request)
{
    $Data = json_decode($request->query->get('Data'),true);
    dump($Data);die;
  

  /*

    return new JsonResponse(array(
        'status' => true,
        'message' => "Saved :"),
        200
    );
*/
  

}
}
