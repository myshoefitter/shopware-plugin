{extends file="parent:frontend/index/footer.tpl"}

{block name="frontend_index_footer_closing"}
    {$smarty.block.parent}
    
    {if $myshoefitterEnabled}
        <!-- Load the Script -->
        <script src="{$myshoefitterScriptUrl}"></script>
        
        <!-- Initialize the Script -->
        <script type="application/javascript">
            myshoefitter.init({
                shopSystem: 'shopware',
            });
        </script>
    {/if}
{/block}