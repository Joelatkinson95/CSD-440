<?php
/* Joel Atkinson, April 4, 2026. CSD440 Server Side Scripting Assignment 3.2 Separate Function php file
The purpose of this portion of the assignment is to create an external file that contains the getCellValue()
function used by JoelTable3.php. The function accepts two random integers as parameters and returns their sum to be
displayed in each table cell. This builds upon our Module 2 assignment which just populated two random numbers using the
rand() function and instead uses require_once to integrate this separately stored function to add the two randomly
generated numbers together and output the sum in each table cell.
*/

/**
 * getCellValue()
 * Accepts two random integers and returns their sum.
 *
 * @param int $num1 - First random number
 * @param int $num2 - Second random number
 * @return int - The sum of the two parameters
 */
function getCellValue($num1, $num2) {
    return $num1 + $num2;
}
?>

