<?php

namespace App\Controller;

use App\Entity\Delivery;
use App\Form\DeliveryType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeliveryController extends AbstractController
{
    /**
     * @Route("/deliveries", name="deliveries_list")
     */
    public function list()
    {
        $manager = $this->getDoctrine()->getManager();

        $deliveries = $manager->getRepository(Delivery::class)->findAll();

        return $this->render('delivery/list.html.twig', [
            'controller_name' => 'DeliveryController',
            'deliveries' => $deliveries
        ]);
    }

    /**
     * @Route("/delivery/view/{delivery}", name="delivery_view")
     * @param Delivery $delivery
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Delivery $delivery
     */
    public function view(Delivery $delivery)
    {
        return $this->render('delivery/view.html.twig', [
            'controller_name' => 'DeliveryController',
            'delivery' => $delivery
        ]);
    }

    /**
     * @Route("/delivery/add", name="delivery_add")
     * @param Delivery|Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function add(Request $request)
    {
        try {
            $delivery = new Delivery();

            $form = $this->createForm(DeliveryType::class, $delivery);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $delivery = $form->getData();

                $manager = $this->getDoctrine()->getManager();

                $manager->persist($delivery);
                $manager->flush();

                $this->addFlash('success', 'Delivery Created!');

                return $this->redirectToRoute('deliveries_list');
            }

            return $this->render('delivery/form.html.twig', [
                'form' => $form->createView()
            ]);

        } catch (ForeignKeyConstraintViolationException | Exception $exception) {
            $this->get('session')->getFlashBag()->add('error', 'Can\'t insert the article.' . $exception->getMessage());
        }

        return $this->redirectToRoute('deliveries_list');
    }

    /**
     * @Route("/delivery/update/{delivery}", name="delivery_update")
     * @param Request $request
     * @param Delivery $delivery
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, Delivery $delivery)
    {
        try {
            $form = $this->createForm(DeliveryType::class, $delivery, [
                'action' => $this->generateUrl('delivery_update', [
                    'delivery' => $delivery->getId()
                ]),
                'method' => 'POST',
            ]);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $delivery = $form->getData();
                $delivery->setUpdatedAt(new \DateTime('now'));

                $manager = $this->getDoctrine()->getManager();

                $manager->persist($delivery);
                $manager->flush();

                $this->addFlash('success', 'Delivery Updated!');

                return $this->redirectToRoute('deliveries_list');
            }

            return $this->render('delivery/form.html.twig', [
                'form' => $form->createView()
            ]);
        } catch (ForeignKeyConstraintViolationException | Exception $exception) {
            $this->get('session')->getFlashBag()->add('error', 'Can\'t insert the article.' . $exception->getMessage());
        }

        return $this->redirectToRoute('deliveries_list');
    }


    /**
     * @Route("/delivery/delete/{delivery}", name="delivery_delete")
     * @param Delivery $delivery
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function delete(Delivery $delivery)
    {
        try {
            $manager = $this->getDoctrine()->getManager();

            $manager->remove($delivery);
            $manager->flush();
        } catch (ForeignKeyConstraintViolationException | Exception $exception) {
            $this->get('session')->getFlashBag()->add('error', 'Can\'t insert the article.' . $exception->getMessage());
        }

        return $this->redirectToRoute('deliveries_list');
    }
}
