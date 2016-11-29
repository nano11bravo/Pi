#!/usr/bin/php -q
<?php
/**
 * Description: Bridges GPIO through PHP.
 * User: Sam W. <samuel.walton@seven-labs.com>
 * Date: 11/25/2016
 * Time: 18:58
 */

require '../php-gpio/vendor/autoload.php';
require 'pibrella.pi.class.php';
require 'colorize.pi.class.php';

use PhpGpio\Gpio;

$gpio = new GPIO();
$colorize = new Colorize();


// TODO: Consolidate into a common functions file

/**
 * GPIO_SETUP
 * Safely sets the proper mode in/out.
 * @param $GPIO_ID
 * @param int $GPIO_MODE
 * @return bool
 */
function GPIO_SETUP($GPIO_ID, $GPIO_MODE = 0)
{
    global $gpio;
    $gpio->setup($GPIO_ID, $GPIO_MODE);
    return true;
}

/**
 * LIGHT_BLINK
 * Blinks specified LED at a specified rate for specified number of seconds.
 * @param $intPin
 * @param float $dblFrequency
 * @param int $intRate
 * @param int $intDuration
 * @return bool
 * @throws Exception
 * @internal param int $intFrequency
 */
function LIGHT_BLINK($intPin, $dblFrequency = 1.25, $intRate = 1, $intDuration = 4)
{
    global $gpio, $colorize, $GPIO_ON, $GPIO_OFF, $GPIO_MODE_OUT;
    $intX = 0;
    GPIO_SETUP($intPin, $GPIO_MODE_OUT);

    print "Blinking! (";
    while ($intDuration >= $intX + 1)
    {
        $gpio->output($intPin, $GPIO_ON);
        sleep($dblFrequency);
        $gpio->output($intPin, $GPIO_OFF);
        print ($intDuration - $intX . "..");
        sleep($intRate);
        $intX++;
    }
    echo ") \t " . $colorize->getColoredString("[ OK ]", "green", null) . " \n";
    return true;
}

/**
 * @param float $dblFrequency
 * @param float $intRate
 * @param int $intDuration
 * @return bool
 * @throws Exception
 */
function LIGHT_CYCLE($dblFrequency = 1.00, $intRate = 1.25, $intDuration = 4)
{
    global $gpio, $PB_PIN_LIGHT_RED, $PB_PIN_LIGHT_YELLOW, $PB_PIN_LIGHT_GREEN, $GPIO_ON, $GPIO_OFF, $GPIO_MODE_OUT;
    $intX = 0;
    GPIO_SETUP($PB_PIN_LIGHT_RED, $GPIO_MODE_OUT);
    GPIO_SETUP($PB_PIN_LIGHT_YELLOW, $GPIO_MODE_OUT);
    GPIO_SETUP($PB_PIN_LIGHT_GREEN, $GPIO_MODE_OUT);

    while ($intDuration >= $intX + 1)
    {
        $gpio->output($PB_PIN_LIGHT_RED, $GPIO_ON);
        sleep($dblFrequency);
        $gpio->output($PB_PIN_LIGHT_RED, $GPIO_OFF);
        sleep($intRate);
        $gpio->output($PB_PIN_LIGHT_YELLOW, $GPIO_ON);
        sleep($dblFrequency);
        $gpio->output($PB_PIN_LIGHT_YELLOW, $GPIO_OFF);
        sleep($intRate);
        $gpio->output($PB_PIN_LIGHT_GREEN, $GPIO_ON);
        sleep($dblFrequency);
        $gpio->output($PB_PIN_LIGHT_GREEN, $GPIO_OFF);
        sleep($intRate);
        $intX++;
    }
    return true;
}

/** MAIN_ROUTINE START */

$boolBlinkLight = null;
$boolInit = null;

// Write out the contents of the $argv array
foreach ( $argv as $key => $value ) {
    //echo "$key => $value \n";
    switch (strtolower($value))
    {
        case "--blink":
            //echo "$value \n";
            $boolBlinkLight = true;
            break;
	case "--init":
	    //echo "$value \n";
	    $boolInit = true;
	    break;
        case "--input":
            echo "$value=" . $argv[$key + 1] . "\n";
            break;
        default:

            break;
    }
}

/*
echo "[ ** ] Cycling lights \n";
if (LIGHT_CYCLE()) echo "Done! \n";
*/

// Init mode (usually after Pi boots)
if ($boolInit)
{
    echo "[ ** ] Running startup tests...\n       (This will take a minute)\n";
    LIGHT_CYCLE();
    echo "[ OK ] Now back to you Bob!\n";
}


// Just a blinking light!
if ($boolBlinkLight)
{
    echo "[ ** ] Blinking light \n";
    if (LIGHT_BLINK($PB_PIN_LIGHT_RED)) echo "Done! \n";
}

echo "\n";

?>

