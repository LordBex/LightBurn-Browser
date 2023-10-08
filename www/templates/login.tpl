<!-- Modal Start here-->

<div class="modal" id="modal" tabindex="-1" style="display: block">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <div class="d-flex justify-content-center align-items-center w-100">
                    <svg-icon class="no-background pe-1" data-icon="brand" data-height="6em" data-width="6em"></svg-icon>
                </div>
            </div>

            <div class="modal-body p-5 pt-0">
                <div class="modal-body form-signin">


                    {if $error != ''}
                        <p class="alert alert-danger">{$error}</p>
                    {/if}

                    <form action="{$WWW_TOP}/login" method="post">

                        <input class="form-control" type="hidden" name="redirect" value="{$redirect|escape:"htmlall"}" />

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-top-3 rounded-bottom-1" id="username" value="{$username|escape:htmlall}" name="username" placeholder="name">
                            <label for="username">Nutzername</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-bottom-3 rounded-top-1" id="password" name="password" placeholder="Passwort">
                            <label for="password">Passwort</label>
                        </div>

                        <div class="form-check text-start mb-3">
                            <input class="form-check-input" type="checkbox" id="rememberme" {if $rememberme == 1}checked="checked"{/if} name="rememberme">
                            <label class="form-check-label fs-6 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center" for="rememberme">
                                <span style="opacity: 70%">
                                    Angemeldet bleiben
                                </span>
                                <a href="{$smarty.const.WWW_TOP}/forgottenpassword" class="text-secondary fs-6 float-end">Passwort vergessen ?</a>
                            </label>
                        </div>

                        <button class="btn btn-primary w-100 py-2" type="submit" value="Login">Login</button>
                    </form>

                    {if $CONFIGS["oidc_providers"]}
                        <div class="d-flex flex-row align-items-center py-3 text-secondary opacity-50">
                            <hr class="w-100"/>
                            <span class="mx-2 fs-6">OR</span>
                            <hr class="w-100"/>
                        </div>
                        {foreach from=$CONFIGS["oidc_providers"] key=k item=v}
                            <a class="btn btn-sm btn-outline-secondary w-100" href="{WWW_TOP}/login-with/{$k}">Login mit {$v["name"]}</a>
                        {/foreach}
                    {/if}


                    <p class="mt-4 mb-3 text-body-secondary text-center w-100">Noch kein Profil ? <a href="{$WWW_TOP}/register">SignUp</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

