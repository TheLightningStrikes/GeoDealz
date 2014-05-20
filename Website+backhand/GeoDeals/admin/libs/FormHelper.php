<?php

/**
* You can pass any vars to the view object 
* And call them in the file that you call in the render method
*/
class FormHelper
{
	static function DisplayTextField($key, $value, $display)
	{
		$output =  '<div class="field">';
		$output .= '<label for='.$key.'>'.$display.'</label>';
		$output .= '<input type="text" name='.$key.' value='.$value.'>';
		$output .= '</div>';
		
		return $output;
	}
	
	static function DisplayCheckboxField($key, $value, $display)
	{
		$isChecked =($value=="1")?'checked':'';
	
		$output =  '<div class="field">';
		$output .= '<label for='.$key.'>'.$display.'</label>';
		$output .= '<input type="hidden" name ='.$key.' value="0" />';
		$output .= '<input type="checkbox" name='.$key.' value="1"  '.$isChecked.' />';
		$output .= '</div>';
		
		return $output;
	}
}