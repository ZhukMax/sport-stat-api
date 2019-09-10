<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * IndexController class
 * @Route("/api", name="api_")
 */
class IndexController extends AbstractController
{
  protected $entityManager;

  /**
   * @Route("/", methods={"GET"})
   *
   * @return JsonResponse
   */
  public function indexAction(): JsonResponse
  {
    return $this->json(['status' => 'ok']);
  }

  protected function setEntityManager()
  {
    $this->entityManager = $this->getDoctrine()->getManager();
  }

  /**
   * Save object in DataBase
   *
   * @param object $object
   * @return integer|null
   */
  protected function save(object $object): ?int
  {
    if (!$this->entityManager) {
      $this->setEntityManager();
    }
    
    $this->entityManager->persist($object);
    $this->entityManager->flush();

    return $object->getId();
  }
}
