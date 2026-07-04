<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Recuperação de Senha - RPG de Mesa</title>
</head>

<body style="font-family: monospace; font-size: 12px; background: #412505; padding: 40px 20px;">
    <table style="max-width: 400px; margin: 10px auto; background: #F5DEB3; border-radius: 10px; padding: 10px;">
        <tr>
            <td style="text-align: center">
                <img src="{{ config('mail.from.site') }}/icons/logo.png" alt="Logo" width="80">
            </td>
        </tr>
        <tr>
            <td>
                <p>
                    Olá, <b style="color: #412505">{{ $user }}</b> você solicitou a recuperação de senha no nosso
                    sistema e para
                    isso é necessário
                    confirmar a
                    sua identidade.
                </p>
                <p>
                    Copie o código abaixo e cole no campo indicado para continuar:
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="font-size: 32px; text-align: center; color: #EBEFD4;">
                    <span style="display: inline-block; background: #412505; border-radius: 10px; padding: 10px">
                        {{ $code }}
                    </span>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="font-size: 10px; background: #997C52; color: #EBEFD4; border-radius: 10px; padding: 10px">
                    Este e-mail foi encaminhado por:
                    <a href="{{ config('mail.from.site') }}" target="_blank" style="color: #EBEFD4;">
                        {{ config('mail.from.site') }}
                    </a>
                </p>
            </td>
        </tr>
    </table>
</body>

</html>
