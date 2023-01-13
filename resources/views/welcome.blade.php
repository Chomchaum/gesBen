<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env("APP_NAME") }}</title>
</head>
<body>
<div id="app">
    <v-app>
        <app></app>
    </v-app>
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
