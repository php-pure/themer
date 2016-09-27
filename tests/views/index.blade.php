<!DOCTYPE html>
<html>
<head>
    <title>{{ $base_title }}</title>
</head>
<body>
  <div class="row">
    <div class="sidebar hidden-xs hidden-sm col-md-3">
        {!! $sidebar !!}
    </div>
    <div class="article col-md-9 col-sm-12">
        {!! $body !!}
    </div>
  </div>
</body>
</html>
