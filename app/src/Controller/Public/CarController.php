<?php

namespace App\Controller\Public;

use App\Entity\CarCategory;
use App\Repository\CarCategoryRepository;
use App\Repository\CarRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CarController extends AbstractController
{
    #[Route('/', name: 'app_public_index')]
    public function index(
        Request $request,
        CarRepository $carRepository,
        CarCategoryRepository $carCategoryRepository,
        HttpClientInterface $httpClient
    ): Response
    {
        $response = $httpClient->request(
            'GET',
            "https://api.open-meteo.com/v1/forecast?latitude=48.85&longitude=2.35&current_weather=true" // weather information in Paris
        );

        $weatherInfo = $response->toArray()['current_weather'] ?? [];

        $filterCategoryId = $request->get('category', false);
        $page = intval($request->query->get('page', 1));

        $cars = $filterCategoryId ?
            $carRepository->findByPaginated(['category' => $filterCategoryId], $page) :
            $carRepository->findAllPaginated($page);

        $carCategories = $carCategoryRepository->findAll();

        // search form
        $searchForm = $this->createFormBuilder()
            ->setAction($this->generateUrl('app_public_search'))
            ->setMethod('post')
            ->add('query', TextType::class, [
                'required' => true,
                'label' => 'Search by name',
                'attr' => [
                    'placeholder' => 'Car name'
                ]
            ])
            ->add('submit', SubmitType::class, [

            ])
            ->getForm();

        return $this->render('public/car/index.html.twig', [
            'cars' => $cars,
            'categories' => $carCategories,
            'selectedCategoryId' => $filterCategoryId,
            'searchForm' => $searchForm,
            'weatherInfo' => $weatherInfo
        ]);
    }

    #[Route('/search', name: 'app_public_search')]
    public function search(
        Request $request,
        CarRepository $carRepository,
    ): Response
    {
        $params = $request->get('form');
        $cars = $carRepository->findByName($params['query']);

        return $this->render('public/car/search.html.twig', [
            'query' => $params['query'],
            'cars' => $cars
        ]);
    }
}
