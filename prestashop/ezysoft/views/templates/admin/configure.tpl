{*
* 2007-2024 PrestaShop
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2024 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="panel">
	<h3><i class="icon icon-sun"></i> {l s='Cron job ' mod='ezysoft'}</h3>
	<ul class="actions_laravel">
		<li>
			<label>
				{l s='New products' mod='ezysoft'}
			</label>
			<div class="container-inputs">
				<input type="text" value="{$newProducts}" readonly id="urlNewProducts" >
				<button class="btn btn-primary" onclick="copyClipboard(urlNewProducts);">
					<i class="icon icon-copy"></i>
					{l s='Copy' mod='ezysoft'}
				</button>
			</div>
		</li>

		<li>
			<label>
				{l s='Update products' mod='ezysoft'}
			</label>
			<div class="container-inputs">
				<input type="text"  readonly id="urlUpdateProducts" value="{$updateProducts}">
				<button  onclick="copyClipboard(urlUpdateProducts);" class="btn btn-primary">
					<i class="icon icon-copy"></i>
					{l s='Copy' mod='ezysoft'}
				</button>
			</div>
		</li>

		<li>
			<label>
				{l s='Delete products' mod='ezysoft'}
			</label>
			<div class="container-inputs">
				<input type="text"  readonly id="urlDeleteProducts" value="{$deleteProducts}">
				<button  onclick="copyClipboard(urlDeleteProducts);" class="btn btn-primary">
					<i class="icon icon-copy"></i>
					{l s='Copy' mod='ezysoft'}
				</button>
			</div>
		</li>

		<li>
			<label>
				{l s='External products' mod='ezysoft'}
			</label>
			<div class="container-inputs">
				<input type="text"  readonly id="urlExternal" value="{$external}">
				<button  onclick="copyClipboard(urlExternal);" class="btn btn-primary">
					<i class="icon icon-copy"></i>
					{l s='Copy' mod='ezysoft'}
				</button>
			</div>
		</li>
	</ul>
	<p>
		{l s='Ask your hosting provider to set up a "Cron job" to load the above urls' mod='ezysoft'}
	</p>

</div>

<div class="panel">
	<h3><i class="icon icon-backward"></i> {l s='Callback' mod='ezysoft'}</h3>
	<ul class="actions_laravel">
		<li>
			<label>
				{l s='Callback' mod='ezysoft'}
			</label>
			<div class="container-inputs">
				<input type="text" value="{$callback}" readonly id="urlCallback" >
				<button class="btn btn-primary" onclick="copyClipboard(urlCallback);">
					<i class="icon icon-copy"></i>
					{l s='Copy' mod='ezysoft'}
				</button>
			</div>
		</li>

		<li>
			 <label>
				 {l s='Connect checker' mod='ezysoft'}
			 </label>
			<div class="container-inputs">
				<input type="text"  readonly id="urlConnect" value="{$connect}">
				<button  onclick="copyClipboard(urlConnect);" class="btn btn-primary">
					<i class="icon icon-copy"></i>
					{l s='Copy' mod='ezysoft'}
				</button>
			</div>
		</li>
	</ul>

	<p>
		<i class="icon icon-book"></i>
		{l s='You will need them to connect to ezysoft' mod='ezysoft'}
	</p>
</div>
