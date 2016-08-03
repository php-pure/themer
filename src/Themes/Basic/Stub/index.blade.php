<!DOCTYPE html>
<html>
    <head>
        <title>{{ $title }}{{ $baseTitle }}</title>
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <style type="text/css">
            .article {
                border-left: 1px dotted #ccc;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <section class="sidebar col-md-3">
                    {{ $navigation }}
                </section>
                <div class="article col-md-9">
                    {{ $body }}
                </div>
            </div>
        </div>
    </body>
</html>
