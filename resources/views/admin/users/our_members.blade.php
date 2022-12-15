<!DOCTYPE html>
<html lang="en">
<head>
  <title>KPA MEMBERS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<!--<body style="background-image: url(https://images.pexels.com/photos/5452196/pexels-photo-5452196.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1); background-repeat: no-repeat; background-size: 100% 100%; background-attachment: fixed;">-->
  <body>

  <!--<nav class="navbar navbar-expand-sm">
    <div class="container-fluid">
      <a href="#" class="navbar-brand">
        <img src="{{ asset('img/logo_kpa.png') }}" alt="KPA Logo" class="img img-thumbnail img-fluid" style="width: 25rem; height: 5rem;">
      </a>
    </div>
  </nav>-->

<div class="container mt-3">
  <h3 class="text-white">Our Members</h3>
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Member No</th>
          <th>Name</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        @foreach($our_members as $member)
        <tr>
          <td>{{ $member->member_no }}</td>
          <td>{{ $member->name }}</td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        {{ $our_members->links() }}
      </tfoot>
      
    </table>
  </div>
</div>

</body>
</html>
