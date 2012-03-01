<?php
/**
 * WindowsAzure TaskDemoBundle
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace WindowsAzure\TaskDemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use WindowsAzure\TaskDemoBundle\Form\Type\TaskType;
use WindowsAzure\TaskDemoBundle\Entity\Task;

class TasksController extends Controller
{
    /**
     * @Route("/tasks", name="task_list")
     * @Method("GET")
     * @Template()
     */
    public function getTasksAction()
    {
        $repository = $this->container->get('windows_azure_taskdemo.repository.task');
        $tasks = $repository->findByDueDate($this->container->get('security.context')->getToken()->getUser());

        return array('tasks' => $tasks);
    }

    /**
     * @Route("/tasks/new.html", name="task_new")
     * @Method("GET")
     * @Template()
     */
    public function newTaskAction()
    {
        $form = $this->createForm(new TaskType());

        return array('form' => $form->createView());
    }

    /**
     * @Route("/tasks", name="task_create")
     * @Method("POST")
     * @Template("WindowsAzureTaskDemoBundle:Tasks:newTask.html.twig")
     */
    public function postTaskAction()
    {
        $idGenerator = $this->container->get('windows_azure_task_demo.model.id_generator');
        $task = new Task($idGenerator->generateId('task'), $this->container->get('security.context')->getToken()->getUser());
        $form = $this->createForm(new TaskType(), $task);

        $form->bindRequest($this->getRequest());

        if ($form->isValid()) {
            $repository = $this->container->get('windows_azure_taskdemo.repository.task');
            $repository->add($task);

            $em = $this->container->get('doctrine.orm.default_entity_manager');
            $em->flush();

            return $this->redirect($this->generateUrl('task_list'));
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/tasks/{id}", name="task_delete")
     * @Method("DELETE")
     */
    public function deleteTaskAction(Task $task)
    {
        $repository = $this->container->get('windows_azure_taskdemo.repository.task');
        $repository->remove($task);

        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $em->flush();

        return $this->redirect($this->generateUrl('task_list'));
    }
}


