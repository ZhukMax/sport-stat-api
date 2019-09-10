<?php
namespace App\Controller;

use App\Entity\Language;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * LanguageController class
 * @Route("/api", name="api_")
 */
class LanguageController extends IndexController
{
  /**
   * @Route("/languages", methods={"GET"})
   *
   * @return JsonResponse
   */
  public function getAction(): JsonResponse
  {
    $repository = $this->getDoctrine()->getRepository(Language::class);

    return $this->json([
      'status' => 'ok',
      'languages' => $repository->findAll()
    ]);
  }

  /**
   * @Route("/languages", methods={"POST"})
   *
   * @param Request $request
   * @return JsonResponse
   */
  public function createAction(Request $request): JsonResponse
  {
    $repository = $this->getDoctrine()->getRepository(Language::class);
    $languageId = $this->create($request['title']);
    return $this->json([
      'status' => 'ok',
      'language' => $repository->find($languageId)
    ]);
  }

  /**
   * Create a new Language object and save in DataBase
   *
   * @param string $title
   * @return integer|null
   */
  private function create(string $title): ?int
  {
    $language = new Language();
    $language->setTitle($title);

    return $this->save($language);
  }

  /**
   * Get or create and thet get Language object
   *
   * @param string $title
   * @return Language
   */
  public function getOrCreate(string $title): Language
  {
    $repository = $this->getDoctrine()->getRepository(Language::class);
    if ($language = $repository->findOneBy(['title' => $title])) {
      return $language;
    }

    if ($language = $repository->findOneBySynonyms($title)) {
      return $language;
    }

    $languageId = $this->create($title);
    return $repository->find($languageId);
  }
}
