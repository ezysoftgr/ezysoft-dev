<h3>
    <div class="version-module">
        <i class="icon module-version-author-grid"></i>
        <span class="label label-primary">{l s='Module version: %s  ' sprintf=[$version] mod='ezysoft'}</span>
    </div>
    {if $status_api == 200}
        <div class="ezysoft-api">
            <div class="toOne">
                <span class="round green flash"></span>
                <span class="text">{l s='Bridge is connected' mod='ezysoft'}</span>
            </div>
        </div>
    {else}
        <div class="ezysoft-api">
                        <span class="response-api-401">
                            <i class="icon icon-warning">

                            </i>
                            {l s='%s Error. The bridge is not working!' sprintf=[$status_api['status']] mod='ezysoft'}
                        </span>
        </div>
    {/if}
</h3>