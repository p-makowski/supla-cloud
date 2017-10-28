<?php
/*
 Copyright (C) AC SOFTWARE SP. Z O.O.
 
 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License
 as published by the Free Software Foundation; either version 2
 of the License, or (at your option) any later version.
 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace SuplaWebApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use SuplaBundle\Entity\User;

/**
 * @Rest\Version("v2")
 */
class ApiIODeviceController extends FOSRestController {
//    /**
//     * @Response(
//     *     response=200,
//     *     description="Returns the list of devices",
//     *     @Schema(
//     *         type="array",
//     *         @Model(type=\SuplaBundle\Entity\IODevice::class, groups={"basic"})
//     *     )
//     * )
//     */
    /**
     * Returns a list of IO devices added to the authorized account without their connection status.
     *
     * @ApiDoc(
     *   output = {"class" = "SuplaBundle\Entity\IODevice", "collection" = true, "groups" = {"basic"}}
     * )
     */
    public function getIodevicesAction() {
        /** @var User $user */
        $user = $this->getUser();
        return $this->view($user->getIODevices(), 200);
    }
}
