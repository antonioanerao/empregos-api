<div style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#8d3132;color:#8d3132;height:100%;line-height:1.4;margin:0;width:100%!important;word-break:break-word">
    <table class="m_-6522219658115661125wrapper" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#8d3132;margin:0;padding:0;width:100%">
        <tbody><tr>
            <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                <table class="m_-6522219658115661125content" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:0;padding:0;width:100%">
                    <tbody><tr>
                        <td class="m_-6522219658115661125header" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:25px 0;text-align:center">
                            <a href="{{ env('APP_URL') }}" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#ffffff;font-size:19px;font-weight:bold;text-decoration:none" target="_blank">
                                {!! env('APP_NAME')  !!}
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="m_-6522219658115661125body" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;border-bottom:1px solid #edeff2;border-top:1px solid #edeff2;margin:0;padding:0;width:100%">
                            <table class="m_-6522219658115661125inner-body" align="center" width="570" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;margin:0 auto;padding:0;width:570px">
                                <tbody>
                                <tr>
                                    <td class="m_-6522219658115661125content-cell" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:35px">
                                        <h1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:left">Olá, {{ $user->name }} </h1>
                                        <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                            Você está recebendo este e-mail porque você solicitou uma redefinição de senha para sua conta.
                                        </p>

                                        <table class="m_-6522219658115661125action" align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:30px auto;padding:0;text-align:center;width:100%">
                                            <tbody>
                                            <tr>
                                                <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                                        <tbody><tr>
                                                            <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                                                <table border="0" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                                                    <tbody><tr>
                                                                        <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                                                            <a href="{{ $url_back }}?email={{ $user->email }}&token={{ $token }}" class="m_-6522219658115661125button m_-6522219658115661125button-blue" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;border-radius:3px;color:#fff;display:inline-block;text-decoration:none;background-color:#3097d1;border-top:10px solid #3097d1;border-right:18px solid #3097d1;border-bottom:10px solid #3097d1;border-left:18px solid #3097d1" target="_blank">Redefinir Agora</a>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class="m_-6522219658115661125subcopy" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;border-top:1px solid #edeff2;margin-top:25px;padding-top:25px">
                                            <tbody>
                                            <tr>
                                                <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                                    <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;line-height:1.5em;margin-top:0;text-align:left;font-size:12px">Se você está tendo problemas para clicar no botão "Acessar Conta", copie e cole o link a seguir
                                                        em seu navegador: <a href="{{ $url_back }}?email={{ $user->email }}&token={{ $token }}" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#3869d4" target="_blank" >{{ $url_back }}?email={{ $user->email }}&token={{ $token }}</a></p>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                            <table class="m_-6522219658115661125footer" align="center" width="570" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:0 auto;padding:0;text-align:center;width:570px">
                                <tbody>
                                <tr>
                                    <td class="m_-6522219658115661125content-cell" align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:35px">
                                       <!-- footer do e-mail -->
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody></table><div class="yj6qo"></div><div class="adL">
    </div></div>
