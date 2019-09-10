<?php
namespace App\Controller;

use App\Entity\Source;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * SourceController class
 * @Route("/api", name="api_")
 */
class SourceController extends IndexController
{
  /**
   * @Route("/sources", methods={"GET"})
   *
   * @return JsonResponse
   */
  public function getAction(): JsonResponse
  {
    $repository = $this->getDoctrine()->getRepository(Source::class);

    return $this->json([
      'status' => 'ok',
      'sources' => $repository->findAll()
    ]);
  }

  /**
   * @Route("/sources", methods={"POST"})
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function createAction(Request $request): JsonResponse
  {
    $repository = $this->getDoctrine()->getRepository(Source::class);
    $sourceId = $this->create($request['title']);
    return $this->json([
      'status' => 'ok',
      'source' => $repository->find($sourceId)
    ]);
  }

  /**
   * Create a new Source object and save in DataBase
   *
   * @param string $title
   * @return integer|null
   */
  private function create(string $title): ?int
  {
    $source = new Source();
    $source->setTitle($title);

    return $this->save($source);
  }

  /**
   * Get or create and thet get Source object
   *
   * @param string $title
   * @return Source
   */
  public function getOrCreate(string $title): Source
  {
    if ($source = $this->getByTitle($title)) {
      return $source;
    }

    $repository = $this->getDoctrine()->getRepository(Source::class);
    $sourceId = $this->create($title);
    return $repository->find($sourceId);
  }

  /**
   * Try to find source
   *
   * @param string $title
   * @return Source|null
   */
  public function getByTitle(string $title): ?Source
  {
    $repository = $this->getDoctrine()->getRepository(Source::class);
    if ($source = $repository->findOneBy(['title' => $title])) {
      return $source;
    }

    if ($source = $repository->findOneBySynonyms($title)) {
      return $source;
    }

    return null;
  }
}
