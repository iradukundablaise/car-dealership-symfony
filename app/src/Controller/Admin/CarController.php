<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use App\Form\Car2Type;
use App\Form\CarType;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/car')]
class CarController extends AbstractController
{
    #[Route('/', name: 'app_admin_car_index', methods: ['GET'])]
    public function index(
        Request $request,
        CarRepository $carRepository
    ): Response
    {
        $page = intval($request->get('page', 1));

        return $this->render('admin/car/index.html.twig', [
            'cars' => $carRepository->findAllPaginated($page),
        ]);
    }

    #[Route('/new', name: 'app_admin_car_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CarRepository $carRepository): Response
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carRepository->save($car, true);

            return $this->redirectToRoute('app_admin_car_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/car/new.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_car_show', methods: ['GET'])]
    public function show(Car $car): Response
    {
        return $this->render('admin/car/show.html.twig', [
            'car' => $car,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_car_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Car $car, CarRepository $carRepository): Response
    {
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carRepository->save($car, true);

            return $this->redirectToRoute('app_admin_car_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/car/edit.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_car_delete', methods: ['POST'])]
    public function delete(Request $request, Car $car, CarRepository $carRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $request->request->get('_token'))) {
            $carRepository->remove($car, true);
        }

        return $this->redirectToRoute('app_admin_car_index', [], Response::HTTP_SEE_OTHER);
    }
}
