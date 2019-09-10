<?php
namespace App\Controller;

use App\Entity\SportTeam;
use App\Entity\SportType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * SportTeamController class
 * @Route("/api", name="api_")
 */
class SportTeamController extends IndexController
{
  /**
   * @Route("/sport-teams", methods={"GET"})
   *
   * @return JsonResponse
   */
  public function getAction(): JsonResponse
  {
    $repository = $this->getDoctrine()->getRepository(SportTeam::class);

    return $this->json([
      'status' => 'ok',
      'sport-teams' => $repository->findAll()
    ]);
  }

  /**
   * @Route("/sport-teams", methods={"POST"})
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function createAction(Request $request): JsonResponse
  {
    $sportTypeController = new SportTypeController();
    $sportType = $sportTypeController->getOrCreate($request['sport']);

    $repository = $this->getDoctrine()->getRepository(SportTeam::class);
    $sportTeamId = $this->create($request['title'], $sportType);
    
    return $this->json([
      'status' => 'ok',
      'sport-team' => $repository->find($sportTeamId)
    ]);
  }

  /**
   * Create a new SportTeam object and save in DataBase
   *
   * @param string $title
   * @return integer|null
   */
  private function create(string $title, SportType $sportType): ?int
  {
    $sportTeam = new SportTeam();
    $sportTeam->setTitle($title);
    $sportTeam->setSport($sportType);

    return $this->save($sportTeam);
  }

  /**
   * Get or create and thet get SportTeam object
   *
   * @param string $title
   * @return SportTeam
   */
  public function getOrCreate(string $title, SportType $sportType): SportTeam
  {
    $repository = $this->getDoctrine()->getRepository(SportTeam::class);
    if ($sportTeam = $repository->findOneBy(['title' => $title])) {
      return $sportTeam;
    }

    if ($sportTeam = $repository->findOneBySynonyms($title)) {
      return $sportTeam;
    }

    $sportTeamId = $this->create($title, $sportType);
    return $repository->find($sportTeamId);
  }
}
