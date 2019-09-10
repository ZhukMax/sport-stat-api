<?php
namespace App\Controller;

use App\Entity\SportType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * SportTypeController class
 * @Route("/api", name="api_")
 */
class SportTypeController extends IndexController
{
  /**
   * @Route("/sport-types", methods={"GET"})
   *
   * @return JsonResponse
   */
  public function getAction(): JsonResponse
  {
    $repository = $this->getDoctrine()->getRepository(SportType::class);

    return $this->json([
      'status' => 'ok',
      'sport-types' => $repository->findAll()
    ]);
  }

  /**
   * @Route("/sport-types", methods={"POST"})
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function createAction(Request $request): JsonResponse
  {
    $repository = $this->getDoctrine()->getRepository(SportType::class);
    $sportTypeId = $this->create($request['title']);
    return $this->json([
      'status' => 'ok',
      'sport-type' => $repository->find($sportTypeId)
    ]);
  }

  /**
   * Create a new SportType object and save in DataBase
   *
   * @param string $title
   * @return integer|null
   */
  private function create(string $title): ?int
  {
    $sportType = new SportType();
    $sportType->setTitle($title);

    return $this->save($sportType);
  }

  /**
   * Get or create and thet get SportType object
   *
   * @param string $title
   * @return SportType
   */
  public function getOrCreate(string $title): SportType
  {
    $repository = $this->getDoctrine()->getRepository(SportType::class);
    if ($sportType = $repository->findOneBy(['title' => $title])) {
      return $sportType;
    }

    if ($sportType = $repository->findOneBySynonyms($title)) {
      return $sportType;
    }

    $sportTypeId = $this->create($title);
    return $repository->find($sportTypeId);
  }
}
