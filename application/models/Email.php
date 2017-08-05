<?php

class Email extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel');
    }

    public function new_subscriber($nama, $email, $telp) {
        $isi_email = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Skyline Invoice Email</title>
    <style type="text/css">
        @import url(http://fonts.googleapis.com/css?family=Lato:400);

        /* Take care of image borders and formatting */

        img {
            max-width: 600px;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        a {
            text-decoration: none;
            border: 0;
            outline: none;
        }

        a img {
            border: none;
        }

        /* General styling */

        td, h1, h2, h3 {
            font-family: Helvetica, Arial, sans-serif;
            font-weight: 400;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100%;
            height: 100%;
            color: #37302d;
            background: #ffffff;
        }

        table {
            border-collapse: collapse !important;
        }

        h1, h2, h3 {
            padding: 0;
            margin: 0;
            color: #ffffff;
            font-weight: 400;
        }

        h3 {
            color: #21c5ba;
            font-size: 24px;
        }

        .important-font {
            color: #21BEB4;
            font-weight: bold;
        }

        .hide {
            display: none !important;
        }

        .force-full-width {
            width: 100% !important;
        }
    </style>

    <style type="text/css" media="screen">
        @media screen {
            /* Thanks Outlook 2013! http://goo.gl/XLxpyl*/
            td, h1, h2, h3 {
                font-family: \'Lato\', \'Helvetica Neue\', \'Arial\', \'sans-serif\' !important;
            }
        }
    </style>

    <style type="text/css" media="only screen and (max-width: 480px)">
        /* Mobile styles */
        @media only screen and (max-width: 480px) {
            table[class="w320"] {
                width: 320px !important;
            }

            table[class="w300"] {
                width: 300px !important;
            }

            table[class="w290"] {
                width: 290px !important;
            }

            td[class="w320"] {
                width: 320px !important;
            }

            td[class="mobile-center"] {
                text-align: center !important;
            }

            td[class="mobile-padding"] {
                padding-left: 20px !important;
                padding-right: 20px !important;
                padding-bottom: 20px !important;
            }

            td[class="mobile-block"] {
                display: block !important;
                width: 100% !important;
                text-align: left !important;
                padding-bottom: 20px !important;
            }

            td[class="mobile-border"] {
                border: 0 !important;
            }

            td[class*="reveal"] {
                display: block !important;
            }
        }
    </style>
</head>
<body class="body" style="padding:0; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none"
bgcolor="#ffffff">
<table align="center" cellpadding="0" cellspacing="0" width="100%" height="100%">
    <tr>
        <td align="center" valign="top" bgcolor="#ffffff" width="100%">

            <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td style="border-bottom: 3px solid #3bcdc3;" width="100%">
                        <center>
                            <table cellspacing="0" cellpadding="0" width="500" class="w320">
                                <tr>
                                    <td valign="top" style="padding:10px 0; text-align:left;" class="mobile-center">
                                    <img src="' . base_url() . 'assets/main/images/logo-2.png">
                                    </td>
                                </tr>
                            </table>
                        </center>
                    </td>
                </tr>
                <tr>
                    <td background="https://www.filepicker.io/api/file/kmlo6MonRpWsVuuM47EG" bgcolor="#8b8284"
                    valign="top"
                    style="background: url(https://www.filepicker.io/api/file/kmlo6MonRpWsVuuM47EG) no-repeat center; background-color: #8b8284; background-position: center;">
                        <!--[if gte mso 9]>
                        <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false"
                                style="mso-width-percent:1000;height:303px;">
                            <v:fill type="tile" src="https://www.filepicker.io/api/file/kmlo6MonRpWsVuuM47EG"
                                    color="#8b8284"/>
                            <v:textbox inset="0,0,0,0">
                            <![endif]-->
                            <div>
                                <center>
                                    <table cellspacing="0" cellpadding="0" width="530" height="303" class="w320">
                                        <tr>
                                            <td valign="middle"
                                            style="vertical-align:middle; padding-right: 15px; padding-left: 15px; text-align:left;"
                                            height="303">

                                            <table cellspacing="0" cellpadding="0" width="100%">
                                                <tr>
                                                    <td>
                                                        <h1>Selamat Datang di Adroit Apps Services</h1><br>
                                                        <h2>Anda dapat dengan mudah terhubung dengan produk IoT dari
                                                            Adroit Devs.</h2>
                                                            <br>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </td>
                                        </tr>
                                    </table>
                                </center>
                            </div>
                        <!--[if gte mso 9]>
                        </v:textbox>
                        </v:rect>
                        <![endif]-->
                    </td>
                </tr>
                <tr>
                    <td valign="top">

                        <center>
                            <table cellspacing="0" cellpadding="0" width="500" class="w320">
                                <tr>
                                    <td valign="top" style="border-bottom:1px solid #a1a1a1;">


                                        <table cellspacing="0" cellpadding="0" width="100%">
                                            <tr>
                                                <td style="padding: 30px 0;" class="mobile-padding">

                                                    <table class="force-full-width" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td style="text-align: left;">
                                                                Salam ' . $nama . ', <br><br>
                                                                Adroit Devs menyediakan berbagai solusi untuk masalah
                                                                Anda melalui produk IoT kami yang terhubung dengan
                                                                platform Adroit Apps Service dan aplikasi yang terhubung
                                                                di gawai Anda.
                                                                <br>
                                                                <br>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: left;">
                                                              <span class="important-font">
                                                                Apa yang Baru?<br><br>
                                                            </span>
                                                            Angkat.In sebagai produk keluaran pertama Adroit Devs
                                                            dapat mempermudah kegiatan mencuci Anda dengan banyak
                                                            fitur yang akan Anda sukai.<br>
                                                            <ul>
                                                                <br>
                                                                <li>Alat yang terhubung dengan gawai</li>
                                                                <br>
                                                                <li>Aplikasi yang mudah digunakan</li>
                                                                <br>
                                                                <li>Responsif dan menarik</li>
                                                                <br>
                                                                <li>Penyimpanan data berbasis cloud</li>
                                                                <br>
                                                                <li>Data Realtime</li>
                                                                <br>
                                                                <li>Pemilihan kendali melalui gawai pintar</li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <tr>
                                                <td style="padding: 30px 0;" class="mobile-padding">
                                                    <table class="force-full-width" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td style="text-align: left;" colspan="3">
                                                                <div>
                                                                <center>
                                                                    <a href="' . base_url() . 'landing/pre_order?email=' . $email . '"
                                                                    style="background-color:#3bcdc3;border-radius:4px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;font-weight:bold;line-height:40px;text-align:center;text-decoration:none;width:150px;-webkit-text-size-adjust:none;">Pesan
                                                                    Sekarang</a>
                                                                    </center>
                                                                </div>
                                                            </td>

                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>
                                        </tr>
                                        <tr>
                                            <td class="mobile-padding">

                                                <table cellspacing="0" cellpadding="0" width="100%">
                                                    <tr>
                                                        <td style="text-align: left;">
                                                            <br>
                                                            Terima kasih telah berlanggan dan dapatkan berbagai
                                                            penawaran menarik lainnya.
                                                            <br>
                                                            <br>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <table cellspacing="0" cellpadding="0" width="500" class="w320">
                            <tr>
                                <td>
                                    <table cellspacing="0" cellpadding="0" width="100%">
                                        <tr>
                                            <td class="mobile-padding" style="text-align:left;">
                                                <br>
                                                Anda dapat menghubungi kami di <a href="' . base_url() . '#contact">link berikut</a> untuk
                                                segala pertanyaan mengenai produk
                                                kami <br>
                                                <br>
                                                Adroit Devs.
                                                <br>
                                                <br>
                                                <br>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>
            <tr>
                <td style="background-color:#c2c2c2;">
                    <center>
                        <table cellspacing="0" cellpadding="0" width="500" class="w320">
                            <tr>
                                <td>
                                    <center>
                                        <table style="margin:0 auto;" cellspacing="0" cellpadding="5" width="100%">
                                            <tr>
                                                <td style="text-align:center; margin:0 auto;" width="100%">
                                                    <a href="#" style="text-align:center;">
                                                        <img style="margin:0 auto;"
                                                        src="' . base_url() . 'assets/main/images/logo.png"/>
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </center>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>
</body>
</html>
        ';

        $sender_email = 'customeradroit@gmail.com';
        $user_password = '@Adroitisthebest1#!';
        $receiver_email = $email;
        $subject = 'Selamat Datang Di Adroit Apps Service!';
        $message = $isi_email;

        // Configure email library
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
        $config['smtp_port'] = 465;
        $config['smtp_user'] = $sender_email;
        $config['smtp_pass'] = $user_password;
        $config['mailtype'] = 'html';

        // Load email library and passing configured values to email library
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");

        // Sender email address
        $this->email->from('customeradroit@gmail.com', "Adroit Apps Service");
        // Receiver email address
        $this->email->to($receiver_email);
        // Subject of email
        $this->email->subject($subject);
        // Message in email
        $this->email->message($message);

        if ($this->email->send()) {
            return true;
        } else {
            return false;
        }
    }
}