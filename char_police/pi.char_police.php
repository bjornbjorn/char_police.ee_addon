<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$plugin_info = array(
						'pi_name'			=> 'Character Police',
						'pi_version'		=> '1.0',
						'pi_author'			=> 'Bjorn Borresen',
						'pi_author_url'		=> 'http://bybjorn.com/',
						'pi_description'	=> 'Polices your text!',
						'pi_usage'			=> Char_police::usage()
					);

/**
 * Char_police Class
 *
 * @package			ExpressionEngine
 * @category		Plugin
 * @author			Bjorn Borresen
 * @link			http://bybjorn.com/ee
 */

class Char_police {

	var $return_data;

	function Char_police($str = '')
	{
		$this->EE =& get_instance();

		$limit = $this->EE->TMPL->fetch_param('limit');
		$strip_html = !($this->EE->TMPL->fetch_param('strip_html') == 'no');
		$append = ($this->EE->TMPL->fetch_param('append') != '' ? $this->EE->TMPL->fetch_param('append') : ' ...');
				
		if(!is_numeric($limit)) {
			$limit = 500;
		}
					
		$str = ($str == '') ? $this->EE->TMPL->tagdata : $str;
		
		if($strip_html) {
			$str = strip_tags($str);
		}
		
		if(strlen($str) > $limit)
		{
			$current = "";			
			$words = explode(" ", trim($str));			
			foreach($words as $word)
			{
				$curlength = strlen($current);
				if($curlength + strlen($word) <= $limit)
				{
					$current .= ' ' . $word;
				}
				else
				{
					$this->return_data = strlen($current) == strlen($str) ? $current : $current . $append;
					break;
				}
			}		
						
		}
		else 
		{
			$this->return_data = $str;	
		}					
	}

	// --------------------------------------------------------------------
	
	/**
	 * Usage
	 *
	 * Plugin Usage
	 *
	 * @access	public
	 * @return	string
	 */
	function usage()
	{
		ob_start(); 
		?>
		Will cut your text to the maximum number of words which fit witin the limit.
				
		Usage:

		{exp:char_police limit="100" strip_html="no" append="..."}

		text you want processed

		{/exp:char_limit}

		Parameters:
		
		limit = max number of characters to allow
		strip_html = yes/no (default = yes)

		<?php
		$buffer = ob_get_contents();
	
		ob_end_clean(); 

		return $buffer;
	}
	
	// --------------------------------------------------------------------

}
// END CLASS

/* End of file pi.char_police.php */
/* Location: ./system/expressionengine/char_police/pi.char_police.php */