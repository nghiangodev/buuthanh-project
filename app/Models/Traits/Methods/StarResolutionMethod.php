<?php
/**
 * User: ADMIN
 * Date: 5/9/2019 5:26 PM.
 */

namespace App\Models\Traits\Methods;

trait StarResolutionMethod
{
    public function yearUpdateStarResolution()
    {
        $calculateStarResolution = $this->id % 9;
        switch ($calculateStarResolution) {
            case 1:
                $updateStarResolutionId = 2;
                break;
            case 2:
                $updateStarResolutionId = 3;
                break;
            case 3:
                $updateStarResolutionId = 4;
                break;
            case 4:
                $updateStarResolutionId = 5;
                break;
            case 5:
                $updateStarResolutionId = 6;
                break;
            case 6:
                $updateStarResolutionId = 7;
                break;
            case 7:
                $updateStarResolutionId = 8;
                break;
            case 8:
                $updateStarResolutionId = 9;
                break;
            default:
                $updateStarResolutionId = 1;
        }

        return $updateStarResolutionId;
    }
}
