<!DOCTYPE html>
<html>
    <head>
        <title>{{ $title }}{{ $baseTitle }}</title>
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <style type="text/css">
            /* latin-ext */
            @font-face {
              font-family: 'Josefin Sans';
              font-style: normal;
              font-weight: 100;
              src: local('Josefin Sans Thin'), local('JosefinSans-Thin'), url(http://fonts.gstatic.com/s/josefinsans/v9/q9w3H4aeBxj0hZ8Osfi3dyU-eqv6n8lOlIZB5nq_8UM.woff2) format('woff2');
              unicode-range: U+0100-024F, U+1E00-1EFF, U+20A0-20AB, U+20AD-20CF, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
              font-family: 'Josefin Sans';
              font-style: normal;
              font-weight: 100;
              src: local('Josefin Sans Thin'), local('JosefinSans-Thin'), url(http://fonts.gstatic.com/s/josefinsans/v9/q9w3H4aeBxj0hZ8Osfi3d1dBB84BqlWy1BjOnCrU9PY.woff2) format('woff2');
              unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215, U+E0FF, U+EFFD, U+F000;
            }
            /* latin-ext */
            @font-face {
              font-family: 'Josefin Sans';
              font-style: normal;
              font-weight: 400;
              src: local('Josefin Sans'), local('JosefinSans'), url(http://fonts.gstatic.com/s/josefinsans/v9/xgzbb53t8j-Mo-vYa23n5j0LW-43aMEzIO6XUTLjad8.woff2) format('woff2');
              unicode-range: U+0100-024F, U+1E00-1EFF, U+20A0-20AB, U+20AD-20CF, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
              font-family: 'Josefin Sans';
              font-style: normal;
              font-weight: 400;
              src: local('Josefin Sans'), local('JosefinSans'), url(http://fonts.gstatic.com/s/josefinsans/v9/xgzbb53t8j-Mo-vYa23n5ugdm0LZdjqr5-oayXSOefg.woff2) format('woff2');
              unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215, U+E0FF, U+EFFD, U+F000;
            }
            /* latin */
            @font-face {
              font-family: 'Dancing Script';
              font-style: normal;
              font-weight: 400;
              src: local('Dancing Script'), local('DancingScript'), url(https://fonts.gstatic.com/s/dancingscript/v7/DK0eTGXiZjN6yA8zAEyM2Ud0sm1ffa_JvZxsF_BEwQk.woff2) format('woff2');
              unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215, U+E0FF, U+EFFD, U+F000;
            }
        </style>

        <style type="text/css">
            .article {
                border-top: 1px dashed #ccc;
                border-left: 1px dashed #ccc;
                padding-top: 10px;
            }
            .sidebar {
                border-top: 1px dashed #ccc;
            }
            .sidebar ul {
                list-style-type: none;
            }
            .menu-level-1 > .nav-menu-title {
                font-weight: bold;
                font-size: 1.1em;
                border-bottom: 1px dashed #c3c3c3;
                margin-top: 20px;
                margin-bottom: 5px;
            }
            ul[class*="sidebar-level"],
            h1,h2,h3,h4,h5,h6
            {
                font-family: 'Josefin Sans', sans-serif !important;
            }
            .sidebar-level-2 {
                padding:0;
            }
            h1 {
                margin-top: 1.5em;
            }
            h2, h3, h4 {
                margin-top: 1em;
            }
            h5, h6 {
                margin-top: 0.5em;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <h1>{{ str_replace(' - ', '', $title) }}</h1>
                </div>
            </div>
            <div class="row">
                <div class="sidebar col-md-3">
                    {{ $sidebar }}
                </div>
                <div class="article col-md-9">
                    {{ $body }}
                </div>
            </div>
        </div>
    </body>
</html>
