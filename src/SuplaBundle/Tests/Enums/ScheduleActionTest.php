<?php
namespace SuplaBundle\Tests\Enums;

use Assert\InvalidArgumentException;
use SuplaBundle\Enums\ChannelFunctionAction;

class ScheduleActionTest extends \PHPUnit_Framework_TestCase {
    /**
     * @dataProvider validatingActionParamsProvider
     */
    public function testValidatingActionParams(ChannelFunctionAction $action, $actionParams, bool $expectValid) {
        if (!$expectValid) {
            $this->expectException(InvalidArgumentException::class);
        }
        $action->validateActionParam($actionParams);
    }

    public function validatingActionParamsProvider() {
        return [
            [ChannelFunctionAction::REVEAL_PARTIALLY(), ['percentage' => 0], true],
            [ChannelFunctionAction::REVEAL_PARTIALLY(), ['percentage' => 50], true],
            [ChannelFunctionAction::REVEAL_PARTIALLY(), ['percentage' => 100], true],
            [ChannelFunctionAction::REVEAL_PARTIALLY(), ['percentage' => -1], false],
            [ChannelFunctionAction::REVEAL_PARTIALLY(), ['percentage' => 101], false],
            [ChannelFunctionAction::REVEAL_PARTIALLY(), ['percentage2' => 50], false],
            [ChannelFunctionAction::REVEAL_PARTIALLY(), ['percentage' => 50, 'other' => 50], false],
            [ChannelFunctionAction::REVEAL_PARTIALLY(), [], false],
            [ChannelFunctionAction::REVEAL_PARTIALLY(), null, false],

            [ChannelFunctionAction::SET_RGBW_PARAMETERS(), ['hue' => 0, 'color_brightness' => 0], true],
            [ChannelFunctionAction::SET_RGBW_PARAMETERS(), ['hue' => 359, 'color_brightness' => 100], true],
            [ChannelFunctionAction::SET_RGBW_PARAMETERS(), ['hue' => 'random', 'color_brightness' => 100], true],
            [ChannelFunctionAction::SET_RGBW_PARAMETERS(), ['hue' => 'white', 'color_brightness' => 100], true],
            [ChannelFunctionAction::SET_RGBW_PARAMETERS(), ['brightness' => 0], true],
            [ChannelFunctionAction::SET_RGBW_PARAMETERS(), ['brightness' => 100], true],
            [ChannelFunctionAction::SET_RGBW_PARAMETERS(), ['brightness' => 50, 'hue' => 359, 'color_brightness' => 100], true],
            [ChannelFunctionAction::SET_RGBW_PARAMETERS(), ['blabla' => 50, 'hue' => 359, 'color_brightness' => 100], false],
            [ChannelFunctionAction::SET_RGBW_PARAMETERS(), ['hue' => 360, 'color_brightness' => 100], false],
            [ChannelFunctionAction::SET_RGBW_PARAMETERS(), ['hue' => -1, 'color_brightness' => 100], false],
            [ChannelFunctionAction::SET_RGBW_PARAMETERS(), ['hue' => 0, 'color_brightness' => 101], false],
            [ChannelFunctionAction::SET_RGBW_PARAMETERS(), ['hue' => 0, 'color_brightness' => -1], false],
            [ChannelFunctionAction::SET_RGBW_PARAMETERS(), ['hue' => 0], false],
            [ChannelFunctionAction::SET_RGBW_PARAMETERS(), ['hue' => 'black', 'color_brightness' => 100], false],
            [ChannelFunctionAction::SET_RGBW_PARAMETERS(), ['brightness' => -1], false],
            [ChannelFunctionAction::SET_RGBW_PARAMETERS(), ['brightness' => 101], false],

            [ChannelFunctionAction::CLOSE(), null, true],
            [ChannelFunctionAction::CLOSE(), [], false],
        ];
    }

    public function testEveryValueHasCaption() {
        $this->assertCount(
            count(ChannelFunctionAction::values()),
            ChannelFunctionAction::captions(),
            'Have you forgot to add a caption for the new ScheduleAction value?'
        );
    }
}
