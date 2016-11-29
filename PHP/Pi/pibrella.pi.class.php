<?php
/**
 * Description: Defines the proper pins for Pibrella board
 * User: Sam W. <samuel.walton@seven-labs.com>
 * Date: 11/25/2016
 * Time: 19:22
 */

// Pibrella pins, these are BCM
// WARNING - These pins #s are the actual RPi gpios and NOT Pibrella's format
// You WILL break your Pi if you don't pay close attention.

// Modes
$GPIO_MODE_OUT = "out";
$GPIO_MODE_IN = "in";

// Binary
$GPIO_ON = 1;
$GPIO_OFF = 0;

// Lights
// TODO: Detection of RPi board version
/*
 * For now this is disabled until I can detect the version of the RPi interface.
if GPIO.RPI_REVISION == 1:
    PB_PIN_LIGHT_RED   = 21 # 21 on Rev 1
else: */
$PB_PIN_LIGHT_RED = 27;
$PB_PIN_LIGHT_YELLOW = 17;
$PB_PIN_LIGHT_GREEN = 4;

// Inputs
$PB_PIN_INPUT_A = 9;
$PB_PIN_INPUT_B = 7;
$PB_PIN_INPUT_C = 8;
$PB_PIN_INPUT_D = 10;

// Outputs
$PB_PIN_OUTPUT_A = 22;
$PB_PIN_OUTPUT_B = 23;
$PB_PIN_OUTPUT_C = 24;
$PB_PIN_OUTPUT_D = 25;

// Onboard button
$PB_PIN_BUTTON = 11;

// Onboard buzzer
$PB_PIN_BUZZER = 18;

// Number of times to udpate
// pulsing LEDs per second
$PULSE_FPS = 50;
$PULSE_FREQUENCY = 100;

$DEBOUNCE_TIME = 20;

?>