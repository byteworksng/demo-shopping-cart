<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 14/07/2018
 * Time: 11:21 AM
 */

namespace App\Http\Controller\Wallet;

use App\Http\Controller\BaseController as Controller;
use App\Interfaces\RepositoryInterface;

class WalletController extends Controller
{
    private $walletRepository;

    public function __construct(RepositoryInterface $wallet)
    {
        $this->walletRepository = $wallet;
        $this->walletRepository->loadWallet();
    }

    public function fetchWallet()
    {
        $amount = $this->walletRepository->fetchAll();
        return $amount[0];
    }
}
