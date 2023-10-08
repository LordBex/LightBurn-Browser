
{include 'subBreadcrumb.tpl' breadcump=$path_tree}

<script>
    /* <![CDATA[ */
    var BROWSER_PATH = "{$path}";
    /* ]]> */
</script>

<div class="container mb-3 p-0 m-0">
    <form action="{$WWW_TOP}/upload/{$path}" method="post" enctype="multipart/form-data">
        <div class="input-group input-group-sm">
            <input type="file" class="form-control" id="fileInput" name="file">
            <button type="submit" class="btn btn-outline-secondary">Upload</button>
        </div>
    </form>
</div>

{function name=file}
    <div class="list-group-item list-group-item-action">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <a class="flex-fill text-decoration-none link-body-emphasis" href="{$WWW_TOP}/viewer/{$item->relative_path}">
                <i class="fa fa-file text-warning pe-2"></i> {$item->name}
            </a>
            <div class="d-flex flex-row align-items-center gap-2" data-path="{$item->relative_path|escape:"html"}" data-name="{$item->name}">
                <button class="icon-btn action-rename-file"><i class="fa-solid fa-pen"></i></button>
                <button class="icon-btn text-danger action-delete-file"><i class="fa-solid fa-trash-can"></i></button>
            </div>
        </div>
    </div>
{/function}

{function name=folder}
    <div class="list-group-item list-group-item-action">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <a class="flex-fill text-decoration-none link-body-emphasis" href="{$WWW_TOP}/browser/{$item->relative_path}">
                <i class="fa fa-folder text-info-emphasis pe-2"></i> {$item->name}
            </a>
            <div class="d-flex flex-row align-items-center gap-2" data-path="{$item->relative_path|escape:"html"}" data-name="{$item->name}">
                <button class="icon-btn action-rename-folder"><i class="fa-solid fa-pen"></i></button>
                <button class="icon-btn text-danger action-delete-folder"><i class="fa-solid fa-trash-can"></i></button>
            </div>
        </div>
    </div>
{/function}


<div class="card mb-3">
    <div class="card-body d-flex flex-row p-1 justify-content-end">
        <button class="btn btn-outline-secondary btn-sm action-create-folder"><i class="fa-solid fa-folder-plus"></i> Ordner erstellen</button>
    </div>
</div>

<div class="list-group">
    {foreach $items as $item}
        {if $item->type == 'dir'}
            {folder item=$item}
        {elseif $item->type == 'file'}
            {file item=$item}
        {/if}
    {/foreach}
</div>

<script src="{$WWW_TOP}/public/js/browser.js" type="module"></script>
