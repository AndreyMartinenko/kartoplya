<?php
/**
 * Smarty plugin
 * 
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {html_image} function plugin
 * 
 * Type:     function<br>
 * Name:     html_image<br>
 * Date:     Feb 24, 2003<br>
 * Purpose:  format HTML tags for the image<br>
 * Examples: {html_image file="/images/masthead.gif"}<br>
 * Output:   <img src="/images/masthead.gif" width=400 height=23><br>
 * Params:
 * <pre>
 * - file        - (required) - file (and path) of image
 * - height      - (optional) - image height (default actual height)
 * - width       - (optional) - image width (default actual width)
 * - basedir     - (optional) - base directory for absolute paths, default is environment variable DOCUMENT_ROOT
 * - path_prefix - prefix for path output (optional, default empty)
 * </pre>
 * 
 * @link http://www.smarty.net/manual/en/language.function.html.image.php {html_image}
 *      (Smarty online manual)
 * @author Monte Ohrt <monte at ohrt dot com> 
 * @author credits to Duda <duda@big.hu> 
 * @version 1.0
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 * @return string 
 * @uses smarty_function_escape_special_chars()
 */
function smarty_modifier_extract_src($string)
{
    preg_match('/(src=["\'](.*?)["\'])/', $string, $match);  //find src="X" or src='X'
    $split = preg_split('/["\']/', $match[0]); // split by quotes
 
    $src = $split[1]; // X between quotes 
 
    return $src;
} 

?>