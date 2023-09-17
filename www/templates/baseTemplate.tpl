<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="ZeroK">
	<meta name="application-name" content="lightburn-browser/viewer" />
	<meta name="description" content="view lightburn files" />

	<title>{$page_title}</title>

	<link href="{$WWW_TOP}/public/styles/theme.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<link rel="apple-touch-icon" sizes="180x180" href="{$WWW_TOP}/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="{$WWW_TOP}/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="{$WWW_TOP}/favicon/favicon-16x16.png">
	<link rel="manifest" href="{$WWW_TOP}/favicon/site.webmanifest">

	<script type="text/javascript">
		/* <![CDATA[ */
		var WWW_TOP = "{$WWW_TOP}";
		/* ]]> */
	</script>
</head>
<body data-bs-theme="dark">

<div class="container py-3">
	<header>
		<div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
			<a href="{$WWW_TOP}" class="d-flex align-items-center link-body-emphasis text-decoration-none">
				<span class="fs-4 d-flex align-items-center justify-content-center">
					<svg-icon class="no-background pe-1" data-icon="brand" data-height="1.6em" data-width="1.6em"></svg-icon>
					<span>LightBurn-Browser</span>
				</span>
			</a>
			<nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
				<a class="me-3 py-2 link-body-emphasis text-decoration-none" href="{$WWW_TOP}">Home</a>
				<a class="me-3 py-2 link-body-emphasis text-decoration-none" href="{$WWW_TOP}/browser">Browser</a>
				<a class="me-3 py-2 link-body-emphasis text-decoration-none" href="{$WWW_TOP}/viewer">Viewer</a>
				{if $isLogged}
					<a class="me-3 py-2 link-body-emphasis text-decoration-none" href="{$WWW_TOP}/profile">Profil</a>
					{else}
					<a class="me-3 py-2 link-body-emphasis text-decoration-none" href="{$WWW_TOP}/profile">Login</a>
				{/if}

			</nav>
		</div>

	</header>

	<main>
		{$content}
	</main>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="{$WWW_TOP}/public/js/main.js" type="module"></script>

</body>
</html>
