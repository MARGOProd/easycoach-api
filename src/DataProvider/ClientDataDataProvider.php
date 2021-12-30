<?php
namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\Filter\Validator\Length;
use App\Entity\ClientData;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\DBAL\DriverManager;

class ClientDataDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface, CollectionDataProviderInterface
{
    private $security;
    private $managerRegistry;

    public function __construct($mysqlConnection, ManagerRegistry $managerRegistry, EntityManagerInterface $em, Security $security)
    {
        $this->mysqlConnection = $mysqlConnection;
        $this->managerRegistry = $managerRegistry;
        $this->em = $em;
        $this->security = $security;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return ClientData::class === $resourceClass;
    }

    /**
     * Récupération d'un item ClientData
     *
     * @param string    $resourceClass
     * @param integer   $id
     * @param string    $operationName
     * @param array     $context
     * @return mixed
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        
    }

    /**
     * Appelé pour la récupération d'une collection de ClientData
     *
     * @param string $resourceClass
     * @param string $operationName
     * @param array $context
     * 
     * @return array
     */
    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {

        // Récupere l'utilisateur courant 
        $currentUser = $this->security->getUser();
        $listContactIds = [];

        $filters = [];
        if (isset($context["filters"])) {
            $filters = $context["filters"];
        }

        $connectionParams = array(
            'url' => $this->mysqlConnection,
        );
        $conn = DriverManager::getConnection($connectionParams );
        if(!empty($filters))
        {
            $sql = 'SELECT serie.id as libelle, serie.id as id, "serie" as type 
            FROM serie 
            WHERE id IN(
                SELECT seance.id
                FROM seance
                WHERE seance.client_id = :userid
            )';
            // -- UNION SELECT client.nom as libelle, client.id as id, "client" as type 
            // -- FROM client 
            // -- WHERE nom = :clientnom or prenom = :clientprenom and client.user_id = :userid';
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':userid', $filters['client']);
            // $stmt->bindValue(':usernom', $filters['search']);
            // $stmt->bindValue(':userprenom', $filters['search']);
            // $stmt->bindValue('clientnom', $filters['search']);
            // $stmt->bindValue('clientprenom', $filters['search']);
            $resultSet = $stmt->executeQuery();
    
            $i=0;
            foreach ($resultSet->fetchAllAssociative() as $row) {
                $element = new ClientData();
                $element->setId($i);
                $element->setResourceId($row['id']);
                $element->setLibelle($row['libelle']);
                $element->setType($row['type']);
                $listContactIds[]=$element;
                $i++;
            }
        }

        return $listContactIds;
        
    }
}


// $sql = 'SELECT user.nom as libelle, user.id as id, "user" as type 
//             FROM user 
//             WHERE nom = :usernom or prenom = :userprenom and user.id = :userid
//             UNION SELECT client.nom as libelle, client.id as id, "client" as type 
//             FROM client 
//             WHERE nom = :clientnom or prenom = :clientprenom and client.user_id = :userid';