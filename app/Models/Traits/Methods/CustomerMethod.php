<?php
/**
 * User: ADMIN
 * Date: 5/9/2019 5:26 PM.
 */

namespace App\Models\Traits\Methods;

trait CustomerMethod
{
    public function yearUpdateCustomer()
    {
        $updatedAtCus = date('Y', strtotime(empty($this->updated_at) ? $this->created_at : $this->updated_at));
//        $dateNow      = date('Y');
        $dateNow      = '2022';
        if ($updatedAtCus !== $dateNow) {
            $this->update([
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $itemVats = $this->itemCats;
            foreach ($itemVats as $itemVat) {
                $itemVat->yearUpdateItemCat();
            }
        }

        return;
    }
}
