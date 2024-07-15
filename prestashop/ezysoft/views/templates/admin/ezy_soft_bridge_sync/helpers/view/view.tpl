
text/x-generic view.tpl ( HTML document, ASCII text, with CRLF line terminators )
{**
* 2018 Nexpointer
*
* NOTICE OF LICENSE
*
* This source file is subject to the General Public License (GPL 2.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/GPL-2.0
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade the module to newer
* versions in the future.
*
*  @author    nextpointer.gr <support@nextpointer.gr>
*  @copyright 2018 nextpointer.gr
*  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*  @version   1.0.0
*  @created   02 September 2018
*  @last updated 02 September 2018
 *}

{extends file="helpers/view/view.tpl"}

{block name="override_tpl"}

    {include 'module:ezysoft/views/templates/admin/ezy_soft_bridge_sync/helpers/view/_partials/header.tpl' link_configuration=$link_configuration}

    <div class="panel" id="ezysoft">

        {include 'module:ezysoft/views/templates/admin/ezy_soft_bridge_sync/helpers/view/_partials/api_status.tpl' status_api=$status_api}


        <div class="ezysoft-body panel-body">

            <div class="ezysoft-wrapper">
                <div class="ezysoft-left">
                    <img width="200" src="{$catalog}" />
                </div>
                <div class="ezysoft-right">
                    {if $status_api == 200}
                        <div class="ezysoft-process">
                            <form>
                                <div class="coffe-wrapper">
                                    <img src="{$coffee}" >
                                    <h1 class="coffe">
                                        {l s='Enjoy your coffee, it might take a while  ' mod='ezysoft'}
                                    </h1>
                                </div>
                                <ul class="catalog-list">
                                    <li {if !$newProducts} class="disabled-process" {/if}>
                                        <span>
                                           <i class="icon process-icon-import"></i>
                                           <span class="txt">
                                              {l s='New products' mod='ezysoft'}
                                           </span>
                                        </span>

                                        {if $newProducts}
                                            <span class="label label-success">
                                                {$newProducts}
                                            </span>
                                        {else}
                                            <span class="label label-danger">
                                                0
                                            </span>
                                        {/if}
                                    </li>
                                    <li {if !$updProducts} class="disabled-process" {/if}>
                                        <span>
                                            <i class="icon process-icon-update"></i>
                                            <span class="txt">
                                               {l s='For update' mod='ezysoft'}
                                            </span>
                                        </span>
                                        {if $updProducts}
                                            <span class="label label-success">
                                                {$updProducts}
                                            </span>
                                        {else}
                                            <span class="label label-danger">
                                                    0
                                            </span>
                                        {/if}
                                    </li>

                                    <li {if !$deletedProducts} class="disabled-process" {/if}>
                                        <span>
                                            <i class="icon process-icon-delete"></i>
                                            <span class="txt">
                                            {l s='For delete' mod='ezysoft'}
                                            </span>
                                        </span>

                                        {if $deletedProducts}
                                            <span class="label label-success">
                                                {$deletedProducts}
                                            </span>
                                        {else}
                                            <span class="label label-danger">
                                                0
                                            </span>
                                        {/if}
                                    </li>



                                </ul>

                                <div class="ezySoft-action">
                                  {if $active}

                                   {if $newProducts ||  $updProducts || $deletedProducts || $excluded}



                                    {if $newProducts}
                                        <button type="button" onclick="process(event, this, 'addToList')"
                                                data-action-api="{$api}" class="btn btn-lg addList"
                                                {if !$newProducts} disabled {/if}>
                                            <i class="icon process-icon-import"></i>
                                            {l s='New products Process' mod='ezysoft'}
                                        </button>
                                    {/if}
                                    {if $updProducts}
                                        <button type="button" onclick="process(event, this,'updateList')"
                                                data-action-api="{$api}" class="btn updateList btn-lg"
                                                {if !$updProducts} disabled {/if}>
                                            <i class="icon process-icon-update"></i>
                                            {l s='Update Process' mod='ezysoft'}
                                        </button>
                                    {/if}
                                    {if $deletedProducts}
                                        <button type="button" onclick="process(event, this,'deleteList')"
                                                data-action-api="{$api}" class="btn deleteList btn-lg"
                                                {if !$deletedProducts} disabled {/if}>
                                            <i class="icon process-icon-delete"></i>
                                            {l s='Delete Process' mod='ezysoft'}
                                        </button>
                                    {/if}



                                       <div class="note-footer">
                                           <div>
                                        <span class="happy-text">
                                             {l s='Dont worry, we are guarantee that our "module" works perfectly!' mod='ezysoft'}
                                        </span>
                                           </div>
                                       </div>

                                   {else}
                                       <div class="up-to-date">
                                           <img src="{$check}" width="50">
                                           <span class="text">
                                                 {l s='Your store is up to date...' mod='ezysoft'}
                                           </span>
                                       </div>

                                   {/if}

                                  {else}
                                      <div class="disabled-module">
                                          <i class="icon icon-warning"></i>
                                          <span class="disabled-txt">
                                              {l s='You cant start process. Module is disabled' mod='ezysoft'}
                                          </span>
                                      </div>
                                  {/if}
                                </div>


                            </form>
                        </div>

                    {else}
                        <div class="ezysoft-api api-401">
                            <div class="toOne">
                                <span class="round red"></span>
                                <span class="text">{l s='Bridge is disconnected' mod='ezysoft'}</span>
                            </div>
                            <small class="alert alert-danger alert-api">
                                {l s='Please check the api key from the module configuration' mod='ezysoft'}
                            </small>
                        </div>
                    {/if}
                </div>







            </div>


        </div>

        <div class="panel-footer text-center">
            <div class="copyright">
                <i class="icon icon-copyright"></i>
                <small> {l s='ezySoft.A product of nextpointer.gr' mod='ezysoft'} </small>
            </div>


            <div class="support">
                <strong>{l s='Support: ' mod='ezysoft'} </strong>
                <a href="mailto:support@nextpointer.gr">
                    info@ezysoft.gr
                </a> |
                <a href="https://ezysoft.gr" target="_blank">
                    www.ezysoft.gr
                </a>
            </div>

        </div>
    </div>


{/block}