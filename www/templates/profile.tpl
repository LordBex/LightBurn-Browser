<div class="card">
    <div class="card-header">
        Profil Übersicht
    </div>
    <div class="card-body">
        <table class="table">
            <tbody>
            {foreach from=$user key=k item=v}
                {if $k=='password'}
                    <tr>
                        <th scope="row"><strong>{$k}</strong></th>
                        <td><a href="#todo">Change Password</a> # TODO</td>
                    </tr>
                {else}
                    <tr>
                        <th scope="row"><strong>{$k}</strong></th>
                        <td>{$v}</td>
                    </tr>
                {/if}
            {/foreach}
            </tbody>
        </table>
        <a class="btn btn-sm btn-danger float-end" href="{$WWW_TOP}/logout">Logout</a>
    </div>
</div>