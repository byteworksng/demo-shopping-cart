<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 07/07/2018
 * Time: 1:20 AM
 */

namespace App\Http\Controller\Rating;

use App\Http\Controller\BaseController as Controller;
use App\Interfaces\RepositoryInterface;

class RatingController extends Controller
{
    private $ratingRepo;

    public function __construct(RepositoryInterface $rating)
    {
        $this->ratingRepo = $rating;
    }

    public function add()
    {

        $rate = $_POST['rating'];
        $productId = $_POST['product'];
        return $this->ratingRepo->add(compact('rate', 'productId'));

    }

    public function getAvg($id)
    {
        return $this->ratingRepo->getRatingAvg($id);

    }
}
