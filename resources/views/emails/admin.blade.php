<html>
    <head>
        <title>Zpráva od uživatele - {{ config('app.name', 'Truwork') }}</title>
    </head>
    <body>
        <div>
            <div>
                {{ $mail_data['message'] }}
            </div>
            <br/>
            <p><b>Jméno</b> : {{ $mail_data['name'] }}</p>
            <p><b>Přijmení</b> : {{ $mail_data['surname'] }}</p>
            <p><b>Telefon</b> : {{ $mail_data['phone'] }}</p>
            <p><b>Email</b> : {{ $mail_data['email'] }}</p>
        </div>
    </body>
</html>