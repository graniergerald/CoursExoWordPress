<?php

/**
 * JCH Optimize - Performs several front-end optimizations for fast downloads
 *
 * @package   jchoptimize/wordpress-platform
 * @author    Samuel Marshall <samuel@jch-optimize.net>
 * @copyright Copyright (c) 2020 Samuel Marshall / JCH Optimize
 * @license   GNU/GPLv3, or later. See LICENSE file
 *
 * If LICENSE file missing, see <http://www.gnu.org/licenses/>.
 */

defined('_WP_EXEC') or die('Restricted access');

use JchOptimize\Core\Admin;
use JchOptimize\Core\Helper;

function jch_gen_radio_field_pro($option, $default, $description, $class='', $auto_option = false )
{
    
       return jch_gen_proonly_field();
       

    
}

function jch_gen_radio_field( $option, $default, $description, $class = '', $auto_option = false )
{
	$options = get_option( 'jch_options' );

	$checked = 'checked="checked"';
	$no      = '';
	$yes     = '';
	$auto    = '';
	$symlink = '';

	if ( ! isset( $options[$option] ) )
	{
		$options[$option] = $default;
	}

	if ( $options[$option] == '1' )
	{
		$yes = $checked;
	}
	elseif ( $options[$option] == '2' )
	{
		$auto = $checked;
	}
	elseif ( $options[$option] == '3' )
	{
		$symlink = $checked;
	}
	else
	{
		$no = $checked;
	}

	$radio = '<fieldset id="jch_options_' . $option . '" class="radio btn-group ' . $class . '">' .
	         '        <input type="radio" id="jch_options_' . $option . '0" name="jch_options[' . $option . ']" value="0" ' . $no . ' >' .
	         '        <label for="jch_options_' . $option . '0" class="btn">' . __( 'No', 'jch-optimize' ) . '</label>' .
	         '        <input type="radio" id="jch_options_' . $option . '1" name="jch_options[' . $option . ']" value="1" ' . $yes . ' >' .
	         '        <label for="jch_options_' . $option . '1" class="btn">' . __( 'Yes', 'jch-optimize' ) . '</label>';
	$radio .= '</fieldset>';

	if ( $description )
	{
		$radio .= '<div class="description"><div>' . $description . '</div></div>';
	}

	return $radio;
}

function jch_gen_description($title, $description, $new = false)
{
    $text = '<div class="title">' . $title . '<div class="description"><div>' . $description . '</div></div>';

    if($new)
    {
        $text .= ' <span class="label label-important">New!</span>';
    }

    $text .= '</div>';

    return $text;
}

function jch_gen_checkboxes_field_pro($option, $values, $class, $description='')
{
    
    return jch_gen_proonly_field($description);
   

    
}
function jch_gen_checkboxes_field( $option, $values, $class )
{
	$options = get_option( 'jch_options' );

	if ( ! empty( $options[$option] ) )
	{
		$checked_static_files = $options[$option];
	}
	else
	{
		$checked_static_files = array_keys( $values );
	}

	$input = '<fieldset id="jch_options_' . $option . '" class="' . $class . '">' .
	         '<ul>';

	$i = 0;
	foreach ( $values as $key => $value )
	{
		$checked = '';

		if ( in_array( $key, $checked_static_files ) )
		{
			$checked = 'checked';
		}

		$input .= '<li>'
		          . '<input type="checkbox" id="jch_options_' . $option . $i ++ . '" name="jch_options[' . $option . '][]" value="' . $key . '" ' . $checked . '>'
		          . '<label for="jform_params_pro_staticfiles0">' . $value . '</label>'
		          . '</li>';
	}

	$input .= '</li>'
	          . '</ul>'
	          . '</fieldset>';

	return $input;
}

function jch_gen_text_field_pro($option, $default, $description, $class='', $size='6')
{
    
       return jch_gen_proonly_field($description);
      

    
}

function jch_gen_text_field( $option, $default, $description, $class = '', $size = '6' )
{
	$options = get_option( 'jch_options' );

	if ( ! isset( $options[$option] ) )
	{
		$value = $default;
	}
	else
	{
		$value = $options[$option];
	}

	$input = '<input type="text" name="jch_options[' . $option . ']" id="jch_options_' . $option . '" value="' . $value . '" size="' . $size . '" class="' . $class . '">';

	if ( $description )
	{
		$input .= '<div class="description"><div>' . $description . '</div></div>';
	}

	return $input;
}

function jch_gen_select_field( $option, $default, $values, $description, $class = '' )
{
	$options = get_option( 'jch_options' );

	if ( ! isset( $options[$option] ) )
	{
		$selected_value = $default;
	}
	else
	{
		$selected_value = $options[$option];
	}

	$select = '<select id="jch_options_' . $option . '" name="jch_options[' . $option . ']" class="' . $class . '" >';

	foreach ( $values as $key => $value )
	{
		$selected = $selected_value == $key ? 'selected="selected"' : '';
		$select   .= '          <option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
	}

	$select .= '</select>';

	if ( $description )
	{
		$select .= '<div class="description"><div>' . $description . '</div></div>';
	}

	return $select;
}

function jch_gen_multiselect_field_pro($options, $values, $description, $class='' )
{
    
        return jch_gen_proonly_field();
        

    
}

function jch_gen_multiselect_field( $option, $values, $description, $class = '' )
{
	$options = get_option( 'jch_options' );

	if ( isset( $options[$option] ) )
	{
		$selected_values = Helper::getArray( $options[$option] );
	}
	else
	{
		$selected_values = array();
	}

	$select = '<select id="jch_options_' . $option . '" name="jch_options[' . $option . '][]" class="inputbox chzn-custom-value input-xlarge ' . $class . '" multiple="multiple" size="5" data-custom_group_text="Custom Position" data-no_results_text="Add custom item">';

	foreach ( $values as $key => $value )
	{
		$selected = in_array( $key, $selected_values ) ? 'selected="selected"' : '';
		$select   .= '          <option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
	}

	$select .= '</select>';
	$select .= '<button class="btn" type="button" onclick="addJchOption(\'jch_options_' . $option . '\')">' . __( 'Add item', 'jch-optimize' ) . '</button>';

	if ( $description )
	{
		$select .= '<div class="description"><div>' . $description . '</div></div>';
	}

	return $select;
}

function jch_get_auto_settings_buttons()
{
	return Admin::getSettingsIcons();
}

function jch_get_field_value( $sType, $sExcludeParams, $sGroup = '' )
{
	$oJchAdmin = jch_get_admin_object();

	return $oJchAdmin->prepareFieldOptions( $sType, $sExcludeParams, $sGroup );
}



  function jch_gen_proonly_field($description = '')
  {
  $field = '<div><em style="padding: 5px; background-color: white; border: 1px #ccc;">' . __('Only available in Pro Version!', 'jch-optimize') . '</em></div>';

  if ($description != '')
  {
  $field .= '<div class="description"><div>' . $description . '</div></div>';
  }

  return $field;
  }

  


##<procode>##

function jch_get_optimize_images_buttons()
{
	$page    = add_query_arg( array( 'jch-task' => 'postresults' ), admin_url( 'options-general.php?page=jchoptimize-settings' ) );
	$aButton = array();

	$aButton[0]['link']   = '';
	$aButton[0]['icon']   = 'fa-compress';
	$aButton[0]['color']  = '#278EB1';
	$aButton[0]['text']   = 'Optimize Images';
	$aButton[0]['script'] = 'onclick="jchOptimizeImages(\'' . $page . '\'); return false;"';
	$aButton[0]['class']  = 'enabled';

	return $aButton;
}

function jch_group_start( $header = '', $description = '', $class = '' )
{
	echo '<fieldset class="jch-group">'
	     . ( $header != '' ? '             <legend>' . $header . '</legend>' : '' )
	     . '        <div ' . $class . '> <p><em>' . $description . '</em></p></div>'
	     . '<div>';
}

function jch_group_end()
{
	echo '</div></fieldset>';
}


function jch_gen_button_icons( array $aButton, $description = '', $attribute = '' )
{
	$sField = Admin::generateIcons( $aButton );
	$sField .= $attribute;

	if ( $description != '' )
	{
		$sField .= '<div class="description" style="margin-top:-40px"><div>' . $description . '</div></div>';
	}

	return $sField;
}
