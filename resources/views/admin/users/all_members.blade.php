<!DOCTYPE html>
<html lang="en">
<head>
  <title>KPA MEMBERS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <img src="{{ asset('img/logo_kpa.png') }}" class="img img-thumbnail img-fluid" style="width: 10rem; height: 5rem;">
  <h2>KPA MEMBERS</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Member No</th>
        <th>Name</th>
      </tr>
    </thead>
    <tbody>
      @foreach($all_members as $member)
      <tr>
        <td>{{ $member->member_no }}</td>
        <td>{{ $member->name }}</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      {{ $all_members->links() }}
    </tfoot>
    
  </table>
</div>

</body>
</html>
