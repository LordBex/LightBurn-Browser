
{include 'subBreadcrumb.tpl' breadcump=$path_tree}

<div class="card position-relative">
    <div class="card-body d-flex flex-column flex-sm-row">
        {if $data.Thumbnail}
            <div class="image-container">
                <img src="data:image/png;base64, {$data.Thumbnail}" alt="Thumbnail" class="img-thumbnail rounded-2"/>
            </div>
        {/if}
        <div class="meta mb-5 pb-5">
            <h2>
                Allgemein
            </h2>
            <strong>App Version:</strong> {$data.AppVersion}<br />
            <strong>Format Version:</strong> {$data.FormatVersion} <br />

            <h3>
                <i class="fa fa-font mt-2" aria-hidden="true"></i> Verwendete Schriftarten <br />
            </h3>

            {foreach $data.Fonts as $font}
                <li>
                    {$font}
                </li>
            {/foreach}
        </div>
    </div>

    <a class="btn btn-sm btn-warning position-absolute" style="right: 1rem; bottom: 1rem" href="{$WWW_TOP}/download?path={$path|escape:'url'}"> Download<i class="fa-solid fa-download ps-2"></i></a>
</div>
