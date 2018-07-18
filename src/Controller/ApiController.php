<?php

namespace App\Controller;

use App\Repository\RequestRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Request as RequestEntity;

/** @Route("/api") */
class ApiController extends Controller
{
    /** @var EntityManager */
    private $entityManager;

    /** @var RequestRepository */
    private $requestRepository;

    public function __construct(EntityManagerInterface $entityManager, RequestRepository $requestRepository)
    {
        $this->entityManager = $entityManager;
        $this->requestRepository = $requestRepository;
    }

    /**
     * @Route("/create")
     * @param Request $request
     * @return JsonResponse
     */
    public function addAction(Request $request): JsonResponse
    {
        try {
            $requestEntity = new RequestEntity();
            $requestEntity->setHeaders($request->headers->all());
            $requestEntity->setIp($request->getClientIp());
            $requestEntity->setMethod($request->getMethod());
            $requestEntity->setRoute($request->getUri());
            $requestEntity->setBody($request->getContent() ?? '');

            $this->entityManager->persist($requestEntity);
            $this->entityManager->flush();
        } catch (\Throwable $t) {
            return JsonResponse::create(
                ['success' => 'false', 'errors' => $t->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return JsonResponse::create([['success' => 'true', 'id' => $requestEntity->getId()]]);
    }

    /**
     * @Route("/retrieve")
     * @param Request $request
     * @Method("GET")
     * @return JsonResponse
     */
    public function retrieveAction(Request $request): JsonResponse
    {
        $criteria = [
            'id' => $request->get('id'),
            'route' => $request->get('route'),
            'method' => $request->get('method'),
            'ip' => $request->get('ip'),
        ];

        $rows = $this->requestRepository->findAllAsArray($criteria);

        return JsonResponse::create($rows);
    }
}
