<?php
namespace App\Controller;

use App\Entity\League;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * LeagueController class
 * @Route("/api", name="api_")
 */
class LeagueController extends IndexController
{
  /**
   * @Route("/leagues", methods={"GET"})
   *
   * @return JsonResponse
   */
  public function getAction(): JsonResponse
  {
    $repository = $this->getDoctrine()->getRepository(League::class);

    return $this->json([
      'status' => 'ok',
      'leagues' => $repository->findAll()
    ]);
  }

  /**
   * @Route("/leagues", methods={"POST"})
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function createAction(Request $request): JsonResponse
  {
    $repository = $this->getDoctrine()->getRepository(League::class);
    $leagueId = $this->create($request['title']);
    return $this->json([
      'status' => 'ok',
      'league' => $repository->find($leagueId)
    ]);
  }

  /**
   * Create a new League object and save in DataBase
   *
   * @param string $title
   * @return integer|null
   */
  private function create(string $title): ?int
  {
    $league = new League();
    $league->setTitle($title);

    return $this->save($league);
  }

  /**
   * Get or create and thet get League object
   *
   * @param string $title
   * @return League
   */
  public function getOrCreate(string $title): League
  {
    $repository = $this->getDoctrine()->getRepository(League::class);
    if ($league = $repository->findOneBy(['title' => $title])) {
      return $league;
    }

    if ($league = $repository->findOneBySynonyms($title)) {
      return $league;
    }

    $leagueId = $this->create($title);
    return $repository->find($leagueId);
  }
}
