<?php

namespace SuplaBundle\Enums;

use MyCLabs\Enum\Enum;
use Symfony\Component\Serializer\Annotation\Groups;

final class ChannelFunction extends Enum {
    const NONE = 0;
    const CONTROLLINGTHEGATEWAYLOCK = 10;
    const CONTROLLINGTHEGATE = 20;
    const CONTROLLINGTHEGARAGEDOOR = 30;
    const THERMOMETER = 40;
    const HUMIDITY = 42;
    const HUMIDITYANDTEMPERATURE = 45;
    const OPENINGSENSOR_GATEWAY = 50;
    const OPENINGSENSOR_GATE = 60;
    const OPENINGSENSOR_GARAGEDOOR = 70;
    const NOLIQUIDSENSOR = 80;
    const CONTROLLINGTHEDOORLOCK = 90;
    const OPENINGSENSOR_DOOR = 100;
    const CONTROLLINGTHEROLLERSHUTTER = 110;
    const OPENINGSENSOR_ROLLERSHUTTER = 120;
    const POWERSWITCH = 130;
    const LIGHTSWITCH = 140;
    const DIMMER = 180;
    const RGBLIGHTING = 190;
    const DIMMERANDRGBLIGHTING = 200;
    const DEPTHSENSOR = 210;
    const DISTANCESENSOR = 220;

    /**
     * @Groups({"basic"})
     */
    public function getPossibleActions(): array {
        return self::actions()[$this->value] ?? [];
    }

    /**
     * @Groups({"basic", "flat"})
     */
    public function getValue() {
        return parent::getValue();
    }

    /**
     * @Groups({"basic", "flat"})
     */
    public function getCaption(): string {
        return self::captions()[$this->value] ?? 'None';
    }

    public static function actions(): array {
        return [
            self::CONTROLLINGTHEGATEWAYLOCK => [ScheduleAction::OPEN()],
            self::CONTROLLINGTHEDOORLOCK => [ScheduleAction::OPEN()],
            self::CONTROLLINGTHEGATE => [ScheduleAction::OPEN(), ScheduleAction::CLOSE()],
            self::CONTROLLINGTHEGARAGEDOOR => [ScheduleAction::OPEN(), ScheduleAction::CLOSE()],
            self::CONTROLLINGTHEROLLERSHUTTER => [ScheduleAction::SHUT(), ScheduleAction::REVEAL(), ScheduleAction::REVEAL_PARTIALLY()],
            self::POWERSWITCH => [ScheduleAction::TURN_ON(), ScheduleAction::TURN_OFF()],
            self::LIGHTSWITCH => [ScheduleAction::TURN_ON(), ScheduleAction::TURN_OFF()],
            self::DIMMER => [ScheduleAction::SET_RGBW_PARAMETERS()],
            self::RGBLIGHTING => [ScheduleAction::SET_RGBW_PARAMETERS()],
            self::DIMMERANDRGBLIGHTING => [ScheduleAction::SET_RGBW_PARAMETERS()],
        ];
    }

    private static function captions(): array {
        return [
            self::CONTROLLINGTHEGATEWAYLOCK => 'Gateway lock operation',
            self::CONTROLLINGTHEGATE => 'Gate operation',
            self::CONTROLLINGTHEGARAGEDOOR => 'Garage door operation',
            self::THERMOMETER => 'Thermometer',
            self::OPENINGSENSOR_GATEWAY => 'Gateway opening sensor',
            self::OPENINGSENSOR_GATE => 'Gate opening sensor',
            self::OPENINGSENSOR_GARAGEDOOR => 'Garage door opening sensor',
            self::NOLIQUIDSENSOR => 'No liquid sensor',
            self::CONTROLLINGTHEDOORLOCK => 'Door lock operation',
            self::OPENINGSENSOR_DOOR => 'Door opening sensor',
            self::CONTROLLINGTHEROLLERSHUTTER => 'Roller shutter operation',
            self::OPENINGSENSOR_ROLLERSHUTTER => 'Roller shutter opening sensor',
            self::POWERSWITCH => 'On/Off switch',
            self::LIGHTSWITCH => 'Light switch',
            self::HUMIDITY => 'Humidity sensor',
            self::HUMIDITYANDTEMPERATURE => 'Temperature and humidity sensor',
            self::DIMMER => 'Dimmer',
            self::RGBLIGHTING => 'RGB lighting',
            self::DIMMERANDRGBLIGHTING => 'Dimmer and RGB lighting',
            self::DISTANCESENSOR => 'Distance sensor',
            self::DEPTHSENSOR => 'Depth sensor',
        ];
    }
}
