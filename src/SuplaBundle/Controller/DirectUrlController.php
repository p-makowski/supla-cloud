<?php
/*
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

namespace SuplaBundle\Controller;

use Assert\Assert;
use Assert\Assertion;
use Assert\InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SuplaBundle\Entity\Schedule;
use SuplaBundle\Model\Schedule\ScheduleListQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/direct")
 */
class DirectUrlController extends AbstractController {
    /**
     * @Route("/", methods={"GET"})
     * @Template
     */
    public function directUrlListAction(Request $request) {
        if ($this->expectsJsonResponse()) {
            $query = new ScheduleListQuery($this->getDoctrine());
            $sort = explode('|', $request->get('sort', ''));
            $schedules = $query->getUserSchedules($this->getUser(), $sort);
            return $this->jsonResponse(['data' => $schedules, 'flat']);
        } else {
            return [];
        }
    }
}
