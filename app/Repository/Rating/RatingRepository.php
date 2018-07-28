<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 07/07/2018
 * Time: 1:07 AM
 */

namespace App\Repository\Rating;

use App\Interfaces\GatewayInterface;
use App\Interfaces\ModelInterface;
use App\Repository\AbstractRepository;

class RatingRepository extends AbstractRepository
{

    protected $sessionGateway;

    public function __construct(GatewayInterface $tableGateway, GatewayInterface $sessionGateway, ModelInterface $model)
    {
        $this->sessionGateway = $sessionGateway;
        parent::__construct($tableGateway, $model);
    }

    public function getRatingAvg($productId)
    {
        $table = $this->tableGateway->getTable();
        $sql = "SELECT AVG(rate) AS rateAvg FROM $table WHERE productId = ?";

        $result = $this->tableGateway->rawSql($sql, [$productId])->fetch(\PDO::FETCH_OBJ);
        return round($result->rateAvg, 1);
    }

    public function add(array $param, $closeSession = false)
    {
        $param = array_filter($this->parseData($this->model, $param));

        if ( ! $this->isRated($param['productId']))
        {
            $this->sessionGateway->insert($param);
            return parent::add($param);
        }

        return false;

    }

    public function isRated($product)
    {


        $rated = $this->sessionGateway->select(['productId' => $product]);

        return (bool) count($rated);
    }
}
