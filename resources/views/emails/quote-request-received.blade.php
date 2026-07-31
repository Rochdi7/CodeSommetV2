<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Nouvelle demande de devis</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; background:#f4f4f5; padding:24px; color:#111827;">
    <table role="presentation" width="100%" style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden;">
        <tr>
            <td style="background:#00AEEF; padding:20px 24px;">
                <h1 style="margin:0; font-size:18px; color:#ffffff;">Nouvelle demande de devis</h1>
            </td>
        </tr>
        <tr>
            <td style="padding:24px;">
                <table role="presentation" width="100%" style="font-size:14px; line-height:1.6;">
                    <tr><td style="padding:4px 0; color:#6b7280; width:180px;">Nom</td><td>{{ $quoteRequest->name }}</td></tr>
                    <tr><td style="padding:4px 0; color:#6b7280;">Email</td><td><a href="mailto:{{ $quoteRequest->email }}">{{ $quoteRequest->email }}</a></td></tr>
                    @if($quoteRequest->phone)
                        <tr><td style="padding:4px 0; color:#6b7280;">T&eacute;l&eacute;phone</td><td>{{ $quoteRequest->phone }}</td></tr>
                    @endif
                    @if($quoteRequest->company)
                        <tr><td style="padding:4px 0; color:#6b7280;">Entreprise</td><td>{{ $quoteRequest->company }}</td></tr>
                    @endif
                    @if($quoteRequest->project_type)
                        <tr><td style="padding:4px 0; color:#6b7280;">Type de projet</td><td>{{ $quoteRequest->project_type }}</td></tr>
                    @endif
                    @if($quoteRequest->budget)
                        <tr><td style="padding:4px 0; color:#6b7280;">Budget</td><td>{{ $quoteRequest->budget }}</td></tr>
                    @endif
                    @if($quoteRequest->timeline)
                        <tr><td style="padding:4px 0; color:#6b7280;">D&eacute;lai souhait&eacute;</td><td>{{ $quoteRequest->timeline }}</td></tr>
                    @endif
                </table>

                @if($quoteRequest->details)
                    <div style="margin-top:16px; padding-top:16px; border-top:1px solid #e5e7eb;">
                        <p style="margin:0 0 6px; color:#6b7280; font-size:14px;">D&eacute;tails du projet</p>
                        <p style="margin:0; font-size:14px; white-space:pre-line;">{{ $quoteRequest->details }}</p>
                    </div>
                @endif
            </td>
        </tr>
    </table>
</body>
</html>
