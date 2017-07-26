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

use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SuplaBundle\Entity\DirectLink;
use SuplaBundle\Entity\IODeviceChannel;
use SuplaBundle\Model\IODeviceManager;
use SuplaBundle\Model\Schedule\ScheduleListQuery;
use SuplaBundle\Model\Transactional;
use Symfony\Component\HttpFoundation\Request;

class DirectLinkController extends AbstractController {
    use Transactional;

    /** @var IODeviceManager */
    private $deviceManager;

    public function __construct(IODeviceManager $deviceManager) {
        $this->deviceManager = $deviceManager;
    }

    /**
     * @Route("/direct/", methods={"GET"})
     * @Template
     */
    public function directLinksListAction(Request $request) {
        if ($this->expectsJsonResponse()) {
            $query = new ScheduleListQuery($this->getDoctrine());
            $sort = explode('|', $request->get('sort', ''));
            $schedules = $query->getUserSchedules($this->getUser(), $sort);
            return $this->jsonResponse(['data' => $schedules, 'flat']);
        } else {
            return [];
        }
    }

    /**
     * @Route("/channel/{channel}/direct")
     * @Method("GET")
     */
    public function getDirectLinksAction(IODeviceChannel $channel) {
        return $this->jsonResponse($channel->getDirectLinks());
    }

    /**
     * @Route("/channel/{channel}/direct/{directLink}")
     * @Method("PUT")
     */
    public function updateDirectLinksAction(DirectLink $directLink, Request $request) {
        $data = $request->request->all();
        $directLink->update($data);
        $this->transactional(function (EntityManagerInterface $entityManager) use ($directLink) {
            $entityManager->persist($directLink);
        });
        return $this->jsonResponse($directLink);
    }

    /**
     * @Route("/channel/{channel}/direct")
     * @Method("POST")
     * @Security("user == channel.getUser()")
     */
    public function createDirectLinkAction(IODeviceChannel $channel) {
        $directLink = new DirectLink($channel);
        $this->transactional(function (EntityManagerInterface $entityManager) use ($directLink) {
            $directLink->generateSlug();
            $entityManager->persist($directLink);
        });
        return $this->jsonResponse($directLink);
    }
}
