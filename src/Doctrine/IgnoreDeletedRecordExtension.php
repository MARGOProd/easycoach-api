<?php
namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Doctrine\ORM\QueryBuilder;

/**
 * Ajoute un filtre sur la récupération de toutes les entités qui ont une propriété "deleted"
 *  - les catégories
 *  - les "ViewCatalogueProduit" (les produits)
 */
final class IgnoreDeletedRecordExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null): void
    {
        $this->addWhere($queryBuilder, $queryNameGenerator, $resourceClass, $operationName );
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $queryNameGenerator, $resourceClass, $operationName );
    }

    public function addWhere(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        $rootAlias = $queryBuilder->getRootAliases()[0];
        if (property_exists($resourceClass, 'deleted')) {
            $queryBuilder->andWhere($rootAlias.'.deleted !=1 '); 

            // dump($queryBuilder->getQuery()->getSQL());
            // exit();
        }
    }

}