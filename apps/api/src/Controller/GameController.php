<?php
namespace App\Controller;

use App\Entity\Game;
use App\Entity\GameBuffer;
use App\Exceptions\ApiException as Exception;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * GameController class
 * @Route("/api", name="api_")
 */
class GameController extends IndexController
{
  private $validator;

  /**
   * @Route("/games", methods={"GET"})
   *
   * @return JsonResponse
   */
  public function getRandAction(Request $request): JsonResponse
  {
    $sourceTitle = (string) $request->request->get('source');
    $sourceController = new SourceController();
    $source = $sourceController->getByTitle($sourceTitle);

    $gameRepository = $this->getDoctrine()->getRepository(Game::class);
    $game = $gameRepository->findRandOne(['source' => $source->id]);

    if ($game) {
      return $this->json([
        'status' => 'ok',
        'game' => $game
      ]);
    } else {
      return $this->json([
        'status' => 'error',
        'message' => 'Can find no one game'
      ]);
    }
  }

  /**
   * @Route("/games", methods={"POST"})
   *
   * @return JsonResponse
   */
  public function saveAction(Request $request, ValidatorInterface $validator): JsonResponse
  {
    $this->validator = $validator;

    $games = json_decode($request->request->get('games'), true);
    foreach ($games as $game) {
      try {
        $gameBufferId = $this->create($game);
        $this->merge($gameBufferId);
      } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
      }
    }

    return $this->json(['status' => 'ok']);
  }

  /**
   * Create new GameBuffer object and save it in DataBase
   *
   * @param array $data
   * @return integer|null
   * @throws Exception
   */
  private function create(array $data): ?int
  {
    $gameBuffer = new GameBuffer();

    $languageController = new LanguageController();
    $gameBuffer->setLanguage($languageController->getOrCreate($data['language']));

    $leagueController = new LeagueController();
    $gameBuffer->setLeague($leagueController->getOrCreate($data['league']));

    $sourceController = new SourceController();
    $gameBuffer->setSource($sourceController->getOrCreate($data['source']));

    $sportTypeController = new SportTypeController();
    $sportType = $sportTypeController->getOrCreate($data['sport']);
    $gameBuffer->setSport($sportType);

    $sportTeamController = new SportTeamController();
    $gameBuffer->setTeamOne($sportTeamController->getOrCreate($data['team-one'], $sportType));
    $gameBuffer->setTeamTwo($sportTeamController->getOrCreate($data['team-two'], $sportType));

    $startAt = new DateTime($data['start-at']);
    $gameBuffer->setStartAt($startAt);

    // Validation
    $errors = $this->validator->validate($gameBuffer);
    if (count($errors) > 0) {
      throw new Exception((string) $errors);
    }

    return $this->save($gameBuffer);
  }

  /**
   * @todo Add new Game object and set it like base game
   *
   * @param integer $gameBufferId
   * @return void
   */
  private function merge(int $gameBufferId): void
  {
    $gameBufferRepository = $this->getDoctrine()->getRepository(GameBuffer::class);
    $gameBuffer = $gameBufferRepository->find($gameBufferId);

    // Try to find the game in DB
    $gameRepository = $this->getDoctrine()->getRepository(Game::class);
    $game = $gameRepository->findUniq([
      'teamone' => $gameBuffer->getTeamOne(),
      'teamtwo' => $gameBuffer->getTeamTwo(),
      'time' => $gameBuffer->getStartAt()
    ]);

    if ($game) {
      $gameBuffer->setBaseGame($game);
    } else {
      // Add new Game object
    }
  }
}
