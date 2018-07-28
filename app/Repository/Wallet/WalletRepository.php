<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 14/07/2018
 * Time: 12:04 AM
 */

namespace App\Repository\Wallet;

use App\Repository\AbstractRepository;

class WalletRepository extends AbstractRepository
{
    const DEFAULT_WALLET_CASH = 100;

    public function loadWallet($amount = null): void
    {
        $currentAmount = $this->getCurrentContent();

        if (is_null($currentAmount) && ! isset($amount))
        {

            $newAmount = self::DEFAULT_WALLET_CASH;
        }

        if (is_null($currentAmount) && isset($amount))
        {

            $newAmount = $amount;
        }

        if ( ! is_null($currentAmount) && isset($amount))
        {

            $newAmount = $currentAmount + $amount;
        }

        if (isset($newAmount))
        {

            $this->model->setCash($newAmount);
            is_null($currentAmount) ? $this->add($this->model->extract()) : $this->update([$this->model->extract()]);

        }

    }

    private function getCurrentContent(): ?string
    {
        $wallet = $this->fetchAll();

        if ( ! empty($wallet) && isset($wallet[0]))
        {

            $currentContent = $wallet[0]['cash'];
            return $currentContent;
        }
        return null;

    }

    public function unloadWallet($amount): bool
    {
        $currentAmount = $this->getCurrentContent();

        if ($amount > $currentAmount)
        {
            return false;
        }

        $newAmount = $currentAmount - $amount;
        $this->model->setCash($newAmount);
        $this->update([$this->model->extract()]);
        return true;

    }
}
