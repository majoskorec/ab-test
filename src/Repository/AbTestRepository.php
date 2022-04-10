<?php

declare(strict_types=1);

namespace App\Repository;

use App\AbTest\Model\Stats;
use App\Entity\AbTest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends EntityRepository<AbTest>
 */
final class AbTestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbTest::class);
    }

    public function getStats(): Stats
    {
        try {
            $data = $this->_em->createQueryBuilder()
                ->select('count(ab.id) as count, COALESCE(sum(ab.abTest), 0) as sumTest')
                ->from(AbTest::class, 'ab')
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException|NonUniqueResultException) {
            $data = [
                'count' => 0,
                'sumTest' => 0,
            ];
        }

        return new Stats((int)$data['sumTest'], $data['count']-(int)$data['sumTest']);
    }
}
