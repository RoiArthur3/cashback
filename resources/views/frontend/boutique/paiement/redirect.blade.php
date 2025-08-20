<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Redirection vers le paiement…</title>
  <meta http-equiv="refresh" content="0;url={{ $url }}">
  <script>window.location.replace(@json($url));</script>
  <style>body{font-family:system-ui,Segoe UI,Roboto,Arial,sans-serif;padding:2rem}</style>
</head>
<body>
  <p>Redirection vers la page de paiement…</p>
  <p><a href="{{ $url }}">Cliquez ici si vous n’êtes pas redirigé automatiquement.</a></p>
</body>
</html>
