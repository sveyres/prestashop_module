<!-- Block showthelast -->
<div id="showthelast_block_left" class="block">
  <h4>{l s='Welcome!' mod='showthelast'}</h4>
  <div class="block_content">
    <p>
      {if !isset($my_module_name) || !$my_module_name}
        {capture name='my_module_tempvar'}{l s='World' mod='myothtmodule'}{/capture}
        {assign var='my_module_name' value=$smarty.capture.my_module_tempvar}
      {/if}
    </p>
    <h3>{$last_article['name']}</h3>
    <p>{$last_article['description']}</p>

    <p>

        {* <div id="product-total">

            Notre dernier article ajouté :<br> <span>{showthelast::getLastProduct()}</span>
        </div> *}
    </p>
  </div>
</div>
<!-- /Block showthelast -->
