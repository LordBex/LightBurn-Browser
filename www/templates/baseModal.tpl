<!doctype html>
<html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>{$page_title}</title>

	<link href="{$WWW_TOP}/public/styles/theme.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<!-- SmartMenus jQuery Bootstrap Addon CSS -->
	<script type="text/javascript">
		/* <![CDATA[ */
		var WWW_TOP = "{$WWW_TOP}";
		/* ]]> */
	</script>
</head>

<body data-bs-theme="dark" style="background-color: #27374D">
<main>
	<div class="container-lg h-100 p-0">

		<div id="content">
			{$content}
		</div>

	</div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>
