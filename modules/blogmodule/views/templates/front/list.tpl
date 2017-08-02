{l s='Welcome to this page!' mod='blogmodule'}
<p>Hello,
    {if isset($my_module_name) && $my_module_name}
        {$my_module_name}
    {else}
        World
    {/if}
    !
</p>
