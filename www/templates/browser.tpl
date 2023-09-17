
{include 'subBreadcumb.tpl' breadcump=$path_tree}

<div class="container mb-3 p-0 m-0">
    <form action="{$WWW_TOP}/upload?path={$path|escape:"url"}" method="post" enctype="multipart/form-data">
        <div class="input-group input-group-sm">
            <input type="file" class="form-control" id="fileInput" name="file">
            <button type="submit" class="btn btn-outline-secondary">Upload</button>
        </div>
    </form>
</div>


{function name=file}
    <a class="list-group-item list-group-item-action" href="{$WWW_TOP}/viewer?path={$item->relative_path|escape:"url"}">
        <i class="fa fa-file text-warning pe-2"></i> {$item->name}
    </a>
{/function}

{function name=folder}
    <a class="list-group-item list-group-item-action" href="{$WWW_TOP}/browser?path={$item->relative_path|escape:"url"}">
        <i class="fa fa-folder text-info-emphasis pe-2"></i> {$item->name}
    </a>
{/function}


<div class="list-group">
    {foreach $items as $item}
        {if $item->type == 'dir'}
            {folder item=$item}
        {elseif $item->type == 'file'}
            {file item=$item}
        {/if}
    {/foreach}
</div>
