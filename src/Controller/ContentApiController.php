<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Context\Normalizer\DateTimeNormalizerContextBuilder;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Content;
use App\Entity\ContentRow;
use App\Repository\ContentRepository;
use App\Entity\User;

final class ContentApiController extends AbstractController
{
    public function __construct(
        protected ContentRepository $contentRepository,
        protected SerializerInterface $serializer,
        protected EntityManagerInterface $entityManager,
    ){}

    #[Route('/api/content', name: 'content_listing',  methods: ['GET'])]
    public function index(): Response
    {
        $entities = $this->contentRepository->findBy([],['sort_order' => 'ASC']);

        $contextBuilder = (new DateTimeNormalizerContextBuilder())
            ->withFormat('Y-m-d H:i:s');

        $context = $contextBuilder->toArray();
        $context['circular_reference_handler'] = function ($object) { return $object->getId(); };

        return JsonResponse::fromJsonString($this->serializer->serialize($entities, 'json', $context));
    }

    #[Route('/api/content/{slug}', name: 'content_get_by_slug',  methods: ['GET'])]
    public function getBySlug(Request $request): Response
    {
        $slug = $request->get('slug');
        $entity = $this->contentRepository->findOneBy(['slug' => $slug]);

        $contextBuilder = (new DateTimeNormalizerContextBuilder())
            ->withFormat('Y-m-d H:i:s');

        $context = $contextBuilder->toArray();
        $context['circular_reference_handler'] = function ($object) {
            return $object->getId();
        };

        return JsonResponse::fromJsonString($this->serializer->serialize(
            $entity,
            'json',
            $context
        ));
    }

    #[Route('/admin/api/content/{id}', name: 'content_get',  methods: ['GET'])]
    public function get(#[CurrentUser] User $user, Request $request): Response
    {
//        if ('json' !== $request->getContentTypeFormat()) {
//            throw new BadRequestException('Unsupported content format');
//        }

        $id =  (int) $request->get('id');
        $entity = $this->contentRepository->find($id);

        $contextBuilder = (new DateTimeNormalizerContextBuilder())
            ->withFormat('Y-m-d H:i:s');

        $context = $contextBuilder->toArray();
        $context['circular_reference_handler'] = function ($object) { return $object->getId(); };

        return JsonResponse::fromJsonString($this->serializer->serialize($entity, 'json', $context));
    }

    #[Route('/admin/api/content', name: 'content_create',  methods: ['POST'])]
    public function create(#[CurrentUser] User $user, Request $request): Response
    {
        if ('json' !== $request->getContentTypeFormat()) {
            throw new BadRequestException('Unsupported content format');
        }

        //$entity = $this->serializer->deserialize($request->getContent(), Content::class, 'json');
        $entity = new Content();
        $entity->setCreatedAt(new \DateTimeImmutable('now'));

        $this->serializer->deserialize($request->getContent(), Content::class, 'json', [
            AbstractNormalizer::OBJECT_TO_POPULATE => $entity,
        ]);

        if ($entity->getContentRows()->count() > 0) {
            foreach($entity->getContentRows() as $contentRow) {
                $contentRow->setContent($entity);
                if ($contentRow->getContentRowParts()->count() > 0) {
                    foreach($contentRow->getContentRowParts() as $contentRowPart) {
                        $contentRowPart->setContentRow($contentRow);
                    }
                }
            }
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        $this->entityManager->refresh($entity);

        $contextBuilder = (new DateTimeNormalizerContextBuilder())
            ->withFormat('Y-m-d H:i:s');

        $context = $contextBuilder->toArray();
        $context['circular_reference_handler'] = function ($object) { return $object->getId(); };

        return JsonResponse::fromJsonString($this->serializer->serialize($entity, 'json', $context));
    }

    #[Route('/admin/api/content/{id}', name: 'content_update',  methods: ['POST','PUT'])]
    public function update(#[CurrentUser] User $user, Request $request): Response
    {
        if ('json' !== $request->getContentTypeFormat()) {
            throw new BadRequestException('Unsupported content format');
        }

        $id =  (int) $request->get('id');
        $entity = $this->contentRepository->find($id);

        $this->serializer->deserialize($request->getContent(), Content::class, 'json', [
            AbstractNormalizer::OBJECT_TO_POPULATE => $entity,
        ]);

        if ($entity->getContentRows()->count() > 0) {
            foreach($entity->getContentRows() as $contentRow) {
                $contentRow->setContent($entity);
                if ($contentRow->getContentRowParts()->count() > 0) {
                    foreach($contentRow->getContentRowParts() as $contentRowPart) {
                        $contentRowPart->setContentRow($contentRow);
                    }
                }
            }
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        $this->entityManager->refresh($entity);

        $contextBuilder = (new DateTimeNormalizerContextBuilder())
            ->withFormat('Y-m-d H:i:s');

        $context = $contextBuilder->toArray();
        $context['circular_reference_handler'] = function ($object) { return $object->getId(); };

        return JsonResponse::fromJsonString($this->serializer->serialize($entity, 'json', $context));
    }

    #[Route('/admin/api/content/{id}', name: 'content_delete',  methods: ['DELETE'])]
    public function delete(#[CurrentUser] User $user, Request $request): Response
    {
        if ('json' !== $request->getContentTypeFormat()) {
            throw new BadRequestException('Unsupported content format');
        }

        $id = (int)$request->get('id');
        $entity = $this->contentRepository->find($id);
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
        return $this->json(['success' => true]);
    }
}
