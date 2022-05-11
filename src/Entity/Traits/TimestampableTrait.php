<?php
namespace App\Entity\Traits;
 
use ApiPlatform\Core\Annotation\ApiProperty;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
 
trait TimestampableTrait
{
   /**
    * @var datetime $createdAt
    *
    * @Gedmo\Timestampable(on="create")
    * @ORM\Column(name="created_at", type="datetime")
    * @ApiProperty(push=false)
    */
   private $createdAt;
 
//    /**
//     * @var datetime $updatedAt
//     *
//     * @Gedmo\Timestampable(on="update")
//     * @ORM\Column(name="updated_at", type="datetime")
//     */
//    private $updatedAt;
 
   /**
    * Get createdAt
    *
    * @return datetime
    */
   public function getCreatedAt()
   {
       return $this->createdAt;
   }
 
   /**
    * Set createdAt
    *
    * @param datetime $createdAt
    */
   public function setCreatedAt($createdAt)
   {
       $this->createdAt = $createdAt;
       return $this;
   }
 
//    /**
//     * Get updatedAt
//     *
//     * @return datetime
//     */
//    public function getUpdatedAt()
//    {
//        return $this->updatedAt;
//    }
 
//    /**
//     * Set updatedAt
//     *
//     * @param datetime $updatedAt
//     */
//    public function setUpdatedAt($updatedAt)
//    {
//        $this->updatedAt = $updatedAt;
//        return $this;
//    }
}

