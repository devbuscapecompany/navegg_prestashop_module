<?php
/*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;

class Navegg extends Module
{
	function __construct()
	{
		$this->name = 'navegg';
		$this->tab = 'administration';
		$this->version = '0.1.0';
		$this->author = 'Ale Borba';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = $this->l('Navegg');
		$this->description = $this->l('This module helps the integration between your e-commerce and Navegg.');
	}

	function install()
	{
		if (parent::install() == false
				|| $this->registerHook('header') == false
				|| Configuration::updateValue('NAVEGG_code', '') == false)
			return false;
		return true;
	}

	public function getContent()
	{
		$output = '<h2>'.$this->displayName.'</h2>';
		if (Tools::isSubmit('submitNavegg'))
		{
			if (!($NaveggCode = Tools::getValue('NaveggCode')) || empty($NaveggCode))
				$output .= '<div class="alert error">'.$this->l('Please, put the Navegg Code.').'</div>';
			else
			{
				Configuration::updateValue('NAVEGG_code', $NaveggCode);
				$output .= '<div class="conf confirm">'.$this->l('Settings updated').'</div>';
			}
		}
		return $output.$this->displayForm();
	}

	public function displayForm()
	{
		$output = '
		<form action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post">
			<fieldset><legend><img src="'.$this->_path.'logo.gif" alt="" title="" />'.$this->l('Settings').'</legend>
				<label>'.$this->l('Navegg Code').'</label>
				<div class="margin-form">
					<input type="text" name="NaveggCode" value="'.Configuration::get('NAVEGG_code').'" />
					<p class="clear">'.$this->l('Type your code here.').'</p>
				</div>
				<center><input type="submit" name="submitNavegg" value="'.$this->l('Save').'" class="button" /></center>
			</fieldset>
		</form>';
		return $output;
	}


	function hookHeader($params)
	{
		$output = '
		<script id="navegg" type="text/javascript" src="//d1070b8a575b8m.cloudfront.net/tm'.Configuration::get('NAVEGG_code').'.js" async="true"></script>
		';

		return $output;
	}

}