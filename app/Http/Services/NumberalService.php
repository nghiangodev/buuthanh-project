<?php

namespace App\Http\Services;

use App\Models\Customer;
use App\Models\ItemCat;
use App\Models\Numberal;
use App\Models\User;

class NumberalService implements IBaseService
{
    public function store(array $datas)
    {
        //note luu customer
        $customer = Customer::create([
            'name'    => $datas['name'],
            'dob'     => date('Y-m-d', strtotime($datas['dob'])),
            'phone'   => $datas['phone'],
            'address' => $datas['address'],
        ]);
        $numberal = Numberal::create([
            'name'        => $datas['name'],
            'customer_id' => $customer->id,
        ]);

        $numberal->saveDetail($datas['itemCats'], ItemCat::class, 'itemCats', [
            'customer_id' => $customer->id,
            'numberal_id' => $numberal->id,
        ]);
//        $numberal->saveItemCats($datas['itemCats'],ItemCat::class,'itemCats', $customer->id, $numberal->id);
    }

    /**
     * @param array $datas
     * @param Numberal $numberal
     *
     * @return mixed|void
     */
    public function update(array $datas, $numberal)
    {
        $customer = Customer::find($datas['customer_id']);
        $customer->update([
            'name'    => $datas['name'],
            'dob'     => date('Y-m-d', strtotime($datas['dob'])),
            'phone'   => $datas['phone'],
            'address' => $datas['address'],
        ]);

        $numberal->update([
            'name' => $datas['name'],
        ]);
        $numberal->saveDetail($datas['itemCats'], ItemCat::class, 'itemCats', [
            'customer_id' => $customer->id,
            'numberal_id' => $numberal->id,
        ]);
    }

    /**
     * @param User $user
     *
     * @return mixed
     * @throws \Exception
     */
    public function delete($user)
    {
        return $user->delete();
    }
}
