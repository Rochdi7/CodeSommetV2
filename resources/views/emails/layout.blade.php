<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $subject ?? 'CodeSommet' }}</title>
</head>
<body style="margin:0; padding:0; background:#f1f4f8; font-family:'Segoe UI', Helvetica, Arial, sans-serif; -webkit-text-size-adjust:100%;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f1f4f8; padding:32px 16px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; background:#ffffff; border-radius:14px; overflow:hidden; box-shadow:0 4px 24px rgba(15,23,42,0.08);">

                {{-- Header --}}
                <tr>
                    <td style="background:linear-gradient(135deg,#00AEEF 0%,#0090c7 100%); padding:28px 32px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <img src="{{ asset('logo-white.png') }}" alt="CodeSommet" height="28" style="display:block; height:28px;">
                                </td>
                                <td align="right">
                                    <span style="color:#e6f8ff; font-size:12px; letter-spacing:0.04em; text-transform:uppercase;">{{ $eyebrow ?? '' }}</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- Title band --}}
                @isset($heading)
                <tr>
                    <td style="padding:32px 32px 0;">
                        <h1 style="margin:0; font-size:20px; line-height:1.3; color:#0f172a; font-weight:700;">{{ $heading }}</h1>
                        @isset($subheading)
                            <p style="margin:8px 0 0; font-size:14px; color:#64748b; line-height:1.6;">{{ $subheading }}</p>
                        @endisset
                    </td>
                </tr>
                @endisset

                {{-- Body slot --}}
                <tr>
                    <td style="padding:24px 32px 32px;">
                        {{ $slot }}
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="background:#f8fafc; padding:24px 32px; border-top:1px solid #eef2f7;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="font-size:13px; color:#0f172a; font-weight:600;">CodeSommet</td>
                            </tr>
                            <tr>
                                <td style="font-size:12px; color:#94a3b8; padding-top:4px; line-height:1.6;">
                                    Agence de développement web ·
                                    <a href="mailto:codesommet@gmail.com" style="color:#00AEEF; text-decoration:none;">codesommet@gmail.com</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size:11px; color:#cbd5e1; padding-top:12px;">
                                    Vous recevez cet e-mail suite à une action réalisée sur pikassostudio.com.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
