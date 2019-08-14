<?php

namespace App\Controller;

use App\Entity\Route as RouteEntity;
use App\Form\RouteType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RouteController extends AbstractController
{
    /**
     * @Route("/routes", name="routes_list")
     */
    public function list()
    {
        $manager = $this->getDoctrine()->getManager();

        $routes = $manager->getRepository(RouteEntity::class)->findAll();

        return $this->render('route/list.html.twig', [
            'controller_name' => 'RouteController',
            'routes' => $routes
        ]);
    }

    /**
     * @Route("/route/view/{route}", name="route_view")
     * @param RouteEntity $route
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Route $route
     */
    public function view(RouteEntity $route)
    {
        return $this->render('route/view.html.twig', [
            'controller_name' => 'RouteController',
            'route' => $route
        ]);
    }

    /**
     * @Route("/route/add", name="route_add")
     * @param RouteEntity|Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function add(Request $request)
    {
        try {
            $route = new RouteEntity();

            $form = $this->createForm(RouteType::class, $route);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $route = $form->getData();

                $manager = $this->getDoctrine()->getManager();

                $manager->persist($route);
                $manager->flush();

                $this->addFlash('success', 'Route Created!');

                return $this->redirectToRoute('routes_list');
            }

            return $this->render('route/form.html.twig', [
                'form' => $form->createView()
            ]);

        } catch (ForeignKeyConstraintViolationException | Exception $exception) {
            $this->get('session')->getFlashBag()->add('error', 'Can\'t insert the article.' . $exception->getMessage());
        }

        return $this->redirectToRoute('routes_list');
    }

    /**
     * @Route("/route/update/{route}", name="route_update")
     * @param Request $request
     * @param RouteEntity $route
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, RouteEntity $route)
    {
        try {
            $form = $this->createForm(RouteType::class, $route, [
                'action' => $this->generateUrl('route_update', [
                    'route' => $route->getId()
                ]),
                'method' => 'POST',
            ]);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $route = $form->getData();
                $route->setUpdatedAt(new \DateTime('now'));

                $manager = $this->getDoctrine()->getManager();

                $manager->persist($route);
                $manager->flush();

                $this->addFlash('success', 'Route Updated!');

                return $this->redirectToRoute('routes_list');
            }

            return $this->render('route/form.html.twig', [
                'form' => $form->createView()
            ]);
        } catch (ForeignKeyConstraintViolationException | Exception $exception) {
            $this->get('session')->getFlashBag()->add('error', 'Can\'t insert the article.' . $exception->getMessage());
        }

        return $this->redirectToRoute('routes_list');
    }


    /**
     * @Route("/route/delete/{route}", name="route_delete")
     * @param RouteEntity $route
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function delete(RouteEntity $route)
    {
        try {
            $manager = $this->getDoctrine()->getManager();

            $manager->remove($route);
            $manager->flush();
        } catch (ForeignKeyConstraintViolationException | Exception $exception) {
            $this->get('session')->getFlashBag()->add('error', 'Can\'t insert the article.' . $exception->getMessage());
        }

        return $this->redirectToRoute('routes_list');
    }
}
