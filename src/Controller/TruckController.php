<?php

namespace App\Controller;

use App\Entity\Truck;
use App\Form\TruckType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TruckController extends AbstractController
{
    /**
     * @Route("/trucks", name="trucks_list")
     */
    public function list()
    {
        $manager = $this->getDoctrine()->getManager();

        $trucks = $manager->getRepository(Truck::class)->findAll();

        return $this->render('truck/list.html.twig', [
            'controller_name' => 'TruckController',
            'trucks' => $trucks
        ]);
    }

    /**
     * @Route("/truck/view/{truck}", name="truck_view")
     * @param Truck $truck
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function view(Truck $truck)
    {
        return $this->render('truck/view.html.twig', [
            'controller_name' => 'TruckController',
            'truck' => $truck
        ]);
    }

    /**
     * @Route("/truck/add", name="truck_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function add(Request $request)
    {
        try {
            $truck = new Truck();

            $form = $this->createForm(TruckType::class, $truck);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $truck = $form->getData();

                $manager = $this->getDoctrine()->getManager();

                $manager->persist($truck);
                $manager->flush();

                $this->addFlash('success', 'Truck Created!');

                return $this->redirectToRoute('trucks_list');
            }

            return $this->render('truck/form.html.twig', [
                'form' => $form->createView()
            ]);

        } catch (ForeignKeyConstraintViolationException | Exception $exception) {
            $this->get('session')->getFlashBag()->add('error', 'Can\'t insert the article.' . $exception->getMessage());
        }

        return $this->redirectToRoute('trucks_list');
    }

    /**
     * @Route("/truck/update/{truck}", name="truck_update")
     * @param Request $request
     * @param Truck $truck
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, Truck $truck)
    {
        try {
            $form = $this->createForm(TruckType::class, $truck, [
                'action' => $this->generateUrl('truck_update', [
                    'truck' => $truck->getId()
                ]),
                'method' => 'POST',
            ]);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $truck = $form->getData();
                $truck->setUpdatedAt(new \DateTime('now'));

                $manager = $this->getDoctrine()->getManager();

                $manager->persist($truck);
                $manager->flush();

                $this->addFlash('success', 'Truck Updated!');

                return $this->redirectToRoute('trucks_list');
            }

            return $this->render('truck/form.html.twig', [
                'form' => $form->createView()
            ]);
        } catch (ForeignKeyConstraintViolationException | Exception $exception) {
            $this->get('session')->getFlashBag()->add('error', 'Can\'t insert the article.' . $exception->getMessage());
        }

        return $this->redirectToRoute('trucks_list');
    }


    /**
     * @Route("/truck/delete/{truck}", name="truck_delete")
     * @param Truck $truck
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function delete(Truck $truck)
    {
        try {
            $manager = $this->getDoctrine()->getManager();

            $manager->remove($truck);
            $manager->flush();
        } catch (ForeignKeyConstraintViolationException | Exception $exception) {
            $this->get('session')->getFlashBag()->add('error', 'Can\'t insert the article.' . $exception->getMessage());
        }

        return $this->redirectToRoute('trucks_list');
    }
}
