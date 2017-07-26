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

namespace SuplaBundle\Entity;

use Assert\Assertion;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints;

/**
 * TODO indexes
 * TODO encoder
 * @ORM\Entity
 * @ORM\Table(name="supla_direct_link")
 */
class DirectLink {
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"basic", "flat"})
     */
    private $id;

    /**
     * @ORM\Column(name="slug", type="string", nullable=false, length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(name="caption", type="string", length=255, nullable=true)
     * @Constraints\Length(max=255)
     * @Groups({"basic", "flat"})
     */
    private $caption;

    /**
     * @ORM\ManyToOne(targetEntity="IODeviceChannel", inversedBy="directLinks")
     * @ORM\JoinColumn(name="channel_id", referencedColumnName="id", nullable=false)
     * @Constraints\NotNull
     * @Groups({"basic"})
     */
    private $channel;

    /**
     * @ORM\Column(name="allowed_actions", type="string", nullable=false, length=255)
     * @Groups({"basic"})
     */
    private $allowedActions;

    /**
     * @ORM\Column(name="active_from", type="utcdatetime", nullable=true)
     * @Groups({"basic", "flat"})
     */
    private $activeFrom;

    /**
     * @ORM\Column(name="active_to", type="utcdatetime", nullable=true)
     * @Groups({"basic", "flat"})
     */
    private $activeTo;

    /**
     * @ORM\Column(name="executions_limit", type="integer", nullable=true)
     * @Groups({"basic", "flat"})
     */
    private $executionsLimit;

    /**
     * @ORM\Column(name="last_used", type="utcdatetime", nullable=true)
     * @Groups({"basic", "flat"})
     */
    private $lastUsed;

    /**
     * @ORM\Column(name="last_ipv4", type="integer", nullable=true)
     * @Groups({"basic", "flat"})
     */
    private $lastIpv4;

    /**
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     * @Groups({"basic", "flat"})
     */
    protected $enabled = true;

    public function __construct(IODeviceChannel $channel) {
        $this->user = $channel->getUser();
        $this->channel = $channel;
        $this->setAllowedActions([]);
    }

    /** @return int */
    public function getId() {
        return $this->id;
    }

    /** @return string */
    public function getCaption() {
        return $this->caption;
    }

    public function getChannel(): IODeviceChannel {
        return $this->channel;
    }

    /** @return mixed */
    public function getActiveFrom() {
        return $this->activeFrom;
    }

    /**
     * @return mixed
     */
    public function getActiveTo() {
        return $this->activeTo;
    }

    /**
     * @return mixed
     */
    public function getExecutionsLimit() {
        return $this->executionsLimit;
    }

    /**
     * @return mixed
     */
    public function getLastUsed() {
        return $this->lastUsed;
    }

    /**
     * @return mixed
     */
    public function getLastIpv4() {
        return $this->lastIpv4;
    }

    /**
     * @return mixed
     */
    public function isEnabled(): bool {
        return $this->enabled;
    }


    public function generateSlug() {
        Assertion::null($this->slug);
        $this->slug = bin2hex(random_bytes(16));
        return $this->slug;
    }

    public function setAllowedActions(array $allowedActions) {
        $this->allowedActions = json_encode($allowedActions);
    }

    public function getAllowedActions(): array {
        $actions = json_decode($this->allowedActions, true);
        return $actions ? $actions : [];
    }

    public function canBeUsed(): bool {
        return $this->isEnabled();
    }

    public static function create(array $data): DirectLink {
        $directLink = new self();
        Assertion::keyExists($data, 'channel');
        Assertion::isInstanceOf($data['channel'], IODeviceChannel::class);
        $directLink->channel = $data['channel'];
        $directLink->caption = $data['caption'] ?? null;
        return $directLink;
//        Assert::that($data)->notEmptyKey('timeExpression');
//        $this->setTimeExpression($data['timeExpression']);
//        $this->setAction(new ScheduleAction($data['action'] ?? ScheduleAction::TURN_ON));
//        $this->setActionParam($data['actionParam'] ?? null);
//        $this->setChannel($data['channel'] ?? null);
//      $this->setDateStart(empty($data['dateStart']) ? new \DateTime() : \DateTime::createFromFormat(\DateTime::ATOM, $data['dateStart']));
//        $this->setDateEnd(empty($data['dateEnd']) ? null : \DateTime::createFromFormat(\DateTime::ATOM, $data['dateEnd']));
//        $this->setMode(new ScheduleMode($data['scheduleMode']));
//        $this->setCaption($data['caption'] ?? null);
    }

    public function update(array $data) {
        $this->enabled = $data['enabled'] ?? false;
        $this->setAllowedActions($data['allowedActions'] ?? []);
    }

    public function verifySlug(string $hashedSlug) {
        return strcmp($this->slug, $hashedSlug) === 0;
    }
}
