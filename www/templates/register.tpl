<!-- Modal Start here-->

<div class="modal" id="modal" tabindex="-1" style="display: block">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down" role="document">
        <div class="modal-content rounded-4 shadow overflow-hidden position-relative">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <div class="d-flex flex-row justify-content-between align-items-start w-100 gap-3">
                    <h1>Register</h1>
                </div>
            </div>
            <svg-icon class="no-background pe-1 position-absolute translate-middle top-50 start-50 z-0" style="opacity: 0.05; width: 200%; height: 200%" data-icon="brand" data-height="100%" data-width="100%"></svg-icon>

            <div class="modal-body p-5 pt-0">
                <div class="modal-body form-signup ">

                    {if $error != ''}
                        <p class="alert alert-danger">{$error}</p>
                    {/if}

                    <form action="{$WWW_TOP}/register" method="post" class="z-3">


                        <input class="form-control" type="hidden" name="redirect" value="{$redirect|escape:"htmlall"}" />

                        <div class="form-floating mb-2">
                            <input id="username" class="form-control rounded-top-3 rounded-bottom-1" type="text" value="{$username|escape:htmlall}" name="username" placeholder="name">
                            <label for="username">Nutzername</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input type="password" class="form-control rounded-1" id="password" name="password" placeholder="Passwort">
                            <label for="password">Passwort</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-bottom-3 rounded-top-1" id="password" name="password-2" placeholder="Passwort">
                            <label for="password">Bestätige Passwort</label>
                        </div>

                        <button class="btn btn-primary w-100 py-2" type="submit" value="Login">Registrieren</button>
                    </form>

                    <p class="mt-4 mb-3 text-body-secondary w-100 text-center">Sie haben bereits ein Profil ? <a href="{$WWW_TOP}/login">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>


