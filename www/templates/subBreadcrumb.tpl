
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{$WWW_TOP}/browser">Browser</a></li>
        {foreach from=$breadcump key=k item=v}
            {if $v@last}
                <li class="breadcrumb-item active" aria-current="page">{$k}</li>
            {else}
                <li class="breadcrumb-item"><a href="{$WWW_TOP}/browser{$v}">{$k}</a></li>
            {/if}
        {/foreach}
    </ol>
</nav>
