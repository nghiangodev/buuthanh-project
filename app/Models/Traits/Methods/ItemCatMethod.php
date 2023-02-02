<?php
/**
 * User: ADMIN
 * Date: 5/9/2019 5:26 PM.
 */

namespace App\Models\Traits\Methods;

use App\Models\StarResolution;

trait ItemCatMethod
{
    public function yearUpdateItemCat()
    {
        $age = $this->age + 1;
        /** @var StarResolution $starResolution */
        $starResolution = $this->starResolution;
        $this->update([
            'age'                => $age,
            'star_resolution_id' => $starResolution->yearUpdateStarResolution(),
        ]);

    }
}
